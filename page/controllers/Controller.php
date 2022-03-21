<?php

require_once MODELROOT."Autoloader.php";

abstract class Controller implements IController
{
    public function __construct()
    {
        
    }
    
    final public function showPage()
    {
        $this->getRequest();
        $this->validateRequest();
        $this->showResponse();
    }

    protected function getRequest()
    {
        $posted = ($_SERVER['REQUEST_METHOD']==='POST');
        $this->request = 
            [
                'posted'   => $posted,
                'page'     => $this->getRequestVar('page', $posted, 'home')    
            ];
    }

    protected function validateRequest() {}

    protected function showResponse() {}
    
    protected function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_DEFAULT;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        return ($result===FALSE) ? $default : $result;
    }
}