<?php

class WebshopView extends HtmlDoc
{
    protected $data;
    protected $db;

    public function __construct($data)
    {
        $this->data = $data;
        $this->db = new DatabasePDO();
    }

    public function showContent()
    {
        $this->showWebshop();
    }

    protected function showWebshop()
    {
        echo "<div class='h1 text-center'>Webshop</div>
        <div class='row pt-3'>";
        echo "<section class='pt-3'>
        <div class='container'>
            <div class='row mt-3'>";

        foreach($this->data as $product)
        {
            $productRating = $this->db->getRating($product->productid);

            echo "  <div class='col mb-5'>
                        <div class='card h-100'>
                            <a href=index.php?page=product&id=" . $product->productid . "><img class='card-img-top' src='images/" . $product->productnaam . ".png' alt='" . $product->productnaam . "' /></a>
                            <div class='card-body p-2'>
                                <div class='text-center'>
                                
                            <form class='rate' action='' method='POST'>
                                <input type='radio' id='star5_" . $product->productid . "' data-id='" . $product->productid . "' data-value='5' ". (($productRating->average_rating >= 5)?'checked=checked':'') .">
                                <label for='star5_" . $product->productid . "'></label>
                                <input type='radio' id='star4_" . $product->productid . "' data-id='" . $product->productid . "' data-value='4' ". (($productRating->average_rating >= 4)?'checked=checked':'') .">
                                <label for='star4_" . $product->productid . "'></label>
                                <input type='radio' id='star3_" . $product->productid . "' data-id='" . $product->productid . "' data-value='3' ". (($productRating->average_rating >= 3)?'checked=checked':'') .">
                                <label for='star3_" . $product->productid . "'></label>
                                <input type='radio' id='star2_" . $product->productid . "' data-id='" . $product->productid . "' data-value='2' ". (($productRating->average_rating >= 2)?'checked=checked':'') .">
                                <label for='star2_" . $product->productid . "'></label>
                                <input type='radio' id='star1_" . $product->productid . "' data-id='" . $product->productid . "' data-value='1' ". (($productRating->average_rating >= 1)?'checked=checked':'') .">
                                <label for='star1_" . $product->productid . "'></label>
                            </form>

                                <br><br>
                                <p class='overall-rating'>
                                (Average Rating <span class='avgrat' id='avgrat_" . $product->productid . "'>". $productRating->average_rating ."</span>
                                Based on <span class='totalrat' id='totalrat_" . $product->productid . "'>". $productRating->rating_num ."</span> rating)</span>
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
    }
}