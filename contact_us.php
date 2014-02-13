<?php
			$title="Contact Page";
			include "header.php";
?>

<?php
function contact(){

echo "<form action='contact_us.php' method='POST'>
    
				    <table>
       
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
    
						       Reason to contact:
					       </td>
    
					       <td>
    
						       <textarea name='reason' rows='3' cols='60'></textarea>
    
					       </td>
    
				       </tr>
    
    
				       <tr>
    
					       <td>
    
						       E-Mail address:
					       </td>
    
					       <td>
    
						       <input type='text' name='e-mail' size='40' value='' />
    
					       </td>
    
				       </tr>
    
					    
    
			       </table>
    
			       <br />
    
			       <input type='reset' value='Reset Form' />
    
			       <input type='submit' name='submit_form' value='Submit Item' />
	    
		      </form>";
			  
			  
	if(isset($_POST['submit_form'])){
    
    function sanitizeString($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
    }
    
    $new_name= sanitizeString($_POST['name']);
    $new_reason=sanitizeString($_POST['reason']);
    $new_email=sanitizeString($_POST['e-mail']);
    
    
    if ( (@!(strlen($new_name) >0)) || (!(strlen($new_reason) >0)) || (!(strlen($new_email) >0))  ){
    echo "<br />";
    echo "<br />";
    echo "<h2 class='message'>Please make sure to enter all the fields in the form for a successful submission!</h2>";
    }
    
    else{
	// $array= array($new_name, $new_reason, $new_email);
    // $new_array= implode("|", $array);
    // $carriage_return_line_array= array("\n",$new_array);
    
    // $carriage_return_line= implode($carriage_return_line_array);
    
    // $file=("file_contact_form.txt");
    
    // file_put_contents($file, $carriage_return_line, FILE_APPEND | LOCK_EX);
	
	
	$file = 'contact.xml';
	$dom = new DOMDocument();
	$dom->formatOutput = true;
	$dom->load($file);
	$contacts = $dom->getElementsByTagName('contacts')->item(0);
	$contact = $dom->createElement('contact');
	$name = $dom->createElement('name', $new_name);
	//$contact->appendChild($name);
	$reason = $dom->createElement('reason', $new_reason);
	//$contact->appendChild($reason);
	$email = $dom->createElement('email', $new_email);
	//$contact->appendChild($email);
	$contact->appendChild($name);
	$contact->appendChild($reason);
	$contact->appendChild($email);
	$contacts->appendChild($contact);
	//echo $new_name;
	
	$dom->save('contact.xml');
    
    echo "<br />";
    echo "<br />";
    echo "<h3 class='message'>Contact form has been submitted to akash.u1@gmail.com. Meanwhile if you have any additional queries, please feel free to contact us at 1873-189-111. Thank you!</h3>";
    }
    
    }
}



echo contact();
?>


<?php
include "footer.php";
?>
		       
    