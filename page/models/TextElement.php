<?php
require_once MODELROOT."Autoloader.php";
class TextElement extends HtmlDoc
{
    protected $type;
    
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function showContent()
    {     
        switch ($this->type)
        {
            case "home":
                echo $this->home();
                break;
            case "about":
                echo $this->about();
                break;
        }
    }

    private function home()
    {
        echo "<div class='h1'>Home</div>
        <div class='row pt-3'>
        <p>Dit is een korte welkomstekst die hoort bij de home pagina van deze website</p>";
    }

    private function about()
    {
        echo "<div class='h1'>About</div>
        <div class='row pt-3'>";
        echo "<p>Mijn naam is Dennis van Willigen, ik ben 31 jaar oud. Ik heb een vrouw en een zoontje van 2 jaar oud en een nieuw kindje op komst.</p>";

        echo "<p>In de zomer van 2021 heb ik besloten voor mijzelf om me te gaan omscholen naar de IT. Ik had besloten om te willen gaan programmeren.
            Toen ben ik voor mijzelf gaan uitzoeken wat ik dan precies wilde gaan doen in het programmeren, tijdens de zoektocht gebruik gemaakt van W3Schools en Codecademy.
            Uiteindelijk heb ik ook nog bij Avans+ een cursus C# gevolgd met daarnaast verschillende cursussen op Udemy.com.</p>";

        echo "<p>Voor ik bij Educom aan de slag ging ben ik bijna 5 jaar werkzaam geweest in de logistiek.
            Dit heb ik altijd met plezier gedaan, maar zoals eerder aangegeven in de zomer van 2021 ben ik gaan nadenken of ik dit nog over 5 jaar wilde doen.</p>";

        echo "<p>Mijn hobbies zijn voetballen, tijd doorbrengen met mijn gezin, programmeren en carnaval. Voetballen doe ik bij de lokale vereniging <a href='https://www.redichem.nl' target='_new'>C.V.V. Redichem</a>.
                Tijd door brengen met mijn gezin doe ik het liefst zo veel mogelijk, vooral herinneringen maken samen met Sten, want dat is toch het mooiste wat er is.
                Bij de carnavalsvereniging uit Renkum ben ik actief als lid van de Raad van Elf, daarnaast maak ik ieder jaar het boekje en beheer ik de <a href='https://www.dedolleinstuivers.nl' target='_new'>website</a>.</p>
                </div></div>";
    }
}