<?php
require_once "../page/config.php";
include MODELROOT."Autoloader.php";
session_start();

$controller = new MainController();
$controller->showPage();