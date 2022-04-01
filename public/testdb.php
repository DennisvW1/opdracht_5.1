<?php
require_once "../page/config.php";
include MODELROOT."Autoloader.php";

$db = new DatabasePDO();
$data = $db->orderedInLastDays(7);

foreach($data as $row)
{
    echo "Bestellingid: ".$row->bestellingid;
    echo "<br>Bestellingdatum: ".$row->bestellingdatum;
    echo "<br>Gebruiker: ".$row->naam;
    echo "<br>Product: ".$row->productnaam;
    echo "<br>Aantal: ".$row->productaantal;
    echo "<br><br>";
}

