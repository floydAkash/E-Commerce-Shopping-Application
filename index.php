<?php
			$title="Home";
			include "header.php";
?>

<?php
require_once 'LIB_project1.php';
$string ='';
$string .= show_sale_items();

echo $string;


?>
<?php
include "footer.php";
?>
		       
      