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
        $response = call_user_func(array($this, $this->type));
        echo $response;
    }

    private function home()
    {
        $response = "<div class='h1'>Home</div>
        <div class='row pt-3'>
        <p>Dit is een korte welkomstekst die hoort bij de home pagina van deze website</p>";

        return $response;
    }

    private function about()
    {
    $birthDate = "24-03-1990";
    $currentDate = date("d-m-Y");
    $age = date_diff(date_create($birthDate), date_create($currentDate));
    $age = $age->format("%y");

    $birthDate = "31-12-2019";
    $currentDate = date("d-m-Y");
    $son = date_diff(date_create($birthDate), date_create($currentDate));
    $son = $son->format("%y");

        $response = "<div class='h1'>About</div>
        <div class='row pt-3'>
        <p>Mijn naam is Dennis van Willigen, ik ben ". $age ." jaar oud. Ik heb een vrouw en een zoontje van ".$son." jaar oud en een nieuw kindje op komst.</p>

        <p>In de zomer van 2021 heb ik besloten voor mijzelf om me te gaan omscholen naar de IT. Ik had besloten om te willen gaan programmeren.
            Toen ben ik voor mijzelf gaan uitzoeken wat ik dan precies wilde gaan doen in het programmeren, tijdens de zoektocht gebruik gemaakt van W3Schools en Codecademy.
            Uiteindelijk heb ik ook nog bij Avans+ een cursus C# gevolgd met daarnaast verschillende cursussen op Udemy.com.</p>

        <p>Voor ik bij Educom aan de slag ging ben ik bijna 5 jaar werkzaam geweest in de logistiek.
            Dit heb ik altijd met plezier gedaan, maar zoals eerder aangegeven in de zomer van 2021 ben ik gaan nadenken of ik dit nog over 5 jaar wilde doen.</p>
            
        <p>Mijn hobbies zijn voetballen, tijd doorbrengen met mijn gezin, programmeren en carnaval. Voetballen doe ik bij de lokale vereniging <a href='https://www.redichem.nl' target='_new'>C.V.V. Redichem</a>.
            Tijd door brengen met mijn gezin doe ik het liefst zo veel mogelijk, vooral herinneringen maken samen met Sten, want dat is toch het mooiste wat er is.
            Bij de carnavalsvereniging uit Renkum ben ik actief als lid van de Raad van Elf, daarnaast maak ik ieder jaar het boekje en beheer ik de <a href='https://www.dedolleinstuivers.nl' target='_new'>website</a>.</p>
            </div></div>";

        return $response;
    }

}// end class