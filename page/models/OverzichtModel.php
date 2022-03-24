<?php
require_once MODELROOT."Autoloader.php";
class OverzichtModel
{

    protected $model;
    protected $insert;

    public function __construct($model, $insert)
    {
        $this->model = $model;
        $this->insert = $insert;
    }

    public function showContent()
    {
        switch($this->model)
        {
            case "items":
                    $this->overviewSoldItems($this->insert);
                break;
            case "rating":
                	$this->overviewRating($this->insert);
                break;
        }
    }

    protected function overviewSoldItems()
    {
        $result = new DatabasePDO();
        $data = $result->getSoldItems($this->insert);
        if(empty($data))
        {
            echo "<div class='h3'>Er is nog geen bestelling gedaan..</div>";
        }
        else
        {
            echo "<div class='col mb-5'>
            <div class='row'>";
            if($this->insert == 1)
            {
                echo "<div class='col h1 text-center text-body'>Most sold item</div>";
            }
            else
            {
                echo "<div class='col h1 text-center text-body'>Top $this->insert of most sold items</div>";
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
            foreach($data as $row)
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

    protected function overviewRating()
    {
        $result = new DatabasePDO();
        $data = $result->getBestRatedProduct($this->insert);

        if(empty($data))
        {
            echo "<div class='h3'>No product has been rated yet..</div>";
        }
        else
        {
            echo "<div class='col mb-5'>
            <div class='row'>";
            if($this->insert == 1)
            {
                echo "<div class='col h1 text-center text-body'>Best rated item</div>";
            }
            else
            {
                echo "<div class='col h1 text-center text-body'>Top $this->insert of top rated items</div>";
            }
            echo "</div> 
            <div class='row mt-3'>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'>Product</div>
                <div class='col'>Rating</div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
            </div>
            ";
            foreach($data as $row)
            {
                echo "<div class='row mt-2'>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'><img src='images/" . $row->productnaam . ".png' width=50 height=40 /></div>
                <div class='col'><a href=index.php?page=product&id=" . $row->productid . ">".$row->productnaam."</a></div>
                <div class='col'>". $row->avg."</div>
                <div class='col'></div>
                <div class='col'></div>
                <div class='col'></div>
                </div>";
            }
            echo "</div>";
        }
    }
}