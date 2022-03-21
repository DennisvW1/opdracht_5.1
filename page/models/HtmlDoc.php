<?php
require_once MODELROOT."Autoloader.php";
// een abstracte basis class -> abstract zodat hiervan geen instantie aangeroepen kan worden
abstract class HtmlDoc implements IShowPage
{
    public function show()
    {
        $this->startPage();
        $this->startHead();
        $this->showBody();
        $this->endPage();
    }
    
    // method om de pagina te starten
    private function startPage() 
    { 
        echo "<!DOCTYPE html>
                <html>";
    } 

    // method om de head op te bouwen
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

    // method om de body op te bouwen
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

    // in deze method word de content aangeroepen, in de parent is die leeg
    public function showContent()
    { 
    }

    // method om de footer te maken
    private function showFooter()
    {
        echo"<footer class='footer mt-auto py-3 bg-dark'>
        <div class='container'>
            <span class='text-muted'>&copy;".date("Y")."&nbsp;Dennis van Willigen</span>
        </div>
        </footer>";
    }

    // method om de pagina te sluiten
    private function endPage() 
    { 
        echo "</html>"; 
    } 

}//end class