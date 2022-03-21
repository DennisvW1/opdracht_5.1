<?php
require_once "../page/config.php";
session_start();
require_once PAGEROOT."/models/WebshopModel.php";
require_once PAGEROOT."/models/Database.php";


$init = new WebshopModel();
// $data = $init->getAllItems();
$data2 = $init->getTop5Sold();
// print_r($data);
echo "<br>";
print_r($data2);
echo "<br><br>";
foreach ($data2 as $data)
{
    echo "Product: ".$data->productnaam."<br><br>";
}