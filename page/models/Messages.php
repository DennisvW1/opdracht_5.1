<?php
class Messages
{
    public static function setMessage($msg, $type)
    {
        if($type == "error")
        {
            $_SESSION['errorMsg'] = $msg;
        } else
        {
            $_SESSION['succesMsg'] = $msg;
        }
    }

    public static function displayMessage()
    {
        if(isset($_SESSION['errorMsg']))
        {
            echo "<div class='alert alert-danger alert-dismissible fade show'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>".$_SESSION['errorMsg']."</div><br>";
            unset($_SESSION['errorMsg']);
        }

        if(isset($_SESSION['succesMsg']))
        {
            echo "<div class='alert alert-success alert-dismissible'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>".$_SESSION['succesMsg']."</div><br>";
            unset($_SESSION['succesMsg']);
        }
    }
}