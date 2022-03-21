<?php
    require_once "Classes/Database.php";
class testHash
{
    public $db;

    public function checkPassword()
    {
        $this->db = new Database();
        $this->db->query("SELECT wachtwoord FROM gebruikers WHERE email=:email");
        $this->db->bind("email","dennis.vanwilligen@gmail.com");
        $result = $this->db->single();
        $result = $result->wachtwoord;

        $password = "test123";

        if (password_verify($password, $result))
        {
            echo 'Password is valid!';
        }
        else 
        {
            echo 'Invalid password.';
        }
    }

    public function registerUser()
    {
        $this->db = new Database();
        $check = array(
            "name" => "Dennis",
            "email" => "dennis.vanwilligen@gmail.com"
        );

        $option = array("cost", 5);
        $password = password_hash("test123", PASSWORD_DEFAULT, $option);
        $this->db->query("INSERT INTO gebruikers (naam, email, wachtwoord) VALUES (:name, :email, :password)");
        $this->db->bind("name",$check['name']);
        $this->db->bind("email",$check['email']);
        $this->db->bind("password",$password);
        $this->db->execute();
    }

}

$init = new testHash();
$init->checkPassword();
