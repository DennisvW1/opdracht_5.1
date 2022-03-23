<?php
require_once MODELROOT."Autoloader.php";

class Rating
{
    private $db;
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
        $ratingNum = $_POST['rating'];

        // Current IP address
        $userIP = $_SERVER['REMOTE_ADDR'];
        $userID = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

        // Check whether the user already submitted the rating for the same post
        if(!isset($_SESSION['user_name']))
        {
            $status = 3;
        }
        else
        {
            $result = $this->db->checkIfRated($this->productID, $userID);
            if($result > 0)
            {
                $status = 2;
            }
            else
            {
                // Insert rating data in the database
                $this->db->insertRating($this->productID, $ratingNum, $userID, $userIP);
                $status = 1;
            }
        }

        // Fetch rating details from the database
        $ratingData = $this->db->getAverageRating($this->productID);

        $response = array(
            "status" => $status,
            "data" => $ratingData
        );

        // Return response in JSON format
        echo json_encode($response);
        }
    }

} // end class