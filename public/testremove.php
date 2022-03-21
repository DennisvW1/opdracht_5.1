<?php
class testRemove
{
    public $array = array(
        "sjaal" =>  array(
            "name"=> "sjaal",
            "id"=> 1,
            "price"=> 11.00,
            "quantity"=> 1),
        "pin" =>  array(
            "name"=> "pin",
            "id"=> 1,
            "price"=> 2.50,
            "quantity"=> 1),
        );

    public function remove()
    {
        print_r($this->array);
        echo "<br><br>";
        unset($this->array["pin"]);
        print_r($this->array);
    }
}

$init = new testRemove();
$init->remove();