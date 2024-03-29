<?php

class AdminView extends HtmlDoc
{
    protected $page;
    protected $data;
    
    public function __construct($data, $page = "main")
    {
        $this->data = $data;
        $this->page = $page;
    }

    public function showContent()
    {
        if(isset($_SESSION["user_level"]) && $_SESSION["user_level"] > 1)
        {
            $this->buildMenu();
            $this->buildBody();
        }
        else
        {
            echo "Je hebt geen toegang tot de admin omgeving";
        }
    }

    private function buildMenu()
    {
        $this->menuOptions = array("main", "sales", "change_level");

        echo "<nav class='navbar navbar-expand-md navbar-light bg-light'>
        <div class='container-fluid'>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarCollapse' aria-controls='navbarCollapse' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span></button>
            <div class='collapse navbar-collapse' id='navbarCollapse'>
            <ul class='navbar-nav me-auto mb-2 mb-md-0'>";

        foreach($this->menuOptions as $li)
        {
            $page = str_replace('_', ' ', $li);

            echo "<li class='nav-item'>
            <a class='nav-link' aria-current='page' href='index.php?page=admin&admin=$li'>" . ucfirst($page) . "</a>
            </li>";
        }

        echo "</ul></div>
                </div>
            </nav>";
    }

    private function buildBody()
    {
        $page = str_replace("_", " ", $this->page);
        echo "
        <div class='mb-5 ml-5'>
            <div class='h2 mr-5'>Admin Panel - ". ucfirst($page) ."</div>
                <div class='row pt-2'>";
                    call_user_func(array($this, $this->page));
        echo "
                </div>
            </div>
        </div>";
    }

    private function main()
    {
        echo "Main page for admin";
    }


    private function change_level()
    {
        echo "change the level for a user here";
    }

    private function sales()
    {
        $this->page = new OverviewView("rating", $this->data["rating"], $this->data["amount"]);
        $this->page->showContent();
        echo "<hr>";
        $this->page = new OverviewView("items", $this->data["items"], $this->data["amount"]);
        $this->page->showContent();
        echo "<hr>";
        $this->page = new OverviewView("lastDays", $this->data["lastDays"], $this->data["amount"]);
        $this->page->showContent();
    }
}