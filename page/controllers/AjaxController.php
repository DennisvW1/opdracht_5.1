<?php

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
                    print_r($_POST);
                    if(isset($_POST["prodid"]))
                    {
                        $productID = $_POST["prodid"];
                    }
                    else
                    {
                        $productID = $_GET['id'];
                    }

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

        switch($_POST['ajax'])
        {
            case "rating":
                // Rating class
                if(isset($_POST["prodid"]))
                {
                    $productID = $_POST["prodid"];
                }
                else
                {
                    $productID = $_GET['id'];
                }

                $rate = new Rating($_POST, $productID);
                $rate->productRating();
                break;

            case "register":
                if(isset($_POST["country_id"]))
                {
                    $this->db = new DatabasePDO();
                    $id = $_POST["country_id"];
                    return $this->db->getStates($id);
                }
                else if(isset($_POST["state_id"]))
                {
                    $this->db = new DatabasePDO();
                    $id = $_POST["state_id"];
                    return $this->db->getCities($id);
                }
                break;
        }
        if($_POST['ajax'] == "rating")
        {

        }
    }
    
    protected function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_DEFAULT;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        return ($result===FALSE) ? $default : $result;
    }
}

