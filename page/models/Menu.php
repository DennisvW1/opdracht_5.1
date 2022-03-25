<?php
require_once MODELROOT."Autoloader.php";
class Menu implements IShowPage
{
    private $menu;
    
    public function showContent()
    {
        $this->showMenu();
    }

    private function getMenuOptions()
    {
        if(isset($_SESSION["user_name"]))
        {
            if($_SESSION["user_level"] == 3)
            {
                $this->menu = array("home","about","contact","webshop","cart","best sold","admin","profile","logout");
            }
            else if($_SESSION["user_level"] == 2)
            {
                $this->menu = array("home","about","contact","webshop","cart","best sold","sales","profile","logout");
            }
            else
            {
                $this->menu = array("home","about","contact","webshop","cart","best sold","profile","logout");
            }

            return $this->menu;
        }
        else
        {
            $this->menu = array("home","about","contact","webshop","best sold","register","login");
            return $this->menu;
        }
    }

    private function showMenu()
    {
        
        echo "<header>
        <nav class='navbar navbar-expand-md navbar-dark bg-dark'>
        <div class='container-fluid'>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarCollapse' aria-controls='navbarCollapse' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarCollapse'>
            <ul class='navbar-nav me-auto mb-2 mb-md-0'>";
        foreach($this->getMenuOptions() as $li)
        {
        if(isset($_SESSION['user_name']) && $li == "logout")
        {
            echo "
                <li class='nav-item'>
                <a class='nav-link' aria-current='page' href='index.php?page=$li'>" . ucfirst($li) . " ".$_SESSION['user_name']."</a>
                </li>";
            }
            else
            {
                    echo "<li class='nav-item'>
                    <a class='nav-link' aria-current='page' href='index.php?page=$li'>" . ucfirst($li) . "</a>
                    </li>
                ";
                }
        }

        echo "</ul></div>
                </div>
            </nav>
        </header>";
    }
}