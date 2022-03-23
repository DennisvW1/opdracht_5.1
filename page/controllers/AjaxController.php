<?php

class AjaxController extends Controller
{
    protected $db;

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
                    $productID = $_GET['id'];
                    Logging::LogCsv("Rated product with ID: ".$productID." ",LogLeveL::LOW, "rating");
                    break;
            }
        }
        else
        {

        }
    }

    protected function showResponse()
    {
        $this->db = new DatabasePDO();

        switch($_POST['ajax'])
        {
            case "rating":
                // Rating class
                $productID = $_GET['id'];
                $rate = new Rating($_POST, $productID);
                $rate->productRating();
                break;
            case "register":
                if(isset($_POST["country_id"]))
                {
                    $id = $_POST["country_id"];
                    $state = (isset($_POST["state_id"]) ? $_POST["state_id"] : 0);
                    return $this->db->getStates($id, $state);
                }
                else if(isset($_POST["state_id"]))
                {
                    $id = $_POST["state_id"];
                    $city = $_POST["city_id"];
                    return $this->db->getCities($id, $city);
                }
                break;
        }
    }
    
    protected function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_DEFAULT;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        return ($result===FALSE) ? $default : $result;
    }
}

