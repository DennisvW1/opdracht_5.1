<?php
require_once MODELROOT."Autoloader.php";

class MainController extends Controller
{
    protected $controller;

    public function __construct()
    {
        if(isset($_POST['ajax']))
        {
            $this->controller = "AjaxController";
        }
        else
        {
            $this->controller = "PageController";
        }
    }
    
    protected function showResponse()
    {
        $controller = new $this->controller();
        $controller->showPage();
    }

}