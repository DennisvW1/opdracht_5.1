<?php
require_once MODELROOT."Autoloader.php";
class OverzichtModel
{
    public function overviewSoldItems($amount)
    {
        $result = new DatabasePDO();
        $data = $result->getSoldItems($amount);
        if(empty($data))
        {
            echo "<div class='h3'>Er is nog geen bestelling gedaan..</div>";
        }
        else
        {
            echo "<div class='col mb-5'>
            <div class='row'>";
            if($amount == 1)
            {
                echo "<div class='col h1 text-center text-body'>Most sold item</div>";
            }
            else
            {
                echo "<div class='col h1 text-center text-body'>Top $amount of most sold items</div>";
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
}