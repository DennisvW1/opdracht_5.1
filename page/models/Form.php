<?php
include MODELROOT."Autoloader.php";

class Form extends HtmlDoc
{
    public $page;
    protected $action;
    protected $method = "POST";
    protected $submitValue = "Submit";
    private $arr_postresult = array();
    private $db;
    
    // declare Array property
    protected $form_Array = array ();

    public function __construct($page, $action, $method, $submitValue)
    {
        $this->page = $page;
        $this->action = $action;
        $this->method = $method;
        $this->submitValue = $submitValue;
    }

    // method to show the requested form
    public function showContent()
    {
        $val = new FormValidator($_POST);
        $val = $val->validateForm();
        // if form has been posted correctly show submitted successfully and add to database
        if(!empty($val['all_ok']))
        {
            switch($_POST['page'])
            {
                case "contact":
                    echo "<div class='row mt-3'>
                        <div class='col'></div>
                            <div class='col'>Name:</div>
                                <div class='col'>".$val['name']."</div>
                                    <div class='col'></div></div>";
                    echo "<div class='row'>
                        <div class='col'></div>    
                            <div class='col'>Email: </div>
                                <div class='col'>".$val['email']."</div>
                                    <div class='col'></div></div>";
                    echo "<div class='row'>
                        <div class='col'></div>
                            <div class='col'>Message: </div>
                                <div class='col'>".$val['message']."</div>
                                    <div class='col'></div></div></div>";
                    break;
            }
        }
        // if form has not been posted correctly show the form
        else
        {
            $this->getFormType();
            $this->startForm();
            $this->getFormContent();
            $this->closeForm();
        }
    }

    private function getFormType()
    {
        switch ($this->page)
        {
            case "contact":
                $this->form_Array = array
                (
                    "name" 		=> array("type" => "text", 		
                                         "label"=> "Your name:",
                                         "placeholder" => "Enter your name",
                                        ),		
                    "email" 	=> array("type" => "email",
                                         "label"=> "Your email:",
                                         "placeholder" => "Enter your email address",
                                        ),	
                    "message" 	=> array("type" => "textarea",
                                         "label"=> "Your message:",
                                         "placeholder" => "Enter your message",
                                        )	
                );
                break;
            case "login":
                $this->form_Array = array(
                    "email" 		=> array("type" => "text", 		
                                         "label"=> "Email:",
                                         "placeholder" => "Enter your email",
                                        ),		
                    "password" 	=> array("type" => "password",
                                         "label"=> "Password:",
                                         "placeholder" => "Enter your password"
                ));
                break;

            case "register":
                $this->form_Array = array(
                    "name" 		=> array("type" => "text", 		
                                            "label"=> "Your name:",
                                            "placeholder" => "Enter your name",
                                        ),		
                    "email" 	=> array("type" => "email",
                                            "label"=> "Your email:",
                                            "placeholder" => "Enter your email address",
                                        ),
                    "password" 	=> array("type" => "password",
                                            "label"=> "Your password:",
                                            "placeholder" => "Enter your password",
                                        ),
                    "passwordrepeat" 	=> array("type" => "password",
                                            "label"=> "Your password again:",
                                            "placeholder" => "Repeat your password"
                ));
                break;

            return $this->form_Array;
        }
        
    }

    private function startForm()
    {
        echo "<form action='$this->action' method='$this->method'>";
        echo "<input type='hidden' name='page' value='$this->page'>";
        echo "<div class='mb-3'>
                <div class='h1'>".ucfirst($this->page)."</div>
                <div class='row pt-3'>";
    }

    private function getFormContent()
    {

        foreach ($this->form_Array as $fieldname => $fieldinfo)
        {
            $current_value = (isset($this->arr_postresult[$fieldname]) ? $this->arr_postresult[$fieldname] : '');
            echo "<div class='col'><label class='form-label' for='.$fieldname.'>".$fieldinfo['label'].'</label></div>';
            echo "<div class='col'><label class='form-label'></label></div>";
            echo "<div class='row'>";
            switch ($fieldinfo['type'])
            {
                case "textarea" :
                    if(isset($_POST[$fieldname]))
                    {
                    echo "<div class='col'><textarea class='form-control' name=$fieldname placeholder='".$fieldinfo['placeholder']."'>$_POST[$fieldname]</textarea></div>";
                    break;    
                    }
                    else
                    {
                    echo "<div class='col'><textarea class='form-control' name=$fieldname placeholder='".$fieldinfo['placeholder']."'></textarea></div>";
                    break;
                    }
                    
                
                default :
                if(isset($_POST[$fieldname]))
                {
                    echo "<div class='col'><input class='form-control' type='".$fieldinfo['type']."' name='".$fieldname."' placeholder='".$fieldinfo['placeholder']."' value='".$_POST[$fieldname]."'></div>";
                    break;

                }
                else
                {
                    echo "<div class='col'><input class='form-control' type='".$fieldinfo['type']."' name='".$fieldname."' placeholder='".$fieldinfo['placeholder']."'></div>";
                    break;
                }

            }
            echo "<div class='col'>";
            if(isset($_SESSION[$fieldname]) && str_starts_with($_SESSION[$fieldname], "*"))
            {
            echo "<span class='alert alert-danger'>$_SESSION[$fieldname]</span>";
            unset($_SESSION[$fieldname]);
            }
            echo "</div></div>";
        }
    }

    private function closeForm()
    {
        echo "<div class='row pt-3'><div class='col'><button class='btn btn-dark' type='submit' value='submit'>$this->submitValue</button>";
        echo "</div></div></form>";
    }
}