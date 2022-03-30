<?php

class ProductView extends HtmlDoc
{
    protected $result;
    protected $rating;

    public function __construct($data)
    {
        $this->result = $data->result;
        $this->rating = $data->product;    
    }

    public function showContent()
    {
        $this->showProduct();
    }

    protected function showProduct()
    {
        echo "<div class='h1'>Product</div>
        <div class='row pt-3'>";

        if ($this->result == 1) 
        {
            echo "
            <div class='container mt-3 mb-3'>
                <div class='card' style='width:30%'>
                    <img class='card-img-top' src='images/" . $this->rating->productnaam . ".png' alt='" . $this->rating->productnaam . "' style='width:100%'>
                        <div class='card-body'>
                            <div class='text-center'>
                                <h4 class='card-title'>".ucfirst($this->rating->productnaam)."</h4>
                                <p class='card-text'>Price € " . $this->rating->productprijs . "</p>

                                <form class='rate' action='' method='POST'>
                                    <input type='radio' id='star5_" . $this->rating->productid . "' data-id='" . $this->rating->productid . "' data-value='5' ". (($this->rating->average_rating >= 5)?'checked=checked':'') .">
                                    <label for='star5_" . $this->rating->productid . "'></label>
                                    <input type='radio' id='star4_" . $this->rating->productid . "' data-id='" . $this->rating->productid . "' data-value='4' ". (($this->rating->average_rating >= 4)?'checked=checked':'') .">
                                    <label for='star4_" . $this->rating->productid . "'></label>
                                    <input type='radio' id='star3_" . $this->rating->productid . "' data-id='" . $this->rating->productid . "' data-value='3' ". (($this->rating->average_rating >= 3)?'checked=checked':'') .">
                                    <label for='star3_" . $this->rating->productid . "'></label>
                                    <input type='radio' id='star2_" . $this->rating->productid . "' data-id='" . $this->rating->productid . "' data-value='2' ". (($this->rating->average_rating >= 2)?'checked=checked':'') .">
                                    <label for='star2_" . $this->rating->productid . "'></label>
                                    <input type='radio' id='star1_" . $this->rating->productid . "' data-id='" . $this->rating->productid . "' data-value='1' ". (($this->rating->average_rating >= 1)?'checked=checked':'') .">
                                    <label for='star1_" . $this->rating->productid . "'></label>
                                </form>
                                    
                                <br><br>
                                <p class='overall-rating'>
                                    (Average Rating <span id='avgrat'>". $this->rating->average_rating ."</span>
                                    Based on <span id='totalrat'>". $this->rating->rating_num ."</span> rating)</span>
                                </p>
                                
                                <p class='card-text'>" . $this->rating->productomschrijving . "</p>";
                                if(isset($_SESSION['user_name']))
                                {
                                    echo "<form method='post' action=''>
                                    <div class='text-center'>
                                    <input type='hidden' name='page' id='page' value='bestel'>
                                    <input class='btn btn-outline-dark mt-auto' type='submit' id='submit' name='submit' value='Order'>
                                    <input type='hidden' name='id' id='id' value='" . $this->rating->productid . "'>
                                    </form>";
                                }
                                echo "
                            </div>
                        </div>
                </div>
            </div>";

            echo "<div class='container mt-3 mb-3'>
            <div class='row'>
                <div class='col'>
                    <form method='post' action=''>
                    <input type='hidden' name='page' id='page' value='webshop'>
                    <input class='alert alert-alarm' type='submit' id='submit' name='submit' value='Return to webshop'>
                    </form></div>
                <div class='col'>";
                if(isset($_SESSION['user_name']))
                {
                        echo "<form method='post' action=''>
                        <input type='hidden' name='page' id='page' value='cart'>
                        <input class='alert alert-alarm' type='submit' id='submit' name='submit' value='Go to shoppingcart'>
                        </form>";
                }
            echo "</div>
            <div class='col'></div>
            <div class='col'></div>
            <div class='col'></div>
            <div class='col'></div>
            <div class='col'></div>
            </div>";
        }
        else
        {
            echo "No product was selected";
        }

    }
}