<?php

namespace alesinicio;

class imageOverlayer {
	private static $imageType;
	private static $quality;
	
	/**
	 * This method receives a string with the configuration filename as parameter and returns an image resource.
	 * @param string $configFilename
	 * @throws \Exception
	 * @return resource
	 */
	public static function overlay($configFilename) {
		if (!file_exists($configFilename)) throw new \Exception("Could not find configuration file.");
		
		require_once $configFilename;
		if (
			!isset($overlays)		||
			!isset($imgSrc)			||
			!isset($finalWidth)		||
			!isset($finalHeight)
		) throw new \Exception("Invalid configuration file.");
		
		self::getImageType($imgSrc);
		self::$quality = $quality;
		
		$output	= self::createOverlays($overlays, $imgSrc, $finalWidth, $finalHeight);

		return $output;
	}
	/**
	 * Converts an image resource into a base64 string.
	 * @param unknown $resImage
	 * @return string
	 */
	public static function imgToBase64($resImage) {
		ob_start();
		switch (self::$imageType) {
			case "PNG":
				$quality = 10-floor(self::$quality/10);
				if ($quality == 10) $quality = 9;
				imagepng($resImage,null,$quality);
				$output = "data:image/png;base64,".base64_encode(ob_get_contents());
				break;
			case "JPG":
				imagejpeg($resImage, null, self::$quality);
				$output = "data:image/jpeg;base64,".base64_encode(ob_get_contents());
				break;
		}
		ob_end_clean();
		return $output;
	}
	/**
	 * Wrapper method that receives an array with all the overlays that should be created and returns an image resource.
	 * @param unknown $overlays
	 * @param unknown $imgSrc
	 * @param unknown $finalWidth
	 * @param unknown $finalHeight
	 * @param number $quality
	 * @return resource
	 */
	private static function createOverlays($overlays, $imgSrc, $finalWidth, $finalHeight) {
		$image	= null;
	
		for($i=0; $i<count($overlays); $i++) {
			$overlay	= $overlays[$i];
			$imgSrc		= ($i == 0 ? $imgSrc : null);
			$image		= self::imageannotate(
					$overlay['text'],
					$overlay['font'],
					$overlay['fontSize'],
					$overlay['color'],
					$overlay['posX'],
					$overlay['posY'],
					$overlay['rotation'],
					$image,
					$imgSrc
					);
		}
	
		return self::resizeImage($image, $finalWidth, $finalHeight);
	}
	/**
	 * Sets the static property imageType, which determines if the template image is a JPG or PNG.
	 * @param string $imgSrc
	 * @throws \Exception
	 */
	private static function getImageType($imgSrc) {
		switch(exif_imagetype($imgSrc)) {
			case IMAGETYPE_JPEG:
				self::$imageType = "JPG";
				break;
			case IMAGETYPE_PNG:
				self::$imageType = "PNG";
				break;
			default:
				throw new \Exception("Only JPG/PNG should be used as template.");
		}
	}
	/**
	 * Effectively creates an overlay.
	 * @param string $text
	 * @param string $font
	 * @param int $fontSize
	 * @param string $arrFontColourRGB
	 * @param string $positionX
	 * @param string $positionY
	 * @param int $outputQuality
	 * @param int $rotationAngle
	 * @param image $image
	 * @param string $sourceFileName
	 * @throws \Exception
	 * @return resource
	 */
	private static function imageannotate($text, $font, $fontSize, $arrFontColourRGB, $positionX, $positionY, $rotationAngle=0, $image=null, $sourceFilename=null) {
		if ($image === null) {
			if (!file_exists($sourceFilename)) throw new \Exception("Template image not found.");
			$image = self::createImageResource($sourceFilename);
		}

		$colour = imagecolorallocate($image, $arrFontColourRGB['r'], $arrFontColourRGB['g'], $arrFontColourRGB['b']);

		imagealphablending($image, false);
		imagesavealpha($image, true);
		imagealphablending($image, true);

		if (imagettftext($image, $fontSize, $rotationAngle, $positionX, $positionY, $colour, $font, $text) === false) throw new \Exception("Error creating overlay.");
		return $image;
	}
	/**
	 * Creates an image resource from a file.
	 * @param string $sourceFilename
	 * @throws \Exception
	 * @return resource
	 */
	private static function createImageResource($sourceFilename) {
		switch (self::$imageType) {
			case "PNG":
				$image = imagecreatefrompng($sourceFilename);
				break;
			case "JPG":
				$image = imagecreatefromjpeg($sourceFilename);
				break;
		}
		if ($image === false) throw new \Exception("Error loading template image.");
		return $image;
	}
	/**
	 * Resizes an image resouce.
	 * @param resource $image
	 * @param int $dst_width
	 * @param int $dst_height
	 * @return resource
	 */
	private static function resizeImage($image, $dst_width, $dst_height) {
		$width 			= imagesx($image);
		$height 		= imagesy($image);
		$newImg 		= imagecreatetruecolor($dst_width, $dst_height);

		imagealphablending($newImg, false);
		imagesavealpha($newImg, true);

		$transparent 	= imagecolorallocatealpha($newImg, 255, 255, 255, 127);

		imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
		imagecopyresampled($newImg, $image, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);

		return $newImg;
	}
}