<?php
    require_once 'RSSFeed.class.php';
	
	//function to show items separately into sale section and catalog section.
    function show_sale_items(){
    // create a new DomDocument instance
	$file = file_get_contents('catalog.xml');
	$dom = new DomDocument();
	
	// load the XML file
	$dom->loadXML($file);
	
	$all_products= $dom->getElementsByTagName('product');
	$val=0;							
    $string= '';
	echo "<h2 class='heading'>SALE ITEMS</h2>";
	
	foreach($all_products as $product){
	
	 if (isset($_REQUEST['page'])) {
	$currentPage = $_REQUEST['page'];
    } else {
	$currentPage = 0;
    }
	
	$description = $product->getElementsByTagName('description');
	$price = $product->getElementsByTagName('price');
	$quantity = $product->getElementsByTagName('quantity');
	$image = $product->getElementsByTagName('image_name');
	$sale_price = $product->getElementsByTagName('sale_price');
	$desc_value= @$description->item(0)->nodeValue;
	$price_value= @$price->item(0)->nodeValue;
	$quantity_value= $quantity->item(0)->nodeValue-1;
	$image_value= @$image->item(0)->nodeValue;
	$sale_value= @$sale_price->item(0)->nodeValue;
	
	$product_name= $product->getAttribute('name');
	//$quantity_value=$quantity_value-1;
	
	if($sale_value> 0 && $sale_value<$price_value){
    echo "<br />";
    echo "<a href='permalink.php?item=$val'>$product_name</a>";
    echo "<br />";
    echo "<div class='img'> <img src='images/$image_value' height=150 width=140 alt='product image' /> </div>";
     
    echo "<strong>Product description: </strong>$desc_value";
    echo "<br />";
    echo "<strong>Retail price: </strong>"."$".$price_value;
    echo "<br />";
    echo "<strong>Quantity left: </strong>$quantity_value";
    echo "<br />";
    echo "<strong>Discounted price: </strong>"."$".$sale_value;
    echo "<br />";
    
    echo "<form action='index.php?page=" . ($currentPage) . "' method='POST' ><input type='submit' name='add' value='Add To Cart' /><input type='hidden' name='item' value = '$val' /></form>";
    
    echo "<br />";
    echo "<br />";
    echo "<br />";
    
    }
	$val= $val + 1;
	}
	//$dom->save('catalog.xml');
	
	if ( isset( $_POST['add'] )){
	
	$item= $_POST['item'];
	
	$file = @file_get_contents('catalog.xml');
	$dom = new DomDocument();
	
	// load the XML file
	$dom->loadXML($file);
	$product= $dom->getElementsByTagName('product')->item($item);
	 	
	$description = $product->getElementsByTagName('description');
	$price = $product->getElementsByTagName('price');
	$quantity = $product->getElementsByTagName('quantity');
	$image = $product->getElementsByTagName('image_name');
	$sale_price = $product->getElementsByTagName('sale_price');
	$desc_value= $description->item(0)->nodeValue;
	$price_value= $price->item(0)->nodeValue;
	$quantity_value= $quantity->item(0)->nodeValue;
	$image_value= $image->item(0)->nodeValue;
	$sale_value= $sale_price->item(0)->nodeValue;
	
	$product_name= $product->getAttribute('name');
	$dom->save('catalog.xml');
	
	
	if($quantity_value<=0){
    echo "<h2 class='message'>Can't add item</h2>";
    $quantity_value=0;
    }
	
	else{
	//print_r($quantity_value);
	echo "<h2 class='message'>ITEM ADDED TO THE CART!</h2>";
    
	echo "<br />";
	
    // create a new DomDocument instance
	$file1 = 'cart.xml';
	$dom1 = new DomDocument();
	$dom1->load($file1);
 

	$products= $dom1->createElement('products');
	$prod= $dom1->createElement('product');
	
	$prod_name=$dom1->createTextNode($product_name);
	$prod->appendChild($prod_name);
	$products->appendChild($prod);

	
	$desc=$dom1->createElement('description');
	$desc_val=$dom1->createTextNode($desc_value);
	$desc->appendChild($desc_val);
	$products->appendChild($desc);
	
	
	$price= $dom1->createElement('price');
	$price_val= $dom1->createTextNode($price_value);
	$price->appendChild($price_val);
	$products->appendChild($price);
	
	$quan=$dom1->createElement('quantity');
	
	$quan_val= $dom1->createTextNode($quantity_value);
	$quan->appendChild($quan_val);
	$products->appendChild($quan);
	
	$img= $dom1->createElement('image_name');
	$img_val= $dom1->createTextNode($image_value);
	$img->appendChild($img_val);
	$products->appendChild($img);
	
	$sale= $dom1->createElement('sale_price');
	$sale_val= $dom1->createTextNode($sale_value);
	$sale->appendChild($sale_val);
	$products->appendChild($sale);

	$dom1->documentElement->appendChild($products);
	
	$dom1->save($file1);
	
	$file = file_get_contents('catalog.xml');
	$dom5 = new DomDocument();
	
	// load the XML file
	$dom5->loadXML($file);
	$product = $dom5->getElementsByTagName('product')->item($item); 
	//echo "Item no is:" .$item;
	$quantity_value=$quantity_value-1;
	if($quantity_value<=0){
    echo "<h2 class='message'>Can't add item</h2>";
    $quantity_value=0;
    }
	$product->getElementsByTagName('quantity')->item(0)->nodeValue = $quantity_value;
	$dom5->save('catalog.xml');
	
    }
	
	
	}
	show_catalog_items();
    }
	
	
	/* 
	Function to show the catalog items separately from sales items and adding the add to cart buttons decrements the quantity count and adds the item to the cart.php and to cart.xml file.
	*/

	function show_catalog_items(){
	$val1=0;
	$file = file_get_contents('catalog.xml');
	$dom = new DOMDocument();
	
	// load the XML file
	$dom->loadXML($file);
	
	$all_products= $dom->getElementsByTagName('product');
	//echo "length:" . $all_products->length;
							
    $string= '';
	echo "<hr />";
	echo "<h2 class='heading'>CATALOG ITEMS</h2>";
	foreach($all_products as $product){
	
	
	 if (isset($_REQUEST['page'])) {
	$currentPage = $_REQUEST['page'];
    } else {
	$currentPage = 0;
    }
	
	$description = $product->getElementsByTagName('description');
	$price = $product->getElementsByTagName('price');
	$quantity = $product->getElementsByTagName('quantity');
	$image = $product->getElementsByTagName('image_name');
	$sale_price = $product->getElementsByTagName('sale_price');
	$desc_value= @$description->item(0)->nodeValue;
	$price_value= @$price->item(0)->nodeValue;
	$quantity_value= @$quantity->item(0)->nodeValue-1;
	$image_value= @$image->item(0)->nodeValue;
	$sale_value= @$sale_price->item(0)->nodeValue;
	//$quantity_value=$quantity_value-1;
	
	$product_name= $product->getAttribute('name');
	if($sale_value==0){
    echo "<br />";
    echo "<a href='permalink.php?item=$val1'>$product_name</a>";
    echo "<br />";
    echo "<div class='img'> <img src='images/$image_value' height=150 width=140 alt='product image' /> </div>";
    
    echo "<strong>Product description: </strong>$desc_value";
    echo "<br />";
    echo "<strong>Retail price: </strong>"."$".$price_value;
    echo "<br />";
    echo "<strong>Quantity left: </strong>$quantity_value";
    echo "<br />";
    echo "<form action='index.php?page=" . ($currentPage ) . "' method='POST' > <input type='submit' name='add1' value='Add To Cart' /><input type='hidden' name='item1' value = '$val1' /></form>";
    
    echo "<br />";
    echo "<br />";
    echo "<br />";
    }
	//echo $_GET['item'];
    $val1=$val1+1;
    }
	
	    echo "<form action='index.php' method='POST'>";
    echo "<div id='dropdown'>";
	echo "Select number of items to view: <select name='dropdown'> 
    <option value='5'>5</option>
    <option value='6'>6</option>
    <option value='7'>7</option>
    <option value='8'>8</option>

    </select>";
    echo "<input type='submit' name='select' value='Choose' />";
	echo "</div>";
    echo "</form>";

	 if ( isset( $_POST['add1'] )){
	  $item1= $_POST['item1'];
	  //echo $item1;
	  $file = file_get_contents('catalog.xml');
	$dom = new DomDocument();
	
	// load the XML file
	$dom->loadXML($file);
	$product= $dom->getElementsByTagName('product')->item($item1);
	 	
	$description = $product->getElementsByTagName('description');
	$price = $product->getElementsByTagName('price');
	$quantity = $product->getElementsByTagName('quantity');
	$image = $product->getElementsByTagName('image_name');
	$sale_price = $product->getElementsByTagName('sale_price');
	$desc_value= $description->item(0)->nodeValue;
	$price_value= $price->item(0)->nodeValue;
	$quantity_value= $quantity->item(0)->nodeValue;
	$image_value= $image->item(0)->nodeValue;
	$sale_value= $sale_price->item(0)->nodeValue;
	
	$product_name= $product->getAttribute('name');
   
    
	echo "<br />";
    // create a new DomDocument instance
	$file1 = 'cart.xml';
	$dom1 = new DomDocument();
	$dom1->load($file1);
 

	$products= $dom1->createElement('products');
	$prod= $dom1->createElement('product');
	
	$prod_name=$dom1->createTextNode($product_name);
	$prod->appendChild($prod_name);
	$products->appendChild($prod);
	//$dom1->documentElement->appendChild($prod);
	
	// $dom1->appendChild($prod);
	
	$desc=$dom1->createElement('description');
	$desc_val=$dom1->createTextNode($desc_value);
	$desc->appendChild($desc_val);
	$products->appendChild($desc);
	
	
	$price= $dom1->createElement('price');
	$price_val= $dom1->createTextNode($price_value);
	$price->appendChild($price_val);
	$products->appendChild($price);
	
	$quan=$dom1->createElement('quantity');
	$quan_val= $dom1->createTextNode($quantity_value);
	$quan->appendChild($quan_val);
	$products->appendChild($quan);
	
	$img= $dom1->createElement('image_name');
	$img_val= $dom1->createTextNode($image_value);
	$img->appendChild($img_val);
	$products->appendChild($img);
	
	$sale= $dom1->createElement('sale_price');
	$sale_val= $dom1->createTextNode($sale_value);
	$sale->appendChild($sale_val);
	$products->appendChild($sale);
	
	$dom1->documentElement->appendChild($products);
	
	$dom1->save($file1);
	
	$file = file_get_contents('catalog.xml');
	$dom6 = new DomDocument();
	
	// load the XML file
	$dom6->loadXML($file);
	$product = $dom6->getElementsByTagName('product')->item($item1); 
	//echo "Item no is:" .$item1;
	$quantity_value = $quantity_value-1;
	if($quantity_value<=0){
    echo "<h2 class='message'>Can't add item</h2>";
    $quantity_value=0;
    }
	$product->getElementsByTagName('quantity')->item(0)->nodeValue = $quantity_value;
	$dom6->save('catalog.xml');
    }
	}
	
	
	//function to generate permalinks for individual items
	function permalink($perma_item){
	
	$file = file_get_contents('catalog.xml');
	$dom = new DomDocument();
	
	// load the XML file
	$dom->loadXML($file);
	
	$product= $dom->getElementsByTagName('product')->item($perma_item);
	//print_r( $product);
	$val=@$_GET['item '];							
    $string= '';
	
	 if (isset($_REQUEST['page'])) {
	$currentPage = $_REQUEST['page'];
    } else {
	$currentPage = 0;
    }
	
	$description = $product->getElementsByTagName('description');
	$price = $product->getElementsByTagName('price');
	$quantity = $product->getElementsByTagName('quantity');
	$image = $product->getElementsByTagName('image_name');
	$sale_price = $product->getElementsByTagName('sale_price');
	$desc_value= $description->item(0)->nodeValue;
	$price_value= $price->item(0)->nodeValue;
	$quantity_value= $quantity->item(0)->nodeValue;
	$image_value= $image->item(0)->nodeValue;
	$sale_value= $sale_price->item(0)->nodeValue;
	
	$product_name= $product->getAttribute('name');
	
	$a= "<h2 class='heading'>$product_name</h2>
    <br />
    <div class='img'> <img src='images/$image_value' height=150 width=140 alt='product image' /> </div>
    
   <strong>Product description: </strong>$desc_value
    <br />
   <strong>Retail price: </strong>$$price_value
    <br />
   <strong>Quantity left: </strong>$quantity_value
    <br />
    <form action='index.php?page= . ($currentPage ) . ' method='POST' > <input type='submit' name='add2' value='Add To Cart' /><input type='hidden' name='item1' value = '$val' /></form>
    
   <br />
   <br />
   <br />";
	

	
	
	return $a;
   
	}	
    ?> 