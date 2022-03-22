<?php
require_once MODELROOT."Autoloader.php";

class MainController extends Controller
{
    protected $controller;

    protected function showResponse()
    {
        if(isset($_POST['ajax']))
        {
            $controller = new AjaxController();
            $controller->showPage();
        }
        else
        {
            $controller = new PageController();
            $controller->showPage();
        }
    }

} // end class