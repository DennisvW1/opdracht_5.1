<?php

class OverviewView extends HtmlDoc
{
    protected $toShow;
    protected $data;
    protected $amount;

    public function __construct($toShow, $data, $amount)
    {
        $this->toShow = $toShow;
        $this->data = $data;
        $this->amount = $amount;
    }

    public function showContent()
    {
        switch($this->toShow)
        {
            case "items":
                $this->showItems();
                break;
            case "rating":
                $this->showRating();
                break;
            case "lastDays":
                $this->orderedLastDays();
                break;
        }
    }

    protected function showItems()
    {
        if(empty($this->data))
        {
            echo "<div class='h3'>Er is nog geen bestelling gedaan..</div>";
        }
        else
        {
            echo "<div class='col mb-5'>
            <div class='row'>";
            if($this->amount == 0)
            {
                echo "<div class='col h1 text-center text-body'>Most sold item</div>";
            }
            else
            {
                echo "<div class='col h1 text-center text-body'>Top $this->amount of most sold items</div>";
            }
            echo "</div>
            <div class='row mt-3'>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'>Product</div>
                <div class='col'>Sold</div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
            </div>
            ";
            foreach($this->data as $row)
            {
                echo "<div class='row mt-2'>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'><img src='images/" . $row->productnaam . ".png' width=50 height=40 /></div>
                <div class='col'><a href=index.php?page=product&id=" . $row->productid . ">".$row->productnaam."</a></div>
                <div class='col'>". $row->sum."</div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                </div>";
            }
            echo "</div>";
        }
    }

    protected function showRating()
    {
        if(empty($this->data))
        {
            echo "<div class='h3'>No product has been rated yet..</div>";
        }
        else
        {
            echo "<div class='col mb-5'>
            <div class='row'>";
            if($this->amount == 1)
            {
                echo "<div class='col h1 text-center text-body'>Best rated item</div>";
            }
            else
            {
                echo "<div class='col h1 text-center text-body'>Top $this->amount of top rated items</div>";
            }
            echo "</div>
            <div class='row mt-3'>
                <div class='col'></div>

                <div class='col'>Product</div>
                <div class='col'>Rated</div>
                <div class='col'>Rating</div>
                <div class='col'></div>

            </div>
            ";
            foreach($this->data as $row)
            {
                echo "<div class='row mt-2'>
                <div class='col'></div>

                <div class='col'><img src='images/" . $row->productnaam . ".png' width=50 height=40 /> <a href=index.php?page=product&id=" . $row->productid . ">".$row->productnaam."</a></div>
                <div class='col'>". $row->aantal ."</div>
                <div class='col'>

                <form class='rateShop' action='' method='POST'>
                    <input type='radio' id='star5' ". (($row->avg >= 5)?'checked=checked':'') .">
                    <label for='star5'></label>
                    <input type='radio' id='star4' ". (($row->avg >= 4)?'checked=checked':'') .">
                    <label for='star4'></label>
                    <input type='radio' id='star3' ". (($row->avg >= 3)?'checked=checked':'') .">
                    <label for='star3'></label>
                    <input type='radio' id='star2' ". (($row->avg >= 2)?'checked=checked':'') .">
                    <label for='star2'></label>
                    <input type='radio' id='star1' ". (($row->avg >= 1)?'checked=checked':'') .">
                    <label for='star1'></label>
                </form>

                </div>
                <div class='col'></div>

                </div>";
            }
            echo "</div>";
        }
    }

    protected function orderedLastDays()
    {
        if(empty($this->data))
        {
            echo "<div class='h3'>Er is nog geen bestelling gedaan..</div>";
        }
        else
        {
            echo "<div class='col mb-5'>
            <div class='row'>";
            if($this->amount == 0)
            {
                echo "<div class='col h1 text-center text-body'>Most sold item</div>";
            }
            else
            {
                echo "<div class='col h1 text-center text-body'>Sold items in the last $this->amount days</div>";
            }
            echo "</div>
            <div class='row mt-3'>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'>Order ID</div>
                <div class='col'>Order Date</div>
                <div class='col'>Product</div>
                <div class='col'></div>
                <div class='col'>Sold</div>
                <div class='col'>User ID</div>
                <div class='col'>User Name</div>
                <div class='col'></div>
                <div class='col'></div>
            </div>";

            $oid = $this->data[0]->bestellingid;
            $id = 0;
            $product = 0;
                foreach($this->data as $row)
                {
                    
                    $id = $row->bestellingid;
                    if($oid !== $id)
                    {
                        echo "<hr style='width:65%; margin: auto;'>";
                    }
                    echo "<div class='row mt-2'>
                    <div class='col'></div>
                    <div class='col'></div>
                    <div class='col'>".$row->bestellingid."</div>
                    <div class='col'>".$row->bestellingdatum."</div>
                    <div class='col'><img src='images/" . $row->productnaam . ".png' width=50 height=40 /></div>
                    <div class='col'><a href=index.php?page=product&id=" . $row->productid . ">".$row->productnaam."</a></div>
                    <div class='col'>". $row->productaantal ."</div>
                    <div class='col'>". $row->id."</div>
                    <div class='col'>". $row->naam."</div>
                    <div class='col'></div>
                    <div class='col'></div>
                    </div>";

                        $oid = $id;
                    $product++;
                        
                }
            echo "</div>";
        }
    }

}