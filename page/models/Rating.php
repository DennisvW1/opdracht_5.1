<?php
require_once MODELROOT."Autoloader.php";

class Rating
{
    private $db;
    private $toRate;
    private $data = array();
    private $productID = 0;

    public function __construct($data, $prodID = 0)
    {
        $this->db = new DatabasePDO();
        $this->data = $data;
        $this->productID = $prodID; 
    }

    public function productRating()
    {
        if(!empty($_POST['rating']))
        { 
        // Get posted data 
        // $postID = $_GET['ID'];
        $ratingNum = $_POST['rating']; 
         
        // Current IP address 
        $userIP = $_SERVER['REMOTE_ADDR']; 
        $userID = $_SESSION['user_id'];

        // Check whether the user already submitted the rating for the same post 
        $result = $this->db->checkIfRated($this->productID, $userID);

        if($result > 0){ 
            // Status 
            $status = 2; 
        }else{ 
            // Insert rating data in the database 
            // $query = "INSERT INTO rating (productid,rating_number,user_ip) VALUES ('".$prodID."', '".$ratingNum."', '".$userIP."')"; 
            // $this->db->query($query); 
            // $this->db->execute(); 
            $this->db->insertRating($this->productID, $ratingNum, $userID, $userIP);
            // Status 
            $status = 1; 
        } 
         
        // Fetch rating details from the database 
        $query = "SELECT COUNT(rating_number) as rating_num, FORMAT((SUM(rating_number) / COUNT(rating_number)),1) as average_rating FROM rating WHERE productid = $this->productID GROUP BY (productid)"; 
        $result = $this->db->query($query); 
        $ratingData = $this->db->resultSet(); 
         
        $response = array( 
            "status" => $status,
            "data" => $ratingData
        ); 
         
        // Return response in JSON format 
        echo json_encode($response);
        } 
    }

}