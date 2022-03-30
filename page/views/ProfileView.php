<?php

class ProfileView extends HtmlDoc
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
        $this->buildMenu();
        $this->buildBody();
    }

    protected function getProfile()
    {
        echo "<div>";
        echo "</div>";
    }

    private function buildMenu()
    {
        $this->menuOptions = array("main", "change_password", "change_location");

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
            <a class='nav-link' aria-current='page' href='index.php?page=profile&profile=$li'>" . ucfirst($page) . "</a>
            </li>";
        }

        echo "</ul></div>
                </div>
            </nav>";
    }

    private function buildBody()
    {
        echo "
        <div class='mb-5 ml-5'>
                <div class='row pt-2'>";
                    call_user_func(array($this, $this->page));
        echo "
                </div>
            </div>
        </div>";
    }

    private function main()
    {
        echo "<div>
                <div class='row h1'>
                    <div class='col'>
                    ".$this->data["user_name"]."'s profile page
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class='col'>
                        Name: ".$this->data["user_name"]."
                        <div class='col'>
                            Email: ".$this->data["user_email"]."
                        </div>
                            <div class='col'>
                                Country: ".$this->data["country"]."
                            </div>
                                <div class='col'>
                                    State: ".$this->data["state"]."
                                </div>
                                    <div class='col'>
                                        City: ".$this->data["city"]."
                                    </div>
                    </div>
                </div>

            </div>";
    }
    
    private function change_password()
    {
        echo "<div>";
        $form = new Form("password","","POST","Change details");
        $form->showContent();
        echo "</div>";
    }

    private function change_location()
    {
        echo "<div>";
        $form = new Form("location","","POST","Change details");
        $form->showContent();
        echo "</div>";
    }

}