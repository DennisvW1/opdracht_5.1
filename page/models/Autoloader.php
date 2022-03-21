<?php

spl_autoload_register(function($className) 
{
    if (str_starts_with($className, "I"))
    {
        $file = PAGEROOT."/interfaces/". $className . ".php";
        if (file_exists($file))
        {
            require_once $file;
        }
    }
    else if (str_contains($className, "Controller"))
    {
        $file = PAGEROOT."/controllers/". $className . ".php";
        if (file_exists($file))
        {
            require_once $file;
        }
    }
    else
    {
        $file = PAGEROOT."/models/". $className . ".php";
        if (file_exists($file))
        {
            require_once $file;
        }  
    }
});