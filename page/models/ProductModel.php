<?php
require_once MODELROOT."Autoloader.php";

class ProductModel
{
    private $id;
    private $db;

    public function showProduct()
    {
        if(isset($_GET['id']))
        {
            $this->id = $_GET['id'];
        }

        echo "<div class='h1'>Product</div>
        <div class='row pt-3'>";
        $this->db = new DatabasePDO();
        $this->db->getProduct($this->id);
        $result = $this->db->rowCount();
        $product = $this->db->getRating($this->id);
        if ($result == 1) 
        {
            echo "
            <div class='container mt-3 mb-3'>
                <div class='card' style='width:30%'>
                    <img class='card-img-top' src='images/" . $product->productnaam . ".png' alt='" . $product->productnaam . "' style='width:100%'>
                        <div class='card-body'>
                            <div class='text-center'>
                                <h4 class='card-title'>".ucfirst($product->productnaam)."</h4>
                                <p class='card-text'>Price € " . $product->productprijs . "</p>";
                                if(isset($_SESSION['user_name']))
                                {
                                    echo "
                                    <form class='rate' action='' method='POST'>
                                        <input type='radio' id='star5' name='rating' value='5' ". (($product->average_rating >= 5)?'checked=checked':'') .">
                                        <label for='star5'></label>
                                        <input type='radio' id='star4' name='rating' value='4' ". (($product->average_rating >= 4)?'checked=checked':'') .">
                                        <label for='star4'></label>
                                        <input type='radio' id='star3' name='rating' value='3' ". (($product->average_rating >= 3)?'checked=checked':'') .">
                                        <label for='star3'></label>
                                        <input type='radio' id='star2' name='rating' value='2' ". (($product->average_rating >= 2)?'checked=checked':'') .">
                                        <label for='star2'></label>
                                        <input type='radio' id='star1' name='rating' value='1' ". (($product->average_rating >= 1)?'checked=checked':'') .">
                                        <label for='star1'></label>
                                        <input type='hidden' name='id' id='id' value='" . $product->productid . "'>
                                    </form>
                                    ";
                                }
                                else
                                {
                                    echo "
                                    <form class='rate' action='' method='POST'>
                                        <input type='radio' id='star5' name='rating' value='5' ". (($product->average_rating >= 5)?'checked=checked':'') ." disabled>
                                        <label for='star5'></label>
                                        <input type='radio' id='star4' name='rating' value='4' ". (($product->average_rating >= 4)?'checked=checked':'') ." disabled>
                                        <label for='star4'></label>
                                        <input type='radio' id='star3' name='rating' value='3' ". (($product->average_rating >= 3)?'checked=checked':'') ." disabled>
                                        <label for='star3'></label>
                                        <input type='radio' id='star2' name='rating' value='2' ". (($product->average_rating >= 2)?'checked=checked':'') ." disabled>
                                        <label for='star2'></label>
                                        <input type='radio' id='star1' name='rating' value='1' ". (($product->average_rating >= 1)?'checked=checked':'') ." disabled>
                                        <label for='star1'></label>
                                    </form>
                                    ";
                                }
                                
                                echo "
                                <br><br>
                                <p class='overall-rating'>
                                    (Average Rating <span id='avgrat'>". $product->average_rating ."</span>
                                    Based on <span id='totalrat'>". $product->rating_num ."</span> rating)</span>
                                </p>
                                
                                <p class='card-text'>" . $product->productomschrijving . "</p>";
                                if(isset($_SESSION['user_name']))
                                {
                                    echo "<form method='post' action=''>
                                    <div class='text-center'>
                                    <input type='hidden' name='page' id='page' value='bestel'>
                                    <input class='btn btn-outline-dark mt-auto' type='submit' id='submit' name='submit' value='Order'>
                                    <input type='hidden' name='id' id='id' value='" . $product->productid . "'>
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

    if(isset($_POST['action']) && $_POST['action'] == "insert")
    {
        // Rating class
        // $rate = new Rating("product", $_POST);
        echo "succes!!!!";
    }
    }
}