<?php
include MODELROOT."Autoloader.php";

class PageModel extends HtmlDoc
{
    private $page;
    private $db;
    
    public function __construct($page)
    {
        $this->page = $page;
        $this->db = new DatabasePDO();
    }

    public function showContent()
    {
        switch($this->page)
        {
            case "webshop":
                echo "<div class='h1 text-center'>Webshop</div>
                <div class='row pt-3'>";
                echo "<section class='pt-3'>
                <div class='container'>
                    <div class='row mt-3'>";

                $result = $this->db->getAllProducts();


                foreach($result as $product)
                {
                    $productRating = $this->db->getRating($product->productid);

                    echo "  <div class='col mb-5'>
                                <div class='card h-100'>
                                    <a href=index.php?page=product&id=" . $product->productid . "><img class='card-img-top' src='images/" . $product->productnaam . ".png' alt='" . $product->productnaam . "' /></a>
                                    <div class='card-body p-2'>
                                        <div class='text-center'>

                                            <form class='rateShop' action='' method='POST'>
                                                <input type='radio' id='star5' name='rating' value='5' ". (($productRating->average_rating >= 5)?'checked=checked':'') ." disabled>                                                
                                                <label for='star5'></label>
                                                <input type='radio' id='star4' name='rating' value='4' ". (($productRating->average_rating >= 4)?'checked=checked':'') ." disabled>
                                                <label for='star4'></label>
                                                <input type='radio' id='star3' name='rating' value='3' ". (($productRating->average_rating >= 3)?'checked=checked':'') ." disabled>
                                                <label for='star3'></label>
                                                <input type='radio' id='star2' name='rating' value='2' ". (($productRating->average_rating >= 2)?'checked=checked':'') ." disabled>
                                                <label for='star2'></label>
                                                <input type='radio' id='star1' name='rating' value='1' ". (($productRating->average_rating >= 1)?'checked=checked':'') ." disabled>
                                                <label for='star1'></label>
                                            </form>

                                        <br><br>
                                        <p class='overall-rating'>
                                        (Average Rating <span id='avgrat'>". $productRating->average_rating ."</span>
                                        Based on <span id='totalrat'>". $productRating->rating_num ."</span> rating)</span>
                                        </p>
                                            <h5 class='fw-bolder'>".ucfirst($product->productnaam)."</h5>
                                            € " . $product->productprijs . "
                                        </div>
                                    </div>
                                    
                                    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>";
                                    if(isset($_SESSION['user_name']))
                                    {
                                        echo "<form method='post' action='index.php'>
                                        <div class='text-center'>
                                        <input type='hidden' name='page' id='page' value='bestel'>
                                        <input class='alert alert-dark' type='submit' id='submit' name='submit' value='Order'>
                                        <input type='hidden' name='id' id='id' value='" . $product->productid . "'>
                                        </form></div>";
                                    }
                                    echo "
                                    </div>
                                </div>
                            </div>";
                }
                echo "      </div>
                        </div>
                    </section>";
                break;
            case "cart":
                if(!isset($_SESSION['cart']) || empty($_SESSION['cart']))
                {
                    echo "No items have been placed in your shopping cart yet, please fill the shopping cart in the <a href='index.php?page=webshop' class='alert-link'>webshop!</a>";
                }
                else
                {
                    $this->page = new WinkelwagenModel();
                    if(!isset($_SESSION['checkout_success']))
                    {
                        $this->page->showCart();
                    }
                    else
                    {
                        $this->page->showCheckout();
                    }
                }
                break;
            case "product":
                $this->page = new ProductModel();
                $this->page->showProduct();
                break;
            case "overview":
                $this->page = new OverzichtModel();
                $this->page->overviewSoldItems(1);
                echo "<hr>";
                $this->page->overviewSoldItems(3);
                echo "<hr>";
                $this->page->overviewSoldItems(5);
                break;
            case "admin":
                if(isset($_GET['admin']))
                {
                    $this->page = new Admin($_GET['admin']);
                    $this->page->showContent();;
                }
                else
                {
                    $this->page = new Admin();
                    $this->page->showContent();
                }
                break;
        }
    }
}