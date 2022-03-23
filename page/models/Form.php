<?php
// include MODELROOT."Autoloader.php";

class Form extends HtmlDoc
{
    public $page;
    protected $action;
    protected $method = "POST";
    protected $submitValue = "Submit";
    private $arr_postresult = array();
    private $db;
    
    // declare Array property
    protected $form_Array = array ();

    public function __construct($page, $action, $method, $submitValue)
    {
        $this->page = $page;
        $this->action = $action;
        $this->method = $method;
        $this->submitValue = $submitValue;
        $this->arr_postresult = $_POST;
    }

    // method to show the requested form
    public function showContent()
    {
        $this->getFormType();
        $this->startForm();
        $this->getFormContent();
        $this->closeForm();
    }

    private function getFormType()
    {
        $info = new FormInfo($this->page);
        $this->form_Array = $info->getFormInfo();
        return $this->form_Array;
    }

    private function startForm()
    {
        echo "<form action='$this->action' method='$this->method' id='form'>";
        echo "<input type='hidden' name='page' value='$this->page'>";
        echo "<div class='mb-3'>
                <div class='h1'>".ucfirst($this->page)."</div>
                <div class='row pt-3'>";
    }

    private function getFormContent()
    {

        
        foreach ($this->form_Array as $fieldname => $fieldinfo)
        {
            $current_value = (isset($this->arr_postresult[$fieldname]) ? $this->arr_postresult[$fieldname] : '');
            echo "<div class='col'><label id='$fieldname-hidden' class='form-label' for='$fieldname'>".$fieldinfo['label'].'</label></div>';
            echo "<div class='col'><label class='form-label'></label></div>";
            echo "<div class='row'>";
            
            switch ($fieldinfo['type'])
            {
                case "textarea" :
                    if(isset($current_value))
                    {
                        echo "<div class='col'><textarea class='form-control' name=$fieldname placeholder='".$fieldinfo['placeholder']."'>$current_value</textarea></div>";
                        break;    
                    }
                    else
                    {
                        echo "<div class='col'><textarea class='form-control' name=$fieldname placeholder='".$fieldinfo['placeholder']."'></textarea></div>";
                        break;
                    }

                case "select":
                    if($fieldname == "country")
                    {
                        echo "<div class='col' id=$fieldname-div>
                                <select id='country-select' name='country' style='display: block;'>";
                            $this->db = new DatabasePDO();
                            $result = $this->db->getCountries();
                            echo "<option value=0 selected disabled>Please select your country</option>";
                            foreach ($result as $row)
                            {
                                echo "<option value='" . $row->id . "'>" . $row->name ."</option>";
                            }
                        echo "</select></div>";
                        break;
                    }
                    else
                    {
                        echo "<div class='col' id=$fieldname>
                                <select id='$fieldname-select' name='$fieldname'>
                            <option value=0 selected>Select previous field first </option>
                            </select></div>";
                        break;
                    }
                default :
                if(isset($_POST[$fieldname]))
                {
                    echo "<div class='col'><input class='form-control' type='".$fieldinfo['type']."' name='".$fieldname."' placeholder='".$fieldinfo['placeholder']."' value='".$current_value."'></div>";
                    break;
                }
                else
                {
                    echo "<div class='col'><input class='form-control' type='".$fieldinfo['type']."' name='".$fieldname."' placeholder='".$fieldinfo['placeholder']."'></div>";
                    break;
                }

            }
            echo "<div class='col'>";
            if(isset($_SESSION[$fieldname]) && str_starts_with($_SESSION[$fieldname], "*"))
            {
                echo "<span class='alert alert-danger'>$_SESSION[$fieldname]</span>";
                unset($_SESSION[$fieldname]);
            }
                echo "</div></div>";
        }
    }

    private function closeForm()
    {
        echo "<div class='row pt-3'><div class='col'>";
        // echo "<button class='btn btn-dark' type='submit' value='submit'>$this->submitValue</button>";
        echo "<input class='btn btn-dark' type='submit' value='$this->submitValue'></button>";
        echo "</div></div></form>";
    }
}