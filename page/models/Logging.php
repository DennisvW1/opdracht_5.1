<?php
require_once MODELROOT."Autoloader.php";
class Logging implements ILog
{
    public static function LogCsv($text, $type, $page="home", $name="guest", $id=0)
    {
        Timer::startTimer();
        //--------------------
        // Get the page from the GET superglobal, if this has been set
        //--------------------
        if(isset($_GET['page']))
        {
            $page = $_GET['page'];
        }

        //--------------------
        // Save the logs to a .csv file
        //--------------------
        $file = PAGEROOT."/logs/".$page.".csv";

        //--------------------
        // Create the .csv file for logging
        //--------------------
        if(!file_exists($file))
        {
            file_put_contents($file,"Type,IP,Name,ID,Time,Page,Message,LogNumber,TimeToLog\n");
        }

        //--------------------
        // Set the session variables to be added into the log
        //--------------------
        if(isset($_SESSION["user_name"]))
        {
            $name = $_SESSION["user_name"];
            $id = $_SESSION["user_id"];
        }

        //--------------------
        // Get the IP-address from the user
        //--------------------
        $ip = $_SERVER["REMOTE_ADDR"];

        //--------------------
        // Get the date and time from the event
        //--------------------
        $time = date("d-m-Y H:i:s", time());

        //--------------------
        // Open the log file
        //--------------------
        $usersfile = fopen($file, "a");
        
        //--------------------
        // Create array which stores data to be logged
        //--------------------
        Timer::stopTimer();
        $data = array($type, $ip, $name, $id, $time, $page, $text, Logging::LogNumber(), Timer::logDuration());

        //--------------------
        // Store the array in the .csv file
        //--------------------
        fputcsv($usersfile, $data);
        fclose($usersfile);

        // Logging::LogDB($text, $type, $page, $name, $id);
    }

    public static function LogDB($text, $type, $page="home", $name="guest", $id=0)
    {
        Timer::startTimer();
        //--------------------
        // Set the session variables to be added into the log
        //--------------------
        if(isset($_SESSION["user_name"]))
        {
            $name = $_SESSION["user_name"];
            $id = $_SESSION["user_id"];
        }

        //--------------------
        // Get the IP-address from the user
        //--------------------
        $ip = $_SERVER["REMOTE_ADDR"];

        //--------------------
        // Get the date and time from the event
        //--------------------
        $time = date("d-m-Y H:i:s", time());
        Timer::stopTimer();
        $data = array("type" => $type, 
                    "ip" => $ip, 
                    "username" => $name, 
                    "userid" => $id, 
                    "time" => $time, 
                    "page" => $page, 
                    "text" => $text, 
                    "lognumber" => Logging::LogNumber(),
                    "time_to_log" => Timer::logDuration());
        try
        {
            $db = new DatabasePDO();
            $db->logToDatabase($data);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    private static function LogNumber()
    {
        $randomNumber = rand(100000, 999999);
        $logNumber = "LogMsg-".$randomNumber;
        return $logNumber;
    }
}