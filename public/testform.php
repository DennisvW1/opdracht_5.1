<?php
require_once "../page/config.php";

include MODELROOT."Autoloader.php";
$db = new DatabasePDO();
$test = $db->getCountryName(155);

print_r($test->name);