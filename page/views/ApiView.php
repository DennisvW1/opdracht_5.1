<?php

class ApiView extends HtmlDoc
{
    public function __construct()
    {
        
    }

    public function showContent()
    {
        echo "Welcome on the API page <br /><br />
                Here we will explain the different options we offer. <br />
                    You can choose to see one, all, or a max number of products in: <br />    
                        JSON, XML, HTML <br /><br />";
        $this->JSON();
        echo "<br /><br /><br />";
        $this->XML();
    }

    protected function JSON()
    {
        echo "<div class=h3>JSON format</div>";
        echo "If you wish to get only one item from our webshop please use the following link: <br />
        ".ROOTURL."/index.php?page=api&type=json&qty=one&id=:productid <br />
        ".ROOTURL."/index.php?page=api&type=json&qty=all <br />
        ".ROOTURL."/index.php?page=api&type=json&qty=limit&limit=:maxproducts <br /><br />
        For example: <br />
        <a href='".ROOTURL."/index.php?page=api&type=json&qty=one&id=1' target='_new'>".ROOTURL."/index.php?page=api&type=json&qty=one&id=1</a> <br />
        <a href='".ROOTURL."/index.php?page=api&type=json&qty=all' target='_new'>".ROOTURL."/index.php?page=api&type=json&qty=all</a> <br />
        <a href='".ROOTURL."/index.php?page=api&type=json&qty=limit&limit=2' target='_new'>".ROOTURL."/index.php?page=api&type=json&qty=limit&limit=2</a>";
    }

    protected function XML()
    {
        echo "<div class=h3>XML format</div>";
        echo "If you wish to get only one item from our webshop please use the following link: <br />
        ".ROOTURL."/index.php?page=api&type=xml&qty=one&id=:productid <br />
        ".ROOTURL."/index.php?page=api&type=xml&qty=all <br />
        ".ROOTURL."/index.php?page=api&type=xml&qty=limit&limit=:maxproducts <br /><br />
        For example: <br />
        <a href='".ROOTURL."/index.php?page=api&type=xml&qty=one&id=1' target='_new'>".ROOTURL."/index.php?page=api&type=xml&qty=one&id=1</a> <br />
        <a href='".ROOTURL."/index.php?page=api&type=xml&qty=all' target='_new'>".ROOTURL."/index.php?page=api&type=xml&qty=all</a> <br />
        <a href='".ROOTURL."/index.php?page=api&type=xml&qty=limit&limit=2' target='_new'>".ROOTURL."/index.php?page=api&type=xml&qty=limit&limit=2</a>";
    }
}