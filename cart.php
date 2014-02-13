<?php
			$title="Cart";
			include "header.php";

require_once 'anet_php_sdk/AuthorizeNet.php';
require_once 'P2_Utils.class.php';

function cart_items(){
	$string2='';
	$file = file_get_contents('cart.xml');
	$dom = new DOMDocument();
	$dom->loadXML($file);
	$all_products= $dom->getElementsByTagName('products');
	echo "<h2 class='heading'>CART ITEMS</h2>";
	echo "<br /> <br/>";
	$cost=0;
	if(isset($_POST['empty'])){
	$file = 'cart.xml';
	$dom = new DOMDocument();
	$dom->load($file);
	$root = $dom->getElementsByTagName('root')->item(0);
	//$all_products = $dom->getElementsByTagName('products')->item(0);
	$dom->removeChild($root);
	//$new_root = $dom->createElement('root');
	
	$new_root = $dom->createElement('root');
	$dom->appendChild($new_root);
	$dom->save('cart.xml');
	
	echo "<h2 class='message'>Your cart is empty</h2>";
	}

	
	else{
	foreach( $all_products as $product ){
	
	$product_name= $product->getElementsByTagName('product');
	$description = $product->getElementsByTagName('description');
	$price = $product->getElementsByTagName('price');
	$quantity = $product->getElementsByTagName('quantity');
	$image = $product->getElementsByTagName('image_name');
	$sale_price = $product->getElementsByTagName('sale_price');
	$prod_value= $product_name->item(0)->nodeValue;
	$desc_value= $description->item(0)->nodeValue;
	$price_value= $price->item(0)->nodeValue;
	$quantity_value= $quantity->item(0)->nodeValue;
	$image_value= $image->item(0)->nodeValue;
	$sale_value= $sale_price->item(0)->nodeValue;
	
				if($sale_value > 0){
			    echo "<strong>$prod_value</strong>";
			    echo "<br />";
			    echo "<br />";
			    echo $desc_value;
			    echo "<br />";
				echo "<br />"; 
			    echo "Quantity <strong>1</strong> at $" . "$price_value each. Total for item: <strong>$</strong>" . "<strong>$sale_value</strong>";
			    echo "<br />";
			    echo "<br />"; 
			    echo "<hr />";
			    $cost=$cost+$sale_value;
			    }
			    if($sale_value==0){
			    echo "<strong>$prod_value</strong>";
			    echo "<br />";
			    echo "<br />";
			    echo $desc_value;
			    echo "<br />";
				echo "<br />";
			    echo "Quantity <strong>1</strong> at $" . "$price_value each. Total for item: <strong>$</strong>" . "<strong>$price_value</strong>";
			    echo "<br />";
			    echo "<br />"; 
			    echo "<hr />";
			    $cost=$cost+$price_value;
			    }
			
			}
			
	
			echo "<br />";
		    echo "<strong>Total cost: $</strong>" . "<strong>$cost</strong>";
		    echo "<br />";
		    echo "<br />";
			
			echo "<form action='cart.php' method='POST' >
		      <input type='submit' name='empty' value='Empty Cart'>
		      </form>";
			  echo "<br /><br />";
			  echo "<hr />";

// if ($_SERVER['REQUEST_METHOD'] == "POST" && 
	// isset($_POST['Empty'])) {
	
	// echo "akajs";
	// $string .= "<div>".P2_Utils::project2_process_authorize()."</div>";
// } else if ($_SERVER['REQUEST_METHOD'] && 
		// isset($_GET['response_code']) ) {
	// $string .= "<div>".P2_Utils::project2_process_authorize_response()."</div>";
// }
				  
	
$fp_sequence = time(); // Any sequential number like an invoice number.
$url = "http://people.rit.edu/~axm1493/739/project2/cart.php";
$string= '';
$api_login_id = '64NE7EsfsK8r'; // your api login
$transaction_key = '3836963SppE3rYRN'; //Your transaction Key
$md5_setting = '64NE7EsfsK8r'; // Your MD5 Setting - use your api login id
        
$totalCost=$cost;
$string .= AuthorizeNetDPM::getCreditCardForm($totalCost, $fp_sequence, $url, $api_login_id, $transaction_key);


if ($_SERVER['REQUEST_METHOD'] == "POST" && 
	isset($_POST['Empty'])) {
	
	echo "akajs";
	$string .= "<div>".P2_Utils::project2_process_authorize()."</div>";
} else if ($_SERVER['REQUEST_METHOD'] && 
		isset($_GET['response_code']) ) {
	$string .= "<div>".P2_Utils::project2_process_authorize_response()."</div>";
}

    return $string;
} 

	}
//}
echo cart_items();


include "footer.php";
?>
      
    