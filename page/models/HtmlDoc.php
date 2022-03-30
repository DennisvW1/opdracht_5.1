<?php
require_once MODELROOT."Autoloader.php";
// een abstracte basis class -> abstract zodat hiervan geen instantie aangeroepen kan worden
abstract class HtmlDoc implements IShowContent
{
    public function show()
    {
        $this->startPage();
        $this->startHead();
        $this->showBody();
        $this->endPage();
    }
    
    // method to start the html page
    private function startPage() 
    { 
        echo "<!DOCTYPE html>
                <html>";
    } 

    // method to create the head section
    private function startHead()
    {
        echo "<head>
        <title>". SITENAME . "</title>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='css/bootstrap.min.css' rel='stylesheet'>
        <script src='css/bootstrap.bundle.min.js'></script>
        <link href='css/style.css' rel='stylesheet'>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <script src='js/script.js'></script>
        </head>";
    }

    // method to create the body section
    private function showBody()
    {
        echo "<body class='d-flex flex-column min-vh-100'>";
        echo "<main class='flex-column  pt-5' >
                <div class='container'>";
                Messages::displayMessage();
            $this->showContent();
        echo "</div>
            </main>";

        echo "</body>";
    }

    // method to show the content
    public function showContent()
    { 
    }

    // method to close the html page
    private function endPage() 
    { 
        echo "</html>"; 
    } 

}//end class