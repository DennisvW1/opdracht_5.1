<?php
require_once MODELROOT."Autoloader.php";
class FormValidator
{
    private $data;
    public $validated = [];
    private $fields;
    private $db;

    public function __construct($postdata)
    {
        $this->data = $postdata;
        $this->db = new DatabasePDO();
    }

    public function validateForm()
    {
        if(!isset($this->data['page']))
        {

        }
        else
        {
            switch($this->data['page'])
            {
                case "contact":
                    // validate field names for contact form
                    $this->validateName();
                    $this->validateEmail();
                    $this->validateMessage();

                    if($this->checkFields($this->data['page']))
                    {
                        return $this->validated;
                    }
                    break;

                case "register":
                    $formFields = new FormInfo("register");
                    $this->fields = $formFields->getArrayNames();;

                    // validate field names for register form
                    $this->validateName();
                    $this->validateEmailRegister();
                    $this->validatePasswordRegister();
                    $this->validatePasswordRepeat();
                    $this->validateCountry();
                    $this->validateState();
                    $this->validateCity();

                    if($this->checkFields($this->data['page']))
                    {
                        return $this->validated;
                    }
                    break;
                case "login":
                    // validate field names for login form
                    $this->validateEmailLogin();
                    $this->validatePasswordLogin();
                    if($this->checkFields($this->data['page']))
                    {
                        return $this->validated;
                    }
                    break;
                case "profile":
                    $this->addData("sub", $this->data["sub"]);

                    if(array_key_exists("state", $this->data))
                    {
                        $this->changeCountry();
                        $this->validateState();
                        $this->validateCity();
                        if($this->checkFields("location"))
                        {
                            return $this->validated;
                        }
                        break;
                    }
                    else if(array_key_exists("password", $this->data)) 
                    {
                        $this->validatePasswordChange();
                        $this->validatePasswordRepeat();

                        if($this->checkFields("password"))
                        {
                            return $this->validated;
                        }
                        break;
                    }
            }
        }
    }

    private function checkFields($form)
    {
        $formFields = new FormInfo($form);
        $this->fields = $formFields->getArrayNames();;
        foreach($this->fields as $field)
        {
            if(!array_key_exists($field, $this->validated))
            {
                Messages::setMessage("$field is not present in data","error");
                return false;
            }
            else
            {
                return true;
            }
        }
    }

    private function validateName()
    {
        $val = trim($this->data['name']);
        if(empty($val))
        {
            $this->addData('name', '* Name cannot be empty');
            $this->validated['all_ok'] = false;
        }
        else
        {
            if(!preg_match('/^[a-zA-Z]{1,100}$/', $val))
            {
                $this->addData('name', '* Name can only have letters');
                $this->validated['all_ok'] = false;
            }
            else
            {
                $this->validated['all_ok'] = true;
                $this->validated['name'] = $val;
            }
        }
        return $this->validated;
    }

    private function validateEmail()
    {
        $val = trim($this->data['email']);

        if(empty($val))
        {
            $this->addData('email', '* Email cannot be empty');
            $this->validated['all_ok'] = false;
        }
        else
        {
            if(!filter_var($val, FILTER_VALIDATE_EMAIL))
            {
                $this->addData('email', '* Email is not valid');
                $this->validated['all_ok'] = false;
            }
            else
            {
                $this->validated['email'] = $val;
                
                if($this->validated['all_ok'])
                {
                    $this->validated['email'] = $val;
                    $this->validated['all_ok'] = true;
                }
            }
        }
        return $this->validated;
    }

    private function validateMessage()
    {
        $val = trim($this->data['message']);
        if(empty($val))
        {
            $this->addData('message', '* Message cannot be empty');
            $this->validated['all_ok'] = false;
        }
        else
        {
            $this->validated['message'] = $val;

            if($this->validated['all_ok'])
            {
                $this->validated['all_ok'] = true;
                $this->validated['message'] = $val;
            }
        }
        return $this->validated;
    }

    private function validateEmailRegister()
    {
        $val = trim($this->data['email']);
        if(empty($val))
        {
            $this->addData('email', '* Email cannot be empty');
            $this->validated['all_ok'] = false;
            return;
        }
        else
        {
            if(!filter_var($val, FILTER_VALIDATE_EMAIL))
            {
                $this->addData('email', '* Email is not valid');
                $this->validated['all_ok'] = false;
            }
            else
            {
                // check if available in database

                $this->db->query("SELECT email FROM gebruikers WHERE email=:email");
                $this->db->bind("email", $val);
                $this->db->execute();
                if($this->db->rowCount() > 0)
                {
                    $this->addData('email', '* Email already exists!');
                    $this->validated['all_ok'] = false;
                }
                else
                {
                    if($this->validated['all_ok'])
                    {
                        $this->validated['all_ok'] = true;
                        $this->validated['email'] = $val;
                    }
                }

            }
        }
        return $this->validated;
    }

    private function validatePasswordRegister()
    {
        $val = trim($this->data['password']);
        if(empty($val))
        {
            $this->addData('password', '* Password cannot be empty');
            $this->validated['all_ok'] = false;
        }
        else
        {
            if($this->validated['all_ok'])
            {
                $this->validated['all_ok'] = true;
                $this->validated['password'] = $val;
            }
        }
        return $this->validated;
    }

    private function validatePasswordChange()
    {
        $val = trim($this->data['password']);
        if(empty($val))
        {
            $this->addData('password', '* Password cannot be empty');
            $this->validated['all_ok'] = false;
        }
        else
        {
                $this->validated['all_ok'] = true;
                $this->validated['password'] = $val;
        }
        return $this->validated;
    }

    private function validateCountry()
    {

        $val = (isset($this->data['country']) ? trim($this->data['country']) : "");
        if(empty($val))
        {
            $this->addData('country', '* Please select your country');
            $this->validated['all_ok'] = false;
        }
        else
        {
            if (!preg_match('/^[0-9]*$/', $val))
            {
                $this->addData('country', '* Country value can only be a number');
                $this->validated['all_ok'] = false;
            }
            else
            {
                if($this->validated["all_ok"])
                {
                    $this->validated['all_ok'] = true;
    
                    $country = $this->db->getCountryName($val);
                    $this->addData("country", $country->name);
                }
                else
                {
                    $this->addData("country", $val);
                }
            }
        }
        return $this->validated;
    }

    private function validateState()
    {

        $val = (isset($this->data['state']) ? trim($this->data['state']) : "");
        if(empty($val))
        {
            if(str_starts_with($this->validated['country'] , "*"))
            {
            $this->addData('state', 0);
            }
            else
            {
                $this->addData("state", "* Please select your state");
            }
            $this->validated['all_ok'] = false;

        }
        else
        {
            if (!preg_match('/^[0-9]*$/', $val))
            {
                $this->addData('state', '* State value can only be a number');
                $this->validated['all_ok'] = false;
            }
            else
            {
                if($this->validated['all_ok'])
                {
                    $this->validated['all_ok'] = true;

                    $state = $this->db->getStateName($val);
                    $this->addData("state", $state->name);
                }
                else
                {
                    $this->addData("state", $val);
                }

            }
        }
        return $this->validated;
    }

    private function validateCity()
    {

        $val = (isset($this->data['city']) ? trim($this->data['city']) : "");
        if(empty($val))
        {
            if(str_starts_with($this->validated['country'] , "*") || str_starts_with($this->validated['state'] , "*"))
            {
                $this->addData("city", 0);
            }
            else
            {
                $this->addData("city", "* Please select your city");
            }
            $this->validated['all_ok'] = false;
        }
        else
        {
            if (!preg_match('/^[0-9]*$/', $val))
            {
                $this->addData('city', '* City value can only be a number');
                $this->validated['all_ok'] = false;
            }
            else
            {
                if($this->validated["all_ok"])
                {
                    $this->validated['all_ok'] = true;
    
                    $city = $this->db->getCityName($val);
                    $this->addData("city", $city->name);
                }
                else
                {
                    $this->addData("city", $val);
                }

            }
        }
        return $this->validated;
    }

    private function validateEmailLogin()
    {
        $val = trim($this->data['email']);

        if(empty($val))
        {
            $this->addData('email', '* Email cannot be empty');
            $this->validated['all_ok'] = false;
            return;
        }
        else
        {
            if(!filter_var($val, FILTER_VALIDATE_EMAIL))
            {
                $this->addData('email', '* Email is not valid');
                $this->validated['all_ok'] = false;
                return;
            }
            // check if available in database
            $this->db->query("SELECT email FROM gebruikers WHERE email=:email");
            $this->db->bind("email", $val);
            $this->db->execute();
            if($this->db->rowCount() == 0)
            {
                $this->addData('email', '* This email address is unknown!');
                $this->validated['all_ok'] = false;
            }
            else
            {
                    $this->validated['all_ok'] = true;
                    $this->validated['email'] = $val;
            }
        }
        return $this->validated;
    }

    private function validatePasswordLogin()
    {
        $val = trim($this->data['password']);

        if(empty($val))
        {
            $this->addData('password', '* Password cannot be empty');
            $this->validated['all_ok'] = false;
        }
        else
        {
            // require_once PAGEROOT."/views/login.php";
            $result = $this->getPassword($this->validated['email']);
            
            if (password_verify($val, $result))
            {
                if($this->validated['all_ok'])
                {
                    Messages::setMessage("Sucessfully logged in!", "success");
                    $this->validated['all_ok'] = true;
                    $this->validated['password'] = $val;
                }
            }
            else 
            {
                $this->addData('password', '* Password is incorrect!');
                $this->validated['all_ok'] = false;
            }
        }
            return $this->validated;
    }

    private function validatePasswordRepeat()
    {
        $val = trim($this->data['passwordrepeat']);
        if(empty($val))
        {
            $this->addData('passwordrepeat', '* Password cannot be empty');
            $this->validated['all_ok'] = false;
        }
        //check if password repeat matches the password
        if($this->data['passwordrepeat'] !== $this->data['password'])
        {
            $this->addData('passwordrepeat', '* Passwords do not match');
            $this->validated['all_ok'] = false;
        }
    }

    private function addData($key, $value)
    {
        $this->validated[$key] = $value;
    }

    private function getPassword($email)
    {
        $this->db->query("SELECT wachtwoord FROM gebruikers WHERE email=:email");
        $this->db->bind("email",$email);
        $result = $this->db->single();
        $result = $result->wachtwoord;
        
        return $result;
    }

    private function changeCountry()
    {

        $val = (isset($this->data['country']) ? trim($this->data['country']) : "");
        if(empty($val))
        {
            $this->addData('country', '* Please select your country');
            $this->validated['all_ok'] = false;
        }
        else
        {
            if (!preg_match('/^[0-9]*$/', $val))
            {
                $this->addData('country', '* Country value can only be a number');
                $this->validated['all_ok'] = false;
            }
            else
            {
                    $this->validated['all_ok'] = true;
                    $country = $this->db->getCountryName($val);
                    $this->addData("country", $country->name);
            }
        }
        return $this->validated;
    }
}