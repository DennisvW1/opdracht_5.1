<?php
require_once "../page/config.php";

include MODELROOT."Autoloader.php";

$test = new Logging();
$test->LogDB("Test text", LogLevel::LOW);

