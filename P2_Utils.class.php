<?php

//class used to have functions which are utilised in the cart.php page for the buy button implementation.
class P2_Utils {

public function __construct()
{
}

public static function project2_process_authorize() {

$url = "http://people.rit.edu/~axm1493/739/project2/cart.php";
//$string= '';
$url = trim($url);
$api_login_id = '64NE7EsfsK8r'; // your api login
$transaction_key = '3836963SppE3rYRN'; //Your transaction Key
$md5_setting = '64NE7EsfsK8r'; // Your MD5 Setting - use your api login id
$response = new AuthorizeNetSIM($api_login_id, $md5_setting);

if ($response->isAuthorizeNet()) {
//echo "jdjdfn";
   if ($response->approved) {
	//echo "jfmdj";
   // Do your processing here.
      $redirect_url = $url . 
		'?response_code=1&transaction_id=' .
	 	$response->transaction_id; 
   } else {
   echo "kdksmd";
       // Redirect to error page.
       $redirect_url = $url . 
		'?response_code='.$response->response_code .
		 '&response_reason_text=' . 
		$response->response_reason_text;
    }
   	// Send the Javascript back to AuthorizeNet, which
	// will redirect user back to your site.
     return AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
} else {
    return "Error -- not AuthorizeNet. Check your MD5 Setting.";
}

}

public static function project2_process_authorize_response() {

     if ($_GET['response_code'] == 1) {
           //empty cart on success
	empty_cart();
	//project1_empty_cart();
           return "<br /><span class='good'>Thank you for your purchase! Transaction id: " . htmlentities($_GET['transaction_id'])."</span><br />";
     } else {
              return "<br /><span class='error'>Sorry, an error occurred: " . htmlentities($_GET['response_reason_text'])."</span></br >";
     }

}
}

?>