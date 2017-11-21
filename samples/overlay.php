 <?php
    // load the QR code library
    require_once('../lib/qrlib.php');
    
    // create QR code first
    $content = "Test content";
    $qrcode = imagecreatefrompng("../api/qrcode.php?content=' . $content . '"); 
    
    // load the stamp
    $stamp = imagecreatefrompng("libracore_logo_small.png");
    
    // define location and dimension of the stamp
    $width = imagesx($stamp);
    $height = imagesy($stamp);
    $margin_right = 10;
    $margin_bottom = 10;
    
    // merge stamp onto QR code
    imagecopymerge($qrcode, $stamp, imagesx($qrcode) - $width - $margin_right,
		imagesy($qrcode) - $height - $margin_bottom, 0, 0,
		imagesx($stamp), imagesy($stamp), 0);
		
	// return image to browser
	header('Content-Type: image/png');
	imagepng($qrcode);
	
	//fpassthru($qrcode);
	
	// free memory
	imagedestroy($qrcode);
	imagedestroy($stamp);
