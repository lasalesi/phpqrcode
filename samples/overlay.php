<?php
	// make sure nothing is before the php tag
	
    // create QR code first through the API
    $content = "Test";
    $host = "www.example.com";
    $src = 'https://' . $host . '/phpqrcode/api/qrcode.php?content=' . $content;
    $qrcode = imagecreatefromstring(file_get_contents($src));
    
    // load the stamp
    $stamp = imagecreatefrompng("libracore_logo_small.png");
    
    // define location and dimension of the stamp
    $width = imagesx($stamp);
    $height = imagesy($stamp);
    $margin_right = 10;
    $margin_bottom = 10;
    
    // merge stamp onto QR code
	$pos_x = (imagesx($qrcode) / 2) - ($width / 2);
	$pos_y = (imagesy($qrcode) / 2) - ($height / 2);
	imagecopymerge($qrcode, $stamp, $pos_x, $pos_y, 0, 0,
		imagesx($stamp), imagesy($stamp), 100);
			
	// return image to browser
	header('Content-Type: image/png');
	imagepng($qrcode);
	
	// free memory
	imagedestroy($qrcode);
	imagedestroy($stamp);
