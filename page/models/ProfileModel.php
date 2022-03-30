<?php

class ProfileModel
{
    protected $menuOptions;
    protected $user;
    protected $page;
    protected $db;
    protected $userId;
    public $data;

    public function __construct($id)
    {
        $this->userId = $id;
        $this->db = new DatabasePDO();
        $this->data["user_name"] = $_SESSION["user_name"];
        $this->data["user_email"] = $_SESSION["user_email"];
    }

    public function getContent()
    {
        $this->userCountry();
        $this->userState();
        $this->userCity();
        return $this->data;
    }

    private function userCountry()
    {
        $this->data["country"] = $this->db->getUserCountry($this->userId);
        return $this->data;
    }

    private function userState()
    {
        $this->data["state"] = $this->db->getUserState($this->userId);
        return $this->data;
    }

    private function UserCity()
    {
        $this->data["city"] = $this->db->getUserCity($this->userId);
        return $this->data;
    }
}