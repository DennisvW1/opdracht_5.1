<?php
session_start();
require_once "../page/config.php";
require_once MODELROOT."Autoloader.php";


if(isset($_POST['action']))
{

    if($_POST['action'] == "insert")
    {
        $productID = 1;
        $rate = new Rating($_POST, $productID);
        $rate->productRating();
        
    }

}