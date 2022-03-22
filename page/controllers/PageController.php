<?php
require_once MODELROOT."Autoloader.php";
class PageController extends Controller
{

    protected function showResponse()
    {
        $collection = new ElementCollection(); 
        $collection->addElement(new Menu()); 

        switch ($this->response['page'])
        {
            case "home":
                $collection->addElement(new TextElement("home")); 
                break;
            case "about":
                $collection->addElement(new TextElement("about")); 
                break;
            case "contact":
                $collection->addElement(new Form("contact","","POST","Contact")); 
                break;
            case "register":
                $collection->addElement(new Form("register","","POST","Register")); 
                break;
            case "login":
                $collection->addElement(new Form("login","","POST","Login")); 
                break;
            case "webshop":
                $collection->addElement(new PageModel("webshop")); 
                break;
            case "product":
                $collection->addElement(new PageModel("product")); 
                break;
            case "cart":
                $collection->addElement(new PageModel("cart")); 
                break;
            case "best sold":
                $collection->addElement(new PageModel("overview")); 
                break;
            case "admin":
                    $collection->addElement(new PageModel("admin")); 
                break;
            default:
                $collection->addElement(new TextElement("home")); 
        } 
        
        $collection->addElement(new Footer()); 
        $collection->showElements();
    }

    protected function getRequest()
     {
         $posted = ($_SERVER['REQUEST_METHOD']==='POST');
         $this->request = 
             [
                 'posted'   => $posted,
                 'page'     => $this->getRequestVar('page', $posted, 'home')    
             ];
     }
     
     protected function validateRequest()
     {
        $this->response = $this->request;

        // ----------------------------
        // for POST requests
        // ----------------------------
        
        if ($this->request['posted'])
        {
            $check = new FormValidator($_POST);
            $check = $check->validateForm();
            $this->db = new DatabasePDO();
            // ----------------------------
            // check if all_ok is set in the array
            // ----------------------------
            if(isset($check['all_ok']))
            {
                // ----------------------------
                // if it is set and if all_ok is true
                // ----------------------------
                if($check['all_ok'])
                {
                    switch ($this->request['page'])
                    {
                        case "contact":
                            $this->db->insertContact($check);
                            Logging::LogCsv("Contact form submitted successfully", LogLevel::LOW);
                            Messages::setMessage("Form has been submitted successfully!", "success");
                            // stay on contact page
                            $this->response['page'] = "contact";
                            break;
                        case "register":
                            $this->db->insertRegister($check);
                            // clear POST super global
                            $_POST = array();
                            // set message succusfully registered and log it
                            Messages::setMessage("Registered successfully, you can login now!", "success");
                            Logging::LogCsv("User registered successfully", LogLevel::LOW);
                            // redirect to login page
                            $this->response['page'] = "login";
                            break;
                        case "login":
                            // get the user name from the database    
                            $name = $this->db->getName($check['email']);
                            $id = $this->db->getId($check['email']);
                            // set session variables
                            $_SESSION['user_name'] = $name;
                            $_SESSION['user_id'] = $id;
                            $_SESSION['user_email'] = $check['email'];
                            $_SESSION['user_level'] = $this->db->getLevel($check['email']);
                            Messages::setMessage("You have successfully logged in!","succes");
                            Logging::LogCsv("User logged in successfully",LogLevel::NONE);
                            // clear out the post array
                            $_POST = array();
                            // redirect to home page
                            $this->response['page'] = "home";
                            break;
                    }
                }
                // -------------------------------- 
                // if the all_ok is false
                // --------------------------------
                else
                {
                    switch($this->request['page'])
                    {
                        case "contact":
                            $fieldname = array("name","email","message");
                            foreach ($fieldname as $fieldname)
                            {
                                    $_SESSION[$fieldname] = $check[$fieldname] ?? "";
                            }
                            Logging::LogCsv("Contact form failed name: ".$check['name']." Email: ".$check['email']." Message: ".$check['message'],LogLevel::LOW);                   
                            break;
                        case "register":
                            $fieldname = array("name","email","password","passwordrepeat");
                            foreach ($fieldname as $fieldname)
                            {
                                    $_SESSION[$fieldname] = $check[$fieldname] ?? "";
                            }
                            Logging::LogCsv("Registering failed name: ".$check['name']." Email: ".$check['email'],LogLevel::LOW);                   
                            break;
                        case "login":
                            $fieldname = array("email","password");
                            foreach ($fieldname as $fieldname)
                            {
                                    $_SESSION[$fieldname] = $check[$fieldname] ?? "";
                            }
                            Logging::LogCsv("User login failed ".$check['email'],LogLevel::LOW);
                            break;
                    }
                }
            }
            // ---------------------------- 
            // if the all_ok is not set in the array
            // ----------------------------
            else
            {
                switch ($this->request['page'])
                {
                    case "bestel":
                        // ----------------------------
                        // Add to shopping cart
                        // ----------------------------
                        if (isset($_POST['id']) && $_POST['id']!="")
                        {
                            $row = $this->db->getProduct($_POST['id']);
                            $id = $row->productid;
                            $name = $row->productnaam;
                            $price = $row->productprijs;
                            
                            // ----------------------------
                            // create the shopping cart array
                            // ----------------------------
                            $cartArray = array(
                            $name=>array(
                                'name'=>$name,
                                'id'=>$id,
                                'price'=>$price,
                                'quantity'=>1
                                ));

                            if(empty($_SESSION["cart"]))
                            {
                                $_SESSION["cart"] = $cartArray;
                                Logging::LogCsv("Product ".$name." added to cart",LogLeveL::LOW, "cart");
                                Messages::setMessage("Product is added to your shopping cart! <a href='index.php?page=cart' class='alert-link'>Go to the shopping cart</a>", "success");
                            }
                            else
                            {
                                $array_keys = array_keys($_SESSION["cart"]);
                                if(in_array($name,$array_keys))
                                {
                                    Logging::LogCsv("Tried to add ".$name.", while already in cart",LogLeveL::LOW, "cart");
                                    Messages::setMessage("Product is already in your shopping cart, order more in the <a href='index.php?page=cart' class='alert-link'>shopping cart</a>!", "error");
                                }
                                else
                                {
                                $_SESSION["cart"] = array_merge($_SESSION["cart"],$cartArray);
                                Logging::LogCsv("Product ".$name." added to cart",LogLeveL::LOW, "cart");
                                Messages::setMessage("Product is added to your shopping cart! <a href='index.php?page=cart' class='alert-link'>Go to the shopping cart</a>", "success");
                                }
                            }
                        }
                        $this->response['page'] = "webshop";
                        break;
                    case 'change':
                        // change quantity of the product in the shopping cart
                        foreach($_SESSION["cart"] as &$value){
                            if($value["name"] === $_POST["name"]){
                                $value["quantity"] = $_POST["quantity"];
                                Logging::LogCsv("Amount changed in cart for ".$value["name"]." to ".$value["quantity"],LogLevel::LOW);
                                Messages::setMessage("Order amout of ".$value["name"]." has been changed!", "success");
                            }
                        }
                        $this->response['page'] = 'cart'; 
                        break;
                    case "afrekenen":
                        $this->db->insertCart();
                        Logging::LogCsv("Order successfully placed",LogLevel::LOW);
                        $this->response['page'] = 'cart'; 
                        break;
                    case "delete":
                        $item = $_POST['delete'];
                        Logging::LogCsv("Item deleted from cart ".$item,LogLevel::NONE);
                        unset($_SESSION['cart'][$item]);
                        Messages::setMessage("Product $item has been deleted from the cart!", "success");
                        $this->response['page'] = 'cart'; 
                        break;
                }
            }
        }
        else
        {
            // ----------------------------
            // for GET requests
            // ----------------------------
            switch ($this->request['page'])
            {
            case "logout":
                Logging::LogCsv("User logged off successfully",LogLevel::NONE);
                session_unset();
                session_destroy();
                Messages::setMessage("Logged off successfully, see you soon!", "success");

                $this->response['page'] = "home";
                break;
            case "product":
                if(isset($_GET['id']))
				{
					$pageReq['page'] = 'product';
				}
				else
				{
					$pageReq['page'] = 'webshop';
				}
            case "admin":
                if(isset($_GET['admin']))
                {
                    $pageReq['page'] = "admin";
                    // $this->page = new Admin("change name");
                    // $this->page->showContent();;
                }
                else
                {
                    $pageReq['page'] = 'webshop';
                }
            }
         }
     }

     protected function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
     {
         $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_DEFAULT;
         $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
         return ($result===FALSE) ? $default : $result;
     }
}
