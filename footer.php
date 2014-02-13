<?php

//session_start();
echo "</div>";


echo "</div>";

echo "<div id='user_info'>";

echo "<div id='footer_message'>";

echo "User's browser details: ". $_SERVER['HTTP_USER_AGENT'] . "\n\n";

echo "<br />";

echo "<br />";

echo "Your IP address is: " . $_SERVER['REMOTE_ADDR'];

echo "<br />";

echo "<br />";

echo "You clicked a link on http://" . $_SERVER['SERVER_NAME']. $_SERVER['REQUEST_URI'];

echo "<br />";

echo "<br />";

echo "<script>document.write('Your screen resolution is: ' + screen.width + ' x ' + screen.height);</script>";

echo "</div>";

echo "</div>";


echo "</body>";


echo "</html>";

?>