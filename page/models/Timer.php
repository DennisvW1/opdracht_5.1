<?php

class Timer
{
    protected static $start;
    protected static $end;
    protected static $duration;

    public static function startTimer()
    {
        SELF::$start = hrtime(true);
    }

    public static function stopTimer()
    {
        SELF::$end = hrtime(true);
    }

    public static function showDuration()
    {
        echo "<br>Duration: ";
        echo (SELF::$end - SELF::$start) / 10000000;
        echo " seconds";
    }

    public static function logDuration()
    {
        return (SELF::$end - SELF::$start) / 10000000;
    }
}