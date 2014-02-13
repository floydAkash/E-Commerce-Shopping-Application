<?php
//header('Content-Type: application/xml');

class RSSFeed {
	
	public $rssFile;
	
	function __construct($filename) {
		$this->rssFile = $filename;
	}
	
	//This function would be used AFTER updating the catalog file in your admin.php script
public function replaceRSS($catalogFile) {
		$dom1 = new DomDocument();
		$dom1->formatOutput = true;
		

		//create root element: rss with version attribute and append directly to the DOM: $dom->appendChild("root element variable name"); 
         $theRootElement = $dom1->createElement('rss');
         $theVersionAtrribute = $dom1->createAttribute('version');
         $theVersionAtrribute->value = '2.0';
		
         $theRootElement->appendChild($theVersionAtrribute);
		 //$theRootElement->appendChild($theEncodingAttribute);
		 $dom1->appendChild($theRootElement);

        //create channel element with children: title, language, link and description and append it 
        //the root element (use the variable holding the root element from above)
		$theChannelItem = $dom1->createElement('channel');
		$theCtitleElement = $dom1->createElement('title');
		$theClinkElement = $dom1->createElement('link');
		$theClanElement = $dom1->createElement('language');
		$theCdescElement = $dom1->createElement('description');
		
		$theCtitleText = $dom1->createTextNode('Project 2 RSS Feed');
		$theClinkText = $dom1->createTextNode('http://people.rit.edu/~axm1493/739/project2/project.rss');
		$theClanText = $dom1->createTextNode('en-us');
		$theCdescText = $dom1->createTextNode('Project 2 RSS Feed');
		
		$theCtitleElement->appendChild($theCtitleText);
		$theClinkElement->appendChild($theClinkText);
		$theClanElement->appendChild($theClanText);
		$theCdescElement->appendChild($theCdescText);
		
		$theChannelItem->appendChild($theCtitleElement);
		$theChannelItem->appendChild($theClanElement);
		$theChannelItem->appendChild($theClinkElement);
		$theChannelItem->appendChild($theCdescElement);
		
		$dom = new DomDocument();
		// load the XML file
		$dom->load($catalogFile);
		//$dom->load($data);
		$all_products= $dom->getElementsByTagName('product');
		$val=0;
		$cDate = date('r');
		foreach($all_products as $product)
	    {
		
	
		$description = $product->getElementsByTagName('description');
		$price_item = $product->getElementsByTagName('price');
		$quantity = $product->getElementsByTagName('quantity');
		$image = $product->getElementsByTagName('image_name');
		$sale_price = $product->getElementsByTagName('sale_price');
		$desc= $description->item(0)->nodeValue;
		$price= $price_item->item(0)->nodeValue;
		$quan= $quantity->item(0)->nodeValue;
		$img= $image->item(0)->nodeValue;
		$salp= $sale_price->item(0)->nodeValue;
	
	    $name = $product->getAttribute('name');
		if($salp > 0)
		{
		
		$theItemElement = $dom->createElement('item');
		
		$theTitleElement = $dom->createElement('title');
		$theTitleText = $dom->createTextNode($name);
	
		$theTitleElement->appendChild($theTitleText);
		
		$theDescElement = $dom->createElement('description');
		$theDescText = $dom->createCDATASection($desc);
		$theDescElement->appendChild($theDescText);
		
		
		$theguidElement = $dom->createElement('guid');
		$theguidText = $dom->createTextNode("http://people.rit.edu/~axm1493/739/project2/permalink.php?item=$val ");
		$theguidElement->appendChild($theguidText);
		
		$theLinkElement = $dom->createElement('link');
		$theLinkText = $dom->createTextNode("http://people.rit.edu/~axm1493/739/project2/permalink.php?item=$val ");
		$theLinkElement->appendChild($theLinkText);
		
		
		$theLanElement = $dom->createElement('language');
		$theLanText = $dom->createTextNode('en-us');
		$theLanElement->appendChild($theLanText);
		
		$theDateElement = $dom->createElement('pubDate');
		$theDateText = $dom->createTextNode($cDate);
		$theDateElement->appendChild($theDateText);
		
		$thePriceElement = $dom->createElement('price');
		$thePriceText = $dom->createTextNode($price);
		$thePriceElement->appendChild($thePriceText);
		
		$theSalepElement = $dom->createElement('salePrice');
		$theSalePText = $dom->createTextNode($salp);
		$theSalepElement->appendChild($theSalePText);
		
		$theItemElement->appendChild($theTitleElement);
	    $theItemElement->appendChild($theLinkElement);
		$theItemElement->appendChild($theguidElement);
		$theItemElement->appendChild($theDateElement);
		$theItemElement->appendChild($theDescElement);
		$theItemElement->appendChild($thePriceElement);
		$theItemElement->appendChild($theSalepElement);
		
		$theItemElement = $dom1->importNode($theItemElement, true);
		$theChannelItem->appendChild($theItemElement);
		
		}
		$val++;
		}
		$theRootElement->appendChild($theChannelItem);
		//$dom1->documentElement->appendChild($theRootElement);
		$dom1->save($this->rssFile);
	}
}
		
?>	
		
