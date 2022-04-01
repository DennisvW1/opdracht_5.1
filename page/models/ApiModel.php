<?php

class ApiModel
{
    public $data;
    protected $qty;
    protected $id;
    protected $limit;
    private $db;

    public function __construct($qty, $id = 0, $limit = 0)
    {
        $this->qty = $qty;  
        $this->id = $id;
        $this->limit = $limit;
        $this->db = new DatabasePDO();
    }

    public function getContent()
    {
        switch($this->qty)
        {
            case "one":
                $data = $this->getOneProduct();
                $this->addData("product", $data);
                break;
            case "all":
                $data = $this->getAllProducts();
                $this->addData("products", $data);
                break;
            case "limit":
                $data = $this->getLimitProducts();
                $this->addData("products", $data);
                break;
        } 
        return $this->data;
    }

    private function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

    private function getOneProduct()
    {
        $data = $this->db->getProduct($this->id);
        return $data;
    }

    private function getAllProducts()
    {
        $data = $this->db->getAllProducts();
        return $data;
    }

    
    private function getLimitProducts()
    {
        $data = $this->db->getLimitProducts($this->limit);
        return $data;
    }

}