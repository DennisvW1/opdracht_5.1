<?php
require_once MODELROOT."Autoloader.php";

class AdminModel
{
    public $data;
    private $userId;
    private $db;
    private $amount;

    public function __construct($id)
    {
        $this->userId = $id;
        $this->db = new DatabasePDO();
    }

    public function getContent()
    {
        $this->amount = 3;
        $this->sold = 14;
        $this->data["amount"] = $this->amount;
        $this->data["items"] = $this->db->getSoldItems($this->amount);
        $this->data["rating"] = $this->db->getBestRatedProduct($this->amount);
        $this->data["lastDays"] = $this->db->orderedInLastDays($this->sold);
        return $this->data;
    }
}