<?php
			$title="Home";
			include "header.php";
?>

<?php
require_once 'LIB_project1.php';

$perma_item= $_GET['item'];

$a=permalink($perma_item);
echo $a;
//echo $perma_item;
echo "<a href='index.php'>Go back to the listing</a>";
?>
<?php
include "footer.php";
?>
		       
      