<?php
require_once MODELROOT."Autoloader.php";

class Admin
{
    protected $menuOptions;
    private $page;

    public function __construct($page = "main")
    {
        $this->page = $page;
    }

    public function showContent()
    {
        if($_SESSION['user_level'] > 1)
        {
            $this->buildMenu();
            $this->buildBody($this->page);
        }
        else
        {
            echo "Je hebt geen toegang tot de admin omgeving";
        }
    }

    private function buildMenu()
    {
        $this->menuOptions = array("main", "sales", "change_name", "change_level");

        echo "<nav class='navbar navbar-expand-md navbar-light bg-light'>
        <div class='container-fluid'>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarCollapse' aria-controls='navbarCollapse' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span></button>
            <div class='collapse navbar-collapse' id='navbarCollapse'>
            <ul class='navbar-nav me-auto mb-2 mb-md-0'>";

        foreach($this->menuOptions as $li)
        {
            $li = str_replace('_', ' ', $li);

            echo "<li class='nav-item'>
            <a class='nav-link' aria-current='page' href='index.php?page=admin&admin=$li'>" . ucfirst($li) . "</a>
            </li>";
        }

        echo "</ul></div>
                </div>
            </nav>";
    }

    private function buildBody($page)
    {
        $this->page = str_replace("_", " ", $this->page);
        echo "
        <div class='mb-5 ml-5'>
            <div class='h2 mr-5'>Admin Panel - ". ucfirst($this->page) ."</div>
                    <div class='row pt-2'>";
                //---------------
                switch($this->page)
                {
                    case "main":
                        echo "Main page for admin";
                        break;
                    case "change_name":
                        echo "change name for a user here!";
                        break;
                    case "change_level":
                        echo "change the level for a user here";
                        break;
                    case "sales":
                        echo "check sales here";
                        break;
                    default: 
                        echo "Main page for admin";
                }
                //---------------
                echo "
                </div>
            </div>
        </div>";
    }
}