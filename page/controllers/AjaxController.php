<?php

require_once MODELROOT."Autoloader.php";

class AjaxController extends Controller
{

    protected function getRequest()
    {
        $posted = ($_SERVER['REQUEST_METHOD']==='POST');
        $this->request = 
            [
                'posted'   => $posted,
                'ajax'     => $this->getRequestVar('ajax', $posted, 'product')    
            ];
    }


    protected function validateRequest()
    {
        if ($this->request['posted'])
        {
            switch ($this->request['ajax'])
            {
                case "rating":
                    Logging::LogCsv("Rated product with ID: ".$_GET['id']." ",LogLeveL::LOW, "rating");
                    break;
            }
        }
        else
        {

        }
    }

    protected function showResponse()
    {
        if($_POST['ajax'] == "rating")
        {
            // Rating class
            $productID = $_GET['id'];
            $rate = new Rating($_POST, $productID);
            $rate->productRating();
        }
    }
    
    protected function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_DEFAULT;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        return ($result===FALSE) ? $default : $result;
    }
}

