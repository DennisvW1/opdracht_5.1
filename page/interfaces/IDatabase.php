<?php

interface IDatabase
{
    // contstruct needed for database connection, so that connection is made upon instantiation
    function __construct();

    function query($sql);
    function bind($param, $value, $type = null);
    function execute();
    function resultSet();
    function single();
    function rowCount();
    
    // transaction requirements
    function openTransaction();
    function commitTransaction();
    function rollBackTransaction();
    
    // specific methods
    function lastInsertId();
    function getAllProducts();
    function getProduct($id);
    function getSoldItems($amount);
    function getRating($id);
    function insertRating($prodID, $ratingNum, $userID, $userIP);
    function insertContact($check);
    function insertRegister($check);
    public function insertCart();
    
}