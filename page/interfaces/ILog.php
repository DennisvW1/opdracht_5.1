<?php
interface ILog
{
    public static function LogCsv($text, $type, $page="home", $name="guest", $id=null);
    public static function LogDB($text, $type, $page="home", $name="guest", $id=null);
}