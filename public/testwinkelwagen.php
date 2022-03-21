<?php
require_once "../page/config.php";
session_start();
require_once PAGEROOT."/models/WinkelwagenModel.php";
require_once PAGEROOT."/models/Database.php";


$init = new WinkelwagenModel();
$data = $init->getOrderedDetails();
$data2 = $init->getOrderedTotalPrice();
print_r($data);
echo "<br>";
print_r($data2);
