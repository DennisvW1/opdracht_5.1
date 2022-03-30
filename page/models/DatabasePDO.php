<?php

class DatabasePDO implements IDatabase
{
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_NAME;

    private $statement;
    private $dbHandler;
    private $error;

    public function __construct()
    {
        $conn = "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try
        {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        }
        catch(PDOException $e)
        {
            $this->error = $e->getMessage();
            Logging::LogCsv($this->error,LogLevel::CRIT);
            echo $this->error;
        }
    }

    // query method
    public function query($sql)
    {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    // bind values
    public function bind($param, $value, $type = null)
    {
        switch (is_null($type))
        {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($param, $value, $type);
    }

    // execute prepared statement
    public function execute()
    {
        $this->statement->execute();
    }

    //return an array
    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    // return a specific row as an object
    public function single()
    {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);  
    }

    // get the row count
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    // start a transaction
    public function openTransaction()
    {
        $this->dbHandler->beginTransaction();
    }

    // commit the transaction when no issues
    public function commitTransaction()
    {
        $this->dbHandler->commit();
    }

    // rollback the transaction in case something failed
    public function rollBackTransaction()
    {
        $this->dbHandler->rollBack();
    }

    // get the last inserted id
    public function lastInsertId()
    {
        $id = $this->dbHandler->lastInsertId();
        return $id;
    }

    // ======================================
    // Users
    // ======================================

    public function insertContact($check)
    {
        try
        {
            $this->query("INSERT INTO contact (contact_name, contact_email, contact_message) VALUES (:name, :email, :message)");
            $this->bind("name",$check['name']);
            $this->bind("email",$check['email']);
            $this->bind("message",$check['message']);
            $this->execute();
        }
        catch(PDOException $e)
        {
            $this->error = $e->getMessage();
            Logging::LogCsv($this->error,LogLevel::HIGH);
            return $this->error;
        }
    }


    // ======================================
    // Users
    // ======================================

    public function getName($email)
    {
        $this->query("SELECT naam FROM gebruikers WHERE email=:email");
        $this->bind("email", $email);
        $name = $this->single();
        $name = $name->naam;
        return $name;
    }

    public function getLevel($email)
    {
        $this->query("SELECT user_level FROM gebruikers WHERE email=:email");
        $this->bind("email", $email);
        $result = $this->single();
        return $result->user_level;
    }

    public function getId($email)
    {
        $this->query("SELECT id FROM gebruikers WHERE email=:email");
        $this->bind("email", $email);
        $result = $this->single();
        return $result->id;
    }

    public function insertRegister($check)
    {
        try
        {
            $option = array("cost", 5);
            $password = password_hash($check['password'], PASSWORD_DEFAULT, $option);
            $this->query("INSERT INTO gebruikers (naam, email, wachtwoord, user_country, user_state, user_city) VALUES (:name, :email, :password, :country, :state, :city)");
            $this->bind("name",$check['name']);
            $this->bind("email",$check['email']);
            $this->bind("password",$password);
            $this->bind("country",$check['country']);
            $this->bind("state",$check['state']);
            $this->bind("city",$check['city']);
            $this->execute();
        }
        catch(PDOException $e)
        {
            $this->error = $e->getMessage();
            Logging::LogCsv($this->error,LogLevel::HIGH);
            echo $this->error;
        }
    }

    public function changePassword($check)
    {
        try
        {
            $id = $_SESSION['user_id'];
            $option = array("cost", 5);
            $password = password_hash($check['password'], PASSWORD_DEFAULT, $option);
            $this->query("UPDATE gebruikers SET wachtwoord = :password WHERE id = :id");
            $this->bind("password", $password);
            $this->bind("id", $id);
            $this->execute();
            Messages::setMessage("Password changed succesfully", "succes");
        }
        catch (Exception $e)
        {
            $this->error = $e->getMessage();
            Logging::LogCsv($this->error, LogLevel::HIGH);
            echo $this->error;
        }
    }

    public function changeLocation($check)
    {
        try
        {
            $id = $_SESSION['user_id'];
            $this->query("UPDATE gebruikers SET user_country=:country, user_state=:state, user_city=:city WHERE id=:id");
            $this->bind("country",$check['country']);
            $this->bind("state",$check['state']);
            $this->bind("city",$check['city']);
            $this->bind("id", $id);
            $this->execute();
            Messages::setMessage("Country changed succesfully", "succes");
        }

        catch(Exception $e)
        {
            $this->error = $e->getMessage();
            Logging::LogCsv($this->error, LogLevel::MID);
            echo $this->error;
        }
    }

    public function getCountries()
    {
        $this->query("SELECT * FROM countries ORDER BY id");
        $result = $this->resultSet();

        return $result;
    }

    public function getStates($id, $state = 0)
    {
        $this->query("SELECT * FROM states WHERE country_id=$id ORDER BY id");
        $result = $this->resultSet();

        if($state == 0)
        {
            echo "<option value=0 disabled selected>Please select your state</option>";
        }
        else
        {
            echo "<option value=0 disabled>Please select your state</option>";
        }

        foreach ($result as $row)
        {
            if($state == $row->id)
            {
                echo "<option value='" . $row->id . "' selected>" . $row->name ."</option>";
            }
            else
            {
                echo "<option value='" . $row->id . "'>" . $row->name ."</option>";
            }

        }

    }

    public function getCities($id, $city = 0)
    {
        $this->query("SELECT * FROM cities WHERE state_id=$id ORDER BY name");
        $result = $this->resultSet();

        if($city == 0)
        {
            echo "<option value=0 disabled selected>Please select your city</option>";
        }
        else
        {
            echo "<option value=0 disabled>Please select your city</option>";
        }

        foreach ($result as $row)
        {
            if($city == $row->id)
            {
                echo "<option value='" . $row->id . "' selected>" . $row->name ."</option>";
            }
            else
            {
                echo "<option value='" . $row->id . "'>" . $row->name ."</option>";
            }

        }

    }

    public function getCountryName($id)
    {
        $this->query("SELECT name FROM countries WHERE id = $id");
        $result = $this->single();
        return $result;
    }

    public function getStateName($id)
    {
        $this->query("SELECT name FROM states WHERE id = $id");
        $result = $this->single();
        return $result;
    }

    public function getCityName($id)
    {
        $this->query("SELECT name FROM cities WHERE id = $id");
        $result = $this->single();
        return $result;
    }

    public function getUserCountry($id)
    {
        $this->query("SELECT user_country FROM gebruikers WHERE id = $id");
        $country = $this->single();
        $result = $country->user_country;
        return $result;
    }

    public function getUserState($id)
    {
        $this->query("SELECT user_state FROM gebruikers WHERE id = $id");
        $state = $this->single();
        $result = $state->user_state;
        return $result;
    }

    public function getUserCity($id)
    {
        $this->query("SELECT user_city FROM gebruikers WHERE id = $id");
        $city = $this->single();
        $result = $city->user_city;
        return $result;
    }

    // ============================================
    // Products 
    // ============================================
    public function getAllProducts()
    {
        $this->query("SELECT * FROM producten");
        $result = $this->resultSet();

        return $result;
    }

    public function getSoldItems($amount)
    {
        $this->query("SELECT producten.productnaam, producten.productid, sum(bestelde_items.productaantal) as sum
        FROM producten
        INNER JOIN bestelde_items ON bestelde_items.productid=producten.productid
        GROUP BY producten.productnaam
        ORDER BY sum
        desc limit $amount");
        $result = $this->resultSet();

        return $result;
    }

    public function getProduct($postId)
    {
        $this->query("SELECT * FROM producten WHERE productid=:id");
        $this->bind("id",$postId,PDO::PARAM_INT);
        $row = $this->single();

        return $row;
    }

    public function getRating($id)
    {
        $this->query("SELECT p.*, COUNT(r.rating_number) as rating_num, FORMAT((AVG(r.rating_number)),1) as average_rating 
                        FROM producten as p 
                        LEFT JOIN rating as r 
                        ON r.productid = p.productid 
                        WHERE p.productid = $id
                        GROUP BY (r.productid)"); 
        return $this->single();
        
    }

    public function getBestRatedProduct($amount)
    {
        $this->query("SELECT producten.productnaam, producten.productid, count(rating.productid) as aantal, avg(rating.rating_number) as avg
        FROM producten
        INNER JOIN rating ON rating.productid=producten.productid
        GROUP BY producten.productnaam
        ORDER BY avg 
        DESC limit $amount");
        $result = $this->resultSet();
        
        return $result;
    }

    public function getAverageRating($id)
    {
        $this->query("SELECT COUNT(rating_number) as rating_num, FORMAT((SUM(rating_number) / COUNT(rating_number)),1) as average_rating FROM rating WHERE productid = $id GROUP BY productid"); 
        $data = $this->single();
        return $data;
    }

    public function insertRating($prodID, $ratingNum, $userID, $userIP)
    {
        $query = "INSERT INTO rating (productid,rating_number,gebruiker_id,user_ip) VALUES ('".$prodID."', '".$ratingNum."', '".$userID."', '".$userIP."')"; 
        $this->query($query); 
        $this->execute(); 
    }


    public function insertCart()
    {
        $this->openTransaction();
        try
        {
            // determine user ID
            $gebruikersId = $this->getId($_SESSION['user_email']);
        
            // Write into bestelling with user ID
            $this->query('INSERT INTO bestelling (gebruikerid) VALUES (:id)');
            $this->bind("id",$gebruikersId);
            $this->execute();
            $bestellingId = $this->lastInsertId();
            
            //write into bestelde_tems for each product that is in the shopping cart array
            foreach ($_SESSION["cart"] as $product)
            {
                $productId = $product['id'];
                $productAmount = $product['quantity'];
                $productPrice = $product['price'];

                $this->query('INSERT INTO bestelde_items (bestellingid,productid,productaantal,productprijs) VALUES (?,?,?,?)');
                $this->bind(1,$bestellingId);
                $this->bind(2,$productId);
                $this->bind(3,$productAmount);
                $this->bind(4,$productPrice);
                $this->execute();
                $_SESSION["checkout_success"] = true;
            }
            $this->commitTransaction();
            }
        catch(Exception $e)
        {
            $this->rollBackTransaction();
            $this->error = $e->getMessage();
            Logging::LogCsv($this->error,LogLevel::HIGH);
            echo $this->error;
        }
    }

    public function getLastOrder($gebruikersId)
    {
        $this->query("SELECT bestellingid FROM bestelling WHERE gebruikerid=$gebruikersId ORDER BY bestellingid DESC LIMIT 1");
        $row = $this->single();
        $row = $row->bestellingid;
        return $row;
    }

    public function getOrderDetails($gebruikersId, $lastOrder)
    {
        try
        {
            $this->query("
            SELECT bestelling.bestellingid, bestelling.gebruikerid, bestelde_items.bestellingid, bestelde_items.productid, producten.productnaam, bestelde_items.productaantal, bestelde_items.productprijs
            FROM bestelde_items
            INNER JOIN bestelling ON bestelling.bestellingid=bestelde_items.bestellingid
            INNER JOIN producten ON producten.productid=bestelde_items.productid
            WHERE bestelling.gebruikerid=$gebruikersId AND bestelling.bestellingid=$lastOrder");
    
            $row = $this->resultSet();

            return $row;

        }
        catch(Exception $e)
        {
            $this->error = $e->getMessage();
            return $this->error;
        }
    }

    public function getTotalPrice($gebruikersId, $lastOrder)
    {
        try
        {
            $this->query("SELECT bestelde_items.bestellingid, SUM(bestelde_items.productprijs * bestelde_items.productaantal) AS TOTAL 
            FROM bestelde_items 
            JOIN bestelling
            ON bestelde_items.bestellingid = bestelling.bestellingid
            WHERE bestelling.gebruikerid = $gebruikersId AND bestelling.bestellingid = $lastOrder");

            $row = $this->single();
            $total_price = $row->TOTAL;
            return $total_price;
        }
        catch(Exception $e)
        {
            $this->error = $e->getMessage();
            return $this->error;
        }
    }

    public function checkIfRated($prodID, $userID)
    {
        $this->query("SELECT rating_number FROM rating WHERE productid = $prodID AND gebruiker_id = $userID"); 
        $this->execute();
        return $this->rowCount();
    }

    public function logToDatabase($data)
    {
        $this->query("INSERT INTO log (type, ip, username, userid, page, text, lognumber, time_to_log) VALUES (:type, :ip, :username, :userid, :page, :text, :lognumber, :time_to_log)");
        $this->bind("type", $data["type"]);
        $this->bind("ip", $data["ip"]);
        $this->bind("username", $data["username"]);
        $this->bind("userid", $data["userid"]);
        $this->bind("page", $data["page"]);
        $this->bind("text", $data["text"]);
        $this->bind("lognumber", $data["lognumber"]);
        $this->bind("time_to_log", $data["time_to_log"]);

        $this->execute();
    }
} // end class