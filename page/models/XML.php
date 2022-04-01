<?php

class XML
{
    protected $data;
    private $prod;

    public function __construct($data)
    {
        $this->data = $data;
        if(isset($this->data['product']))
        {
            
            $this->prod = "product";
        }
        else
        {
            $this->prod = "products";
        }
    }

    public function getContent()
    {
        $dom     = new DOMDocument('1.0', 'utf-8'); 
        $root      = $dom->createElement('productList'); 

        if($this->prod == "product")
        {
            $filePath = 'product.xml';
            foreach($this->data as $k => $v)
            {
                $productId        =  $this->data[$this->prod]->productid;  
                $productName      =   htmlspecialchars($this->data[$this->prod]->productnaam);
                $productPrice    =  $this->data[$this->prod]->productprijs; 
                $productInfo     =  $this->data[$this->prod]->productomschrijving;   
                $product = $dom->createElement('product');

                $product->setAttribute('id', $productId);

                $name     = $dom->createElement('name', $productName); 
                $product->appendChild($name); 

                $author   = $dom->createElement('price', $productPrice); 
                $product->appendChild($author); 

                $price    = $dom->createElement('info', $productInfo); 
                $product->appendChild($price); 
                
                $root->appendChild($product);
            }
        }
        else
        {
            $filePath = 'products.xml';
            for($i=0; $i < count($this->data[$this->prod]); $i++)
            {
                $productId        =  $this->data[$this->prod][$i]->productid;  
                $productName      =   htmlspecialchars($this->data[$this->prod][$i]->productnaam);
                $productPrice    =  $this->data[$this->prod][$i]->productprijs; 
                $productInfo     =  $this->data[$this->prod][$i]->productomschrijving;   
                $product = $dom->createElement('product');

                $product->setAttribute('id', $productId);

                $name     = $dom->createElement('name', $productName); 
                $product->appendChild($name); 

                $author   = $dom->createElement('price', $productPrice); 
                $product->appendChild($author); 

                $price    = $dom->createElement('info', $productInfo); 
                $product->appendChild($price); 

                $root->appendChild($product);
            }
        }
        $dom->appendChild($root); 
        $dom->save($filePath); 

        $file = file_get_contents($filePath);
        echo $file;
        // echo "XML file created successfully!<br />";
        // echo "<a href='".$filePath."'>Open</a> the XML file";
    }
}