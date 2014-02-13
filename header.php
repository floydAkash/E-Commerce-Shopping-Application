<?php
echo '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=320,user-scalable=false" />
<link rel="shortcut icon" href="favicon.ico" />';

if( stripos($_SERVER['HTTP_USER_AGENT'],'Android')||stripos($_SERVER['HTTP_USER_AGENT'],'webOS')||stripos($_SERVER['HTTP_USER_AGENT'],'iPhone')||stripos($_SERVER['HTTP_USER_AGENT'],'iPod'))
{
echo '<link rel="stylesheet" type="text/css" href="mobile.css"/ media="handheld">';
}

echo '<link rel="stylesheet" href="stylesheet.css" type="text/css" media="Screen"/>';

?>

<title>CellZone | <?php echo $title; ?> </title>


</head>
<body>

<div class="container">


<div class="banner">
<img src="banner.jpg" style="width: 1000px"  alt="logo" />
</div>

<?php
//session_start();
$path = $_SERVER['PHP_SELF'];
$page = basename($path);
$page = basename($path, '.php');
?>

<div id="nav">

<ul>

<li><a<? if($page == 'index'): ?> class="active"<? endif ?> href="index.php">Home</a></li>
		<li><a<? if($page == 'cart'): ?> class="active" <? endif ?> href="cart.php">Cart</a></li>
		<li><a<? if($page == 'admin'): ?> class="active" <? endif ?> href="admin.php">Admin Page</a></li>
		<li><a<? if($page == 'services'): ?> class="active"<? endif ?> href="services.php">Services</a></li>
		<li><a<? if($page == 'project2'): ?> class="active"<? endif ?> href="project2.rss">Project2 RSS</a></li>
		<li><a<? if($page == 'contact_us'): ?> class="active"<? endif ?> href="contact_us.php">Contact Us</a></li>
</ul>

</div> 

<div class="content">
