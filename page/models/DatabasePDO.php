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

    public function openTransaction()
    {
        $this->dbHandler->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->dbHandler->commit();
    }

    public function rollBackTransaction()
    {
        $this->dbHandler->rollBack();
    }

    public function lastInsertId()
    {
        $id = $this->dbHandler->lastInsertId();
        return $id;
    }

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
        $level = $this->single();
        $level = $level->user_level;
        return $level;
    }

    public function getId($email)
    {
        $this->query("SELECT id FROM gebruikers WHERE email=:email");
        $this->bind("email", $email);
        $id = $this->single();
        $id = $id->id;
        return $id;
    }

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

    public function getProduct($id)
    {
        $postId = $id;
        $this->query("SELECT * FROM producten WHERE productid=:id");
        $this->bind("id",$postId,PDO::PARAM_INT);
        $row = $this->single();

        return $row;
    }

    public function getRating($id)
    {
        $this->query("SELECT p.*, COUNT(r.rating_number) as rating_num, FORMAT((SUM(r.rating_number) / COUNT(r.rating_number)),1) as average_rating 
                        FROM producten as p 
                        LEFT JOIN rating as r 
                        ON r.productid = p.productid 
                        WHERE p.productid = $id
                        GROUP BY (r.productid)"); 
        return $this->single();
        
    }

    public function getAverageRating($id)
    {
        $this->query("SELECT COUNT(rating_number) as rating_num, FORMAT((SUM(rating_number) / COUNT(rating_number)),1) as average_rating FROM rating WHERE productid = $id GROUP BY (productid)"); 
        $data = $this->single();
        return $data;
    }

    public function insertRating($prodID, $ratingNum, $userID, $userIP)
    {
        $query = "INSERT INTO rating (productid,rating_number,gebruiker_id,user_ip) VALUES ('".$prodID."', '".$ratingNum."', '".$userID."', '".$userIP."')"; 
        $this->query($query); 
        $this->execute(); 
    }

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

    public function checkIfRated($prodID, $userID)
    {
        $this->query("SELECT rating_number FROM rating WHERE productid = $prodID AND gebruiker_id = $userID"); 
        $this->execute();
        return $this->rowCount();
    }

    public function getCountries()
    {
        $this->query("SELECT * FROM countries ORDER BY name");
        $result = $this->resultSet();

        return $result;
    }

    public function getStates($id)
    {
        $this->query("SELECT * FROM states WHERE country_id=$id");
        $result = $this->resultSet();

        echo "<option value=0 disabled selected>Please select your state</option>";

        foreach ($result as $key)
        {
        echo "<option value='$key->id'>$key->name</option>";
        }
    }

    public function getCities($id)
    {
        $this->query("SELECT * FROM cities WHERE state_id=$id ORDER BY name");
        $result = $this->resultSet();

        echo "<option value=0 disabled selected>Please select your city</option>";

        foreach ($result as $key)
        {
        echo "<option value='$key->id'>$key->name</option>";
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

} // end class