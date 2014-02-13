<?php
ini_set('upload_max_filesize', '700M');
ini_set('post_max_size', '16M');
//echo session_id();
$title="Admin Page";
include "header.php";

require_once 'RSSFeed.class.php';

/* 
Function to make sure that we can edit an item and also validates for input.
 */

function show_form(){
	echo "<h2 class='admin'>ADMIN PAGE</h2>";
	echo "<br />";
   	$file = file_get_contents('catalog.xml');
	$dom = new DomDocument();
	
	// load the XML file
	$dom->loadXML($file);
	
	$all_products= $dom->getElementsByTagName('product');
	$val=0;							
    $string= '';
	
	echo "<div class='edit'>";
	echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<div>";
    echo "<form action='admin.php' method='post'>";
    echo "Choose an item to Edit: <select name='pickOne'>";
    
    
foreach($all_products as $product){
	
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
	echo "<option value='$val' >$product_name</option>";
	$val++;
	}
    
    echo "</select>
		  <input type='submit' name='edit' value='Edit' /><br/><br/>";
    echo "</form></div></td></tr></table><br />";
	echo "</div>";
    
    //If the edit button is clicked then display only those values for the selected element and edit and write back to catalog.xml
     if( isset($_POST['edit']) ){
    //$val=0;
    $name = @$_POST['pickOne'];
    $item=$name;
    //echo $item;
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
	//var_dump($line);
    echo "<form action='admin.php' method='post' enctype='multipart/form-data'>";
    
	    
					    echo "<input type='hidden' name='oldImage' value='$image_value' />";
    
					    
					echo "<div class='edit'>";
				    echo "<table>
    
					    <tr><td colspan='2' class='areaHeading'><strong>Edit Item:</strong></td></tr>
       
				       <tr>
    
					       <td>
    
						       Name:
					       </td>
    
					       <td>
    
						       <input type='text' name='name' size='40' value='$product_name' />
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       Description:
					       </td>
    
					       <td>
    
						       <textarea name='description' rows='3' cols='60'>$desc_value</textarea>
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       Price:
					       </td>
    
					       <td>
    
						       <input type='text' name='price' size='40' value='$price_value' />
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       Quantity on hand:
					       </td>
    
					       <td>
    
						       <input type='text' name='quantity' size='40' value='$quantity_value' />
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       Sale Price:
					       </td>
    
					       <td>
    
						       <input type='text' name='salesPrice' size='40' value='$sale_value' />
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       New Image:
					       </td>
    
					       <td>
    
						       <input type='file' name='image' />
    
					       </td>
    
				       </tr>
    
					    <tr>
    
					       <td>
    
								    <strong>Your Password: </strong>
						    </td>
    
						    <td>
    
							    <input type='password' name='password' size='15' />
    
						    </td>
    
			       </table>
    
			       <br />
    
			       <input type='reset' value='Reset Form' />
					    <input type='hidden' name='item' value='$name' />
	    
			       <input type='submit' name='edit_item' value='Submit Item' />";
	    
	    echo "</form>";
		echo "<br /><br />";
		echo "</div>";
    }
    
    if( isset($_POST['edit_item'])){
    
    $item = $_POST['item'];
    
    if ( (@!(strlen($_POST['name']) >0)) || (!(strlen($_POST['description']) >0)) || (!(strlen($_POST['price']) >0)) || (!(strlen($_POST['quantity']) >0)) || (!(strlen($_POST['salesPrice']) >0)) || (!(strlen($_POST['password']) >0))  ){
    
    //$image_name= $_POST['image'];
    echo "<h2 class='message'>Set values</h2>";
    }
    else{
    
    define("PASSSWD", "cellZone");
    //echo $_POST['item'];
    
	//function to sanitize input fields.
	function sanitizeString($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
    }
    if ($_POST['password']==PASSSWD){
    
    //$item=$_POST['item'];
    $new_name= sanitizeString($_POST['name']);
    $new_description=sanitizeString($_POST['description']);
    $new_price=sanitizeString($_POST['price']);
    $new_quantity=sanitizeString($_POST['quantity']);
    $new_salesPrice=sanitizeString($_POST['salesPrice']);
    $new_password=sanitizeString($_POST['password']);
	//$new_image = $_FILES['image']['name'];
    
	//if the same name of the image seems to be existing, then I don't allow the user to edit item to the catalog.xml
	if (file_exists("images/" . $_FILES["image"]["name"]))
      {
      echo $_FILES["image"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $_FILES["image"]["name"]);
	  chmod("images/". $_FILES["image"]["name"], 0644);		//set permission of the image to 644.
	  }
	if ($_FILES["image"]["error"] > 0)
	{
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
	}
	
	$new_image = $_FILES["image"]["name"];

	//checks for valid input. Integer fields expect numeric value. If not, then I don't allow user to edit item into catalog.xml
	if(!is_numeric($new_price) || !is_numeric($new_quantity) || !is_numeric($new_salesPrice) )
	{
	echo "<br /><br />";
	echo "<h2 class='message'>Enter valid input!!</h2>";
	}
else{
	$file = @file_get_contents('catalog.xml'); 
	$dom = new DomDocument();
	
	// load the XML file
	$dom->loadXML($file);
	
	$product = $dom->getElementsByTagName('product')->item($item);
	//$product->item(0)->
	$product->getElementsByTagName('description')->item(0)->nodeValue = $new_description;
	$product->getElementsByTagName('price')->item(0)->nodeValue = $new_price;
	$product->getElementsByTagName('quantity')->item(0)->nodeValue = $new_quantity;
	$product->getElementsByTagName('image_name')->item(0)->nodeValue = $new_image;
	$product->getElementsByTagName('sale_price')->item(0)->nodeValue = $new_salesPrice;
	
	$dom->save('catalog.xml');
	}
	$object = new RSSFeed('project2.rss');
	$object->replaceRSS('catalog.xml');
	
	
	
    }
    else{
    echo "<h2 class='message'>Bad password</h2>";
    }
    }
    
    }
	    
	    
   //Just a static form according the way it looked in the professor's implementation. 
    echo "<form action='admin.php' method='post' enctype='multipart/form-data'>
  		
				    <table>
    
					    <tr><td colspan='2' class='areaHeading'><strong>Add Item:</strong></td></tr>
       
				       <tr>
    
					       <td>
    
						       Name:
					       </td>
    
					       <td>
    
						       <input type='text' name='name' size='40' value='' />
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       Description:
					       </td>
    
					       <td>
    
						       <textarea name='description' rows='3' cols='60'></textarea>
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       Price:
					       </td>
    
					       <td>
    
						       <input type='text' name='price' size='40' value='' />
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       Quantity on hand:
					       </td>
    
					       <td>
    
						       <input type='text' name='quantity' size='40' value='' />
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       Sale Price:
					       </td>
    
					       <td>
    
						       <input type='text' name='salesPrice' size='40' value='' />
    
					       </td>
    
				       </tr>
    
				       <tr>
    
					       <td>
    
						       New Image:
					       </td>
    
					       <td>
    
						       <input type='file' name='image' />
    
					       </td>
    
				       </tr>
    
					    <tr>
    
					       <td>
    
								    <strong>Your Password: </strong>
						    </td>
    
						    <td>
    
							    <input type='password' name='password' size='15' />
    
						    </td>
    
			       </table>
    
			       <br />
    
			       <input type='reset' value='Reset Form' />
    
			       <input type='submit' name='submit_item' value='Submit Item' />
	    
		      </form>";
		      
    return $string;
    }

	/* 
	Function to add new itemss to the catalog.xml and checks for valid input to be given as input in the respective input fields in hte form.
	*/

	function add_items(){
	//require_once 'RSSFeed.class.php';
	$string='';
    if( isset($_POST['submit_item'])){
    
    if ( (@!(strlen($_POST['name']) >0)) || (!(strlen($_POST['description']) >0)) || (!(strlen($_POST['price']) >0)) || (!(strlen($_POST['quantity']) >0)) || (!(strlen($_POST['salesPrice']) >0)) || (!(strlen($_POST['password']) >0))  ){
    
    //$image_name= $_POST['image'];
    echo "<br />";
    echo "<h2 class='message'>Set values</h2>";
    }
    else{
    define("PASSSWD", "cellZone");
    
    function sanitizeString($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
    }
    if ($_POST['password']==PASSSWD){
    
    
    $new_name= sanitizeString($_POST['name']);
    $new_description=sanitizeString($_POST['description']);
    $new_price=sanitizeString($_POST['price']);
    $new_quantity=sanitizeString($_POST['quantity']);
    $new_salesPrice=sanitizeString($_POST['salesPrice']);
    $new_password=sanitizeString($_POST['password']);
  
  
	
	if (file_exists("images/" . $_FILES["image"]["name"]))
      {
      echo $_FILES["image"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $_FILES["image"]["name"]);
	  chmod("images/". $_FILES["image"]["name"], 0644);
	  }
	if ($_FILES["image"]["error"] > 0)
	{
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
	}
	
	$new_image = $_FILES["image"]["name"];
	if(!is_numeric($new_price) || !is_numeric($new_quantity) || !is_numeric($new_salesPrice) )
	{
	echo "<br /><br />";
	echo "<h2 class='message'>Please enter valid input!!</h2>";
	}
	else{
	
	$file = file_get_contents('catalog.xml'); 
	$dom = new DomDocument();
	
	// load the XML file
	$dom->loadXML($file);
	$product = $dom->getElementsByTagName('products');
	
	$new_product = $dom->createElement('product');
	$new_product->setAttribute('name', $new_name);
	$product->item(0)->appendChild($new_product);
	$new_desc = $dom->createElement('description',$new_description);
	$new_product->appendChild($new_desc);
	$new_item_price = $dom->createElement('price', $new_price);
	$new_product->appendChild($new_item_price);
	$new_item_quantity = $dom->createElement('quantity', $new_quantity);
	$new_product->appendChild($new_item_quantity);
	$new_item_image = $dom->createElement('image_name', $new_image);
	$new_product->appendChild($new_item_image);
	$new_item_saleprice = $dom->createElement('sale_price', $new_salesPrice);
	$new_product->appendChild($new_item_saleprice);
	
	
	$dom->save('catalog.xml');
	}
	$object = new RSSFeed("project2.rss");
	$object->replaceRSS("catalog.xml");
	}
    else{
    echo "<h2 class='message'>Bad password</h2>";
    }
    }
    
    }
    return $string;
	}

echo show_form();
echo add_items();


/* 
This function displays the names of students from my class. I can select a student and click on the save button and the RSS feed of that said student appears in the services.php page.
 */
function show_students(){

$file = @file_get_contents('class.xml');
$dom = new DomDocument();
$val=0;
	// load the XML file
$dom->loadXML($file);

$all_students = $dom->getElementsByTagName('student');
//echo "<input type='hidden' name='someValueFromPageOne' value='blah;>";
echo "<form action = 'admin.php' method='post' enctype='multipart/form-data'>";
echo "<input type='hidden' name='check' value='1'>";

echo "<br /><br />";
echo "<strong>Select upto 10 student stores to follow:</strong> ";
echo "<br /><br />";
echo "<select name='student[]' multiple='multiple' >";
//echo "<input type='hidden' name='studentvalue' value='$val' />";
//echo "<select name='student[]' multiple='multiple' >";

foreach($all_students as $student){

$selection = $student->getAttribute('selected');
$firstName = $student->getElementsByTagName('first')->item(0)->nodeValue;
$lastName = $student->getElementsByTagName('last')->item(0)->nodeValue;

echo "<option value='$val' >$firstName $lastName</option>";

//echo "<form action = 'admin.php' method='post' enctype='multipart/form-data'>";

//echo "<input type='submit' name='subscribe' value='subscribe' />";
//echo "<input type='hidden' name='studentvalue' value='$val' />"; 
echo "\n";
//echo "$firstName" . " $lastName";
//echo "<br />";
//echo "</form>";
$val++;

}
    
echo "</select>
<input type='submit' name='save' value='save' />";
echo "</form>";

//if the save button is clicked, then the student's RSS feed is displayed in the services page.
if( isset($_POST['save']) ){
//bool selected = true;

$check = $_POST['check'];

$val = $_POST['student'];
if($check && count($val)>0){
$mysel = $_POST['student'];
//echo "You chose<br />";
foreach($val as $option){
//echo $option;
}
}
echo "<br />";
$student = $dom->getElementsByTagName('student')->item($option);


$first = $student->getElementsByTagName('first')->item(0)->nodeValue;
$last = $student->getElementsByTagName('last')->item(0)->nodeValue;

// echo "<p>$first $last</p>";
echo "<h2 class='message'>You are now subscribed to $first $last 's  RSS feeds";

$file = file_get_contents('class.xml'); 
$dom2 = new DomDocument();
	
	// load the XML file
$dom2->loadXML($file);

	$student = $dom2->getElementsByTagName('student')->item($option);

	$student->setAttribute('selected', 'yes');
	
$dom2->save('class.xml');
	
// echo "<div id='right'>";
// echo $first . $last;
// echo"</div>";


}
}



echo show_students();


include "footer.php";
?>
		       
    