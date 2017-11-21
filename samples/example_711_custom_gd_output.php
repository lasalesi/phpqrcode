 <?php

    include('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // custom code rendering with GD2
    
    // WARNING!!! this is 'bad' example:
    // - JPEG is bad choice for QR-Codes (loosy, artifacts...)
    // - blue is bad choise for FG color (should make hi contrast with BG color)

    $codeContents = '12345';
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    $fileName = '711_test_custom.jpg';
    $outerFrame = 4;
    $pixelPerPoint = 5;
    $jpegQuality = 95;
    
    // generating frame
    $frame = QRcode::text($codeContents, false, QR_ECLEVEL_M);
    
    // rendering frame with GD2 (that should be function by real impl.!!!)
    $h = count($frame);
    $w = strlen($frame[0]);
    
    $imgW = $w + 2*$outerFrame;
    $imgH = $h + 2*$outerFrame;
    
    $base_image = imagecreate($imgW, $imgH);
    
    $col[0] = imagecolorallocate($base_image,255,255,255); // BG, white 
    $col[1] = imagecolorallocate($base_image,0,0,255);     // FG, blue

    imagefill($base_image, 0, 0, $col[0]);

    for($y=0; $y<$h; $y++) {
        for($x=0; $x<$w; $x++) {
            if ($frame[$y][$x] == '1') {
                imagesetpixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]); 
            }
        }
    }
    
    // saving to file
    $target_image = imagecreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
    imagecopyresized(
        $target_image, 
        $base_image, 
        0, 0, 0, 0, 
        $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH
    );
    imagedestroy($base_image);
    imagejpeg($target_image, $tempDir.$fileName, $jpegQuality);
    imagedestroy($target_image);

    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.$fileName.'" />'; 
