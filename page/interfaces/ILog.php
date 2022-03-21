<?php
interface ILog
{
    static function LogCsv($text, $type, $page="home", $name="guest", $id=null);
}