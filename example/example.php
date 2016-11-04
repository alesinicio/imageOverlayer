<?php
require '../imageOverlayer.php';

use alesinicio\imageOverlayer;

//SETS THE CONFIGURATION FILE.
//SEE THE FILE FOR MORE INFORMATION.
$configurationFile = "overlay_config.php";

try {
	$imgOutput			= imageOverlayer::overlay($configurationFile);	//CREATES AN IMAGE WITH THE OVERLAY.
	$base64				= imageOverlayer::imgToBase64($imgOutput);		//BASE64 ENCODING SO WE AVOID SAVING FILES TO DISK.
	echo "<img src='$base64'>";
} catch (Exception $e) {
	echo $e->getMessage();
}