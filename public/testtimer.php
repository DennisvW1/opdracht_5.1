<?php
session_start();
require_once "../page/config.php";
require_once MODELROOT."Autoloader.php";

// $timer = new Timer();
// $timer->startTimer();

// echo "Let's test how long this will take to run";

// $timer->stopTimer();

// $timer->calculateDuration();


Timer::startTimer();
    echo "Timer test";
Timer::stopTimer();

Timer::showDuration();