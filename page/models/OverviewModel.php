<?php
require_once MODELROOT."Autoloader.php";
class OverviewModel
{

    protected $model;
    protected $insert;
    protected $db;

    public function __construct($model, $insert)
    {
        $this->model = $model;
        $this->insert = $insert;
        $this->db = new DatabasePDO();
    }

    public function getContent()
    {
        switch($this->model)
        {
            case "items":
                $data = $this->db->getSoldItems($this->insert);
                return $data;
                break;
            case "rating":
                $data = $this->db->getBestRatedProduct($this->insert);
                return $data;
                break;
        }
    }

}