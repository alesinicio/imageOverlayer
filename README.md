# alesinicio/imageOverlayer
The alesinicio/imageOverlayer class allows the easy creation of multiple text overlays in images.

The usage is very simple. You will need:
- the class source (imageOverlayer.php);
- the image file which will be overlayed;
- a configuration file which tells how the overlaying will be done;
- the font files (TTF) you will use.

<h2>Basic usage</h2>
```
use alesinicio\imageOverlayer;

$configurationFile = "overlay_config.php";

$imgOutput			= imageOverlayer::overlay($configurationFile);	//CREATES AN IMAGE WITH THE OVERLAY.
$base64				= imageOverlayer::imgToBase64($imgOutput);		//BASE64 ENCODING SO WE AVOID SAVING FILES TO DISK.
echo "<img src='$base64'>";
```

<h2>Advantages</h2>
You can setup multiple overlays. Suppose you want to create both a "Happy Birthday" card and a "Happy Halloween" card. You will then get two images (the templates) and create two configuration files, which will tell the class where the overlays should be placed, and which data.

<h2>Flexible</h2>
The data you will use is configurable. Maybe it will come from a database, maybe from a form, maybe it is hard-coded... it is your choice!

<h2>Requirements</h2>
Your PHP must be compiled with FreeType support.