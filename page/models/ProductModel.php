<?php

class ProductModel
{
    protected $id;
    private $db;
    public $result;
    public $product;
    public $data;

    public function __construct($id = 0)
    {
        $this->id = $id;
        $this->db = new DatabasePDO();
        $this->data = array();
    }

    public function getContent()
    {
        $this->db->getProduct($this->id);
        $this->result = $this->db->rowCount();
        $this->product = $this->db->getRating($this->id);

        $this->data["result"] = $this->result;
        $this->data["product"] = $this->product;
        return $this->data;
    }

}