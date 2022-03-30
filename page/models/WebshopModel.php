<?php

class WebshopModel
{
    private $db;
    private $product;
    
    public function __construct($product = 0)
    {
        $this->db = new DatabasePDO();
        $this->product = $product;
    }

    public function getContent()
    {
        $result = $this->db->getAllProducts();
        return $result;
    }
}