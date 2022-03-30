<?php

interface IDatabase
{
    // contstruct needed for database connection, so that connection is made upon instantiation
    public function __construct();

    public function query($sql);
    public function bind($param, $value, $type = null);
    public function execute();
    public function resultSet();
    public function single();
    public function rowCount();
    
    // transaction requirements
    public function openTransaction();
    public function commitTransaction();
    public function rollBackTransaction();
    
    // specific methods
    public function lastInsertId();
    public function getAllProducts();
    public function getProduct($id);
    public function getSoldItems($amount);
    public function getRating($id);
    public function insertRating($prodID, $ratingNum, $userID, $userIP);
    public function insertContact($check);
    public function insertRegister($check);
    public function insertCart();
    
}