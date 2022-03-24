<?php
require_once MODELROOT."Autoloader.php";
    
class WinkelwagenModel
{
    private $gebruikersId;
    private $lastorder;
    private $db;

    public function __construct()
    {
        $this->db = new DatabasePDO();

        try
        {            
            $email = $_SESSION['user_email'];
            $this->gebruikersId = $this->db->getId($email);
            $this->lastorder = $this->db->getLastOrder($this->gebruikersId);
        }
        catch(PDOException $e)
        {
            Messages::setMessage($e, "error");
        }

    }

    public function getOrderedDetails()
    {
            $row = $this->db->getOrderDetails($this->gebruikersId, $this->lastorder);
                    // unset the session details to clear the shopping cart
                    unset($_SESSION['cart']);
                    unset($_SESSION['checkout_success']);
            return $row;

    }

    public function getOrderedTotalPrice()
    {
            $total_price = $this->db->getTotalPrice($this->gebruikersId, $this->lastorder);

            return $total_price;
    }

    public function showCart()
    {
        $total_price = $total_price ?? 0;

        echo "
        <div class='mb-3'>
            <div class='row'>
            <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'>Product</div>
                <div class='col'>Amount</div>
                <div class='col'>Price each</div>
                <div class='col'>Total</div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
            </div>";
                foreach ($_SESSION["cart"] as $product)
                {
                    echo "
                    <div class='row mt-3'>
                    <div class='col'></div>
                        <div class='col'></div>
                        <div class='col'><a href=index.php?page=product&id=" . $product['id'] . "><img src='images/" . $product['name'] . ".png' width=70 height=60 /></a></div>
                        <div class='col'>" . ucfirst($product['name']) . "</div>
                        <div class='col'>
                            <form method='POST' action=''>
                            <input type='hidden' name='name' value='". $product['name'] ."'>
                            <input type='hidden' name='page' value='change'>
                            <select class='alert alert-dark' name='quantity' id='quantity' onchange='this.form.submit()'>";
                            for($i = 1; $i < 6; $i++)
                            {
                                if($product["quantity"] == $i)
                                {
                                    echo "<option selected value=$i>$i</option>";
                                }
                                else
                                {
                                    echo "<option value=$i>$i</option>";
                                }
                            }
                            echo "</select></form></div>
                        <div class='col'>€ " . number_format($product['price'], 2, ',', '') . "</div>
                        <div class='col'>€ " . number_format((float)($product["price"]*$product["quantity"]), 2, ',', '') . "</div>
                        <div class='col'><form method='POST' action=''>
                                        <input type='hidden' name='delete' value='".$product['name']."'>
                                        <input type='hidden' name='page' value='delete'>
                                        <input class='alert alert-danger' type='submit' name='submit' value='Delete'></form></div>";
                        $total_price += ($product["price"]*$product["quantity"]);
                    echo "<div class='col'></div>
                    <div class='col'></div></div>";
                }
            echo "
            </div>
        
        <div class='text-center mt-3'>
            <div class='row'>
                <div class='col'></div>
                    <div class='col'></div>
                        <div class='col'>
                            <strong>Grand total € ". number_format((float)($total_price), 2, ',', '') ."</strong>
                        </div>
                            <div class='col'></div>
            </div>
            <div class='row mt-3'>
                    <div class='col'></div>
                        <div class='col'>
                        <form method='post' action=''>
                            <input type='hidden' name='page' id='page' value='webshop'>
                            <input class='alert alert-info' type='submit' id='submit' name='submit' value='Return to webshop'>
                            </form></div>
                            <div class='col'>
                                <form method='post' action=''>
                                <input type='hidden' name='afrekenen' id='page' value='afrekenen'>
                                <input class='alert alert-success' type='submit' id='submit' name='submit' value='Place order'>
                                <input type='hidden' name='page' id='page' value='afrekenen'>
                                </form> 
                            </div>
                                <div class='col'></div>
            </div>
        </div>";
    }

    public function showCheckout()
    {

            echo "<div class='mt-3'>
                    <div class='h2 text-success text-center'>Bestelling geslaagd!</div>
                </div>";
            $total_price = $this->getOrderedTotalPrice();
            $row = $this->getOrderedDetails();
            foreach($row as $row){
                echo "
                <div class='mb-3'>
                    <div class='row'>
                    <div class='col'></div>
                        <div class='col'></div>
                        <div class='col'></div>
                        <div class='col'>Product</div>
                        <div class='col'>Amount</div>
                        <div class='col'>Price each</div>
                        <div class='col'>Total</div>
                        <div class='col'></div>
                        <div class='col'></div>
                        <div class='col'></div>
                    </div>
                            <div class='row mt-3'>
                            <div class='col'></div>
                                <div class='col'></div>
                                <div class='col'><img src='images/" . $row->productnaam . ".png' width=70 height=60 /></div>
                                <div class='col'>" . ucfirst($row->productnaam) . "</div>
                                <div class='col'>" . $row->productaantal . "</div>
                                <div class='col'>€ " . $row->productprijs . "</div>
                                <div class='col'>€ ". number_format((float)($row->productprijs * $row->productaantal), 2, ',', '') ."</div>
                                <div class='col'></div>";
                            echo "<div class='col'></div>
                            <div class='col'></div></div>
                    </div>";
            
            }
            echo "<div class='text-center mt-3'>
            <div class='row'>
                <div class='col'></div>
                    <div class='col'></div>
                        <div class='col'>
                            <strong>Grand total € ". $total_price ."</strong>
                        </div>
                            <div class='col'></div>
                </div>
            </div>";
    }
}