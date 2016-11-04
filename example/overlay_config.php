<?php
//SETS THE TEMPLATE IMAGE TO BE OVERLAYED.
//USE JPEG OR PNG IMAGES.
$imgSrc			= "images_src/template.jpg";

//SETS THE FINAL WIDTH/HEIGHT OF THE OUTPUT IMAGE IN PIXELS.
//GENERALLY YOU WOULD USE THE SAME SIZES AS THE TEMPLATE,
//BUT YOU MAY WANT TO RESIZE ON THE FLY.
$finalWidth		= 600;
$finalHeight	= 400;

//SETS THE QUALITY OF THE IMAGE OUTPUT (0 TO 100).
$quality = 100;

//FROM HERE ON, YOU WOULD CONFIGURE THE OVERLAYS.
//MAYBE THIS DATA WOULD COME FROM A DATABASE, OR EVEN FROM
//A FORM THE USER SUBMITS ON YOUR WEBPAGE.
$name			= "Your name";		// $databaseQuery['username']	??
$phone			= "Your phone";		// $_POST['phone']				??

//THE OVERLAYS CONFIGURATION ITSELF.
$overlays = array(
		array(
				"text"=>$name,							//TEXT TO OVERLAY
				"font"=>"fonts/arial.ttf",				//FONT TO BE USED (BE SURE TO INCLUDE THE TTF FILE)
				"fontSize"=>26,							//FONT SIZE
				"color"=>array("r"=>0,"g"=>0,"b"=>0),	//RGB COLOR OF THE TEXT
				"posX"=>260,							//HORIZONTAL POSITION OF THE OVERLAY
				"posY"=>210,							//VERTICAL POSITION OF THE OVERLAY
				"rotation"=>2							//ROTATION OF THE OVERLAY, IN DEGREES
		),
		array(
				"text"=>$phone,
				"font"=>"fonts/arial.ttf",
				"fontSize"=>22,
				"color"=>array("r"=>255,"g"=>0,"b"=>0),
				"posX"=>260,
				"posY"=>260,
				"rotation"=>2
		)
);