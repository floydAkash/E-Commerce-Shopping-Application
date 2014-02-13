<?php

error_reporting(E_WARNING);
$title="Services";
include "header.php";


//code from the one posted on mycourses. This function returns status codes of URLs.
function getStatusCode($url) {
     			$ch = curl_init($url); 
				curl_setopt($ch, CURLOPT_NOBODY, true); 
				curl_exec($ch); 
				$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
				curl_close($ch); 
				//$status_code contains the HTTP status: 200, 404, etc. 
			return $status_code;		
		} //getStatusCode     //use curl to get status code 404 to make sure file exists

		
//Extracted the XML content from the rss_class_xml and copied into a static xml file.
$file = @file_get_contents('class.xml');
$dom = new DomDocument();
$val=0;
	// load the XML file
$dom->loadXML($file);

//returns all student tags
$all_students = $dom->getElementsByTagName('student');

//cycle through each student tag get the child element tags' nodeValues.
foreach($all_students as $student){
$selection = $student->getAttribute('selected');
$firstName = $student->getElementsByTagName('first')->item(0)->nodeValue;
$lastName = $student->getElementsByTagName('last')->item(0)->nodeValue;
$url = $student->getElementsByTagName('url')->item(0)->nodeValue;
//without trimming the URL, I am not able to display the RSS feeds of the students.
$url = trim($url);


$dom1 = new DomDocument();
$dom1->load($url);

//When the attribute of student tag is yes and if the status code is not 404, then I display the feeds of the students. 
if($selection =='yes' && getStatusCode($url)!='404'){
echo "<div id='.sel'>";
echo "<h2 class='message'>$firstName" . " $lastName's Sale Items</h2>";
echo "<br />";
echo "<br />";
$all_items= $dom1->getElementsByTagName('item');
foreach($all_items as $item){
$item_name = $item->getElementsByTagName('title')->item(0)->nodeValue;
$description_item = $item->getElementsByTagName('description')->item(0)->nodeValue;
$date_item = $item->getElementsByTagName('pubDate')->item(0)->nodeValue;
$price_item = $item->getElementsByTagName('price')->item(0)->nodeValue;
$sale_item = $item->getElementsByTagName('salePrice')->item(0)->nodeValue;
$link_item = $item->getElementsByTagName('link')->item(0)->nodeValue;

//permalink to the students' items.
echo "<a href='$link_item'>$item_name</a>";
echo "<br />";
echo "<br />";
echo $date_item;
echo "<br />";
echo "<br />";
echo "<strong>Description: </strong>" .$description_item;
echo "<br />";
echo "<br />";
echo "<strong>Actual Price: $</strong>" .$price_item;
echo "<br />";
echo "<br />";
echo "<strong>Sale Price: $</strong>" .$sale_item;
echo "<br />";
echo "<br />";
echo "<hr />";
echo "<br />";
}

echo "</div>";
}

//But sometimes, attribute can be selected as yes and students' feeds don't exist and are not valid. In that case, I print those students' feeds with appropriate error message.
else if($selection =='yes' && getStatusCode($url)=='404'){
echo "<h2 class='message'>$firstName" . " $lastName's Sale Items</h2>";
echo "<br />";
echo "<br />";
echo "<h1>This feed is not working</h1>";
echo "<br />";
echo "<br />";
echo "<hr />";
echo "<br />";
}


}


include "footer.php";
?>