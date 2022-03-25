<?php
include MODELROOT."Autoloader.php";

class FormInfo
{
    protected $formInfo = array();
    protected $formType;
    public function __construct($page)
    {
        $this->formType = $page;
    }

    public function getFormInfo()
    {
        $this->getContent();
        return $this->formInfo;
    }
    
    
    public function getArrayNames()
    {
        $this->getContent();

        $names = "";
        foreach($this->formInfo as $fieldname => $fieldinfo)
        {
            $names .= $fieldname.",";
        }
        $array = explode(",",$names);
        array_pop($array);
        return $array;
    }

    protected function getContent()
    {
        switch ($this->formType)
        {
            case "contact":
                $this->formInfo = array(
                    "name" 		=> array("type" => "text", 		
                                         "label"=> "Your name:",
                                         "placeholder" => "Enter your name",
                                        ),		
                    "email" 	=> array("type" => "email",
                                         "label"=> "Your email:",
                                         "placeholder" => "Enter your email address",
                                        ),	
                    "message" 	=> array("type" => "textarea",
                                         "label"=> "Your message:",
                                         "placeholder" => "Enter your message"
                    ));
                break;
            case "login":
                $this->formInfo = array(
                    "email" 	=> array("type" => "text", 		
                                            "label"=> "Email:",
                                            "placeholder" => "Enter your email",
                                        ),		
                    "password" 	=> array("type" => "password",
                                            "label"=> "Password:",
                                            "placeholder" => "Enter your password"
                    ));
                break;
            case "register":
                $this->formInfo = array(
                    "name" 		=> array("type" => "text", 		
                                            "label"=> "Your name:",
                                            "placeholder" => "Enter your name",
                                        ),		
                    "email" 	=> array("type" => "email",
                                            "label"=> "Your email:",
                                            "placeholder" => "Enter your email address",
                                        ),
                    "password" 	=> array("type" => "password",
                                            "label"=> "Your password:",
                                            "placeholder" => "Enter your password",
                                        ),
                    "passwordrepeat" 	=> array("type" => "password",
                                            "label"=> "Your password again:",
                                            "placeholder" => "Repeat your password",
                                        ),
                    "country" 	=> array("type" => "select",
                                            "label"=> "Country:",
                                            "options_func" => "getCountries",
                                        ),
                    "state" 	=> array("type" => "select",
                                            "label"=> "State:",
                                            "options_func" => "getStates"
                                        ),
                    "city" 	=> array("type" => "select",
                                            "label"=> "City:",
                                            "options_func" => "getCities"
                    ));
                break;
            case "password":
                $this->formInfo = array(
                    "password" 	=> array("type" => "password",
                                            "label"=> "New password:",
                                            "placeholder" => "Enter your new password",
                                        ),
                    "passwordrepeat" 	=> array("type" => "password",
                                            "label"=> "Your password again:",
                                            "placeholder" => "Repeat your new password",
                                        ));
                break;
            case "location":
                $this->formInfo = array(
                    "country" 	=> array("type" => "select",
                                            "label"=> "Country:",
                                            "options_func" => "getCountries",
                                        ),
                    "state" 	=> array("type" => "select",
                                            "label"=> "State:",
                                            "options_func" => "getStates"
                                        ),
                    "city" 	=> array("type" => "select",
                                            "label"=> "City:",
                                            "options_func" => "getCities"
                                    ));                
                break;
        }
    }


}