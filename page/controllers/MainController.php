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
        else if(isset($_GET['type']) && $_GET['page'] == "api")
        {
            $controller = new ApiController();
            $controller->showPage();
        }
        else
        {
            $controller = new PageController();
            $controller->showPage();
        }
    }

} // end class