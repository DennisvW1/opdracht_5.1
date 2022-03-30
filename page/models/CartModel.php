<?php
require_once MODELROOT."Autoloader.php";
    
class CartModel
{
    private $gebruikersId;
    private $lastorder;
    private $db;
    protected $data;

    public function __construct()
    {
        $this->db = new DatabasePDO();

        try
        {            
            $email = $_SESSION['user_email'];
            $this->gebruikersId = $this->db->getId($email);
            $this->lastorder = $this->db->getLastOrder($this->gebruikersId);
        }
        catch(PDOException $e)
        {
            Logging::LogCsv($e,LogLevel::CRIT);
        }

        $this->data = array();

    }

    public function getContent()
    {
        $this->getOrderedDetails();
        $this->getOrderedTotalPrice();
        return $this->data;
    }

    protected function getOrderedDetails()
    {
            $row = $this->db->getOrderDetails($this->gebruikersId, $this->lastorder);
            $this->addData("orderDetails", $row);
            return $this->data;
    }

    protected function getOrderedTotalPrice()
    {
            $total_price = $this->db->getTotalPrice($this->gebruikersId, $this->lastorder);
            $this->addData("total_price", $total_price);
            return $this->data;
    }

    private function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

}