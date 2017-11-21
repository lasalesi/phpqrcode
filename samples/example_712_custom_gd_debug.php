 <?php

    include('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // custom colorfull debug renderer

    $codeContents = 'Let see what the code structure looks like with a little bit bigger code';
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    $fileName = '712_test_custom.png';
    $outerFrame = 4;
    $pixelPerPoint = 6;
    
    // generating Raw frame
    $frame = QRcode::raw($codeContents, false, QR_ECLEVEL_H);
    
    // rendering frame with GD2 (that should be function by real impl.!!!)
    $h = count($frame);
    $w = strlen($frame[0]);
    
    $imgW = $w + 2*$outerFrame;
    $imgH = $h + 2*$outerFrame;
    
    $base_image = imagecreate($imgW, $imgH);
    
    $colorSpec = array(
        "\x02" => array(240,240,240), // 0     
        "\x03" => array(0,0,0),       // 1
        "\xc0" => array(0,255,0),     //marker 0   
        "\xc1" => array(0,128,0),     //marker 1
        "\xa0" => array(255,255,0),   //submarker 0
        "\xa1" => array(128,128,0),   //submarker 1
        "\x84" => array(0,0,255),     //format 0
        "\x85" => array(0,0,180),     //format 1
        "\x81" => array(255,0,255),   //special bit
        "\x90" => array(0,255,255),   //clock 0
        "\x91" => array(0,128,128),   //clock 1
        "\x88" => array(255,0,0),     //version 0 
        "\x89" => array(180,0,0)      //version 1
    );
    
    $colorLegend = array(
        "\x02" => "data bit 0  ",
        "\x03" => "data bit 1  ",
        "\xc0" => "marker 0    ",
        "\xc1" => "marker 1    ",
        "\xa0" => "submarker 0 ",
        "\xa1" => "submarker 1 ",
        "\x84" => "format 0    ",
        "\x85" => "format 1    ",
        "\x81" => "special bit ",
        "\x90" => "clock 0     ",
        "\x91" => "clock 1     ",
        "\x88" => "version 0   ",
        "\x89" => "version 1   "
    );
    
    $colBg = imagecolorallocate($base_image,255,255,255); // BG, white 
    
    foreach($colorSpec as $colorKey=>$colorDef) {
        $colorBase[$colorKey] = imagecolorallocate(
            $base_image, 
            $colorDef[0], 
            $colorDef[1], 
            $colorDef[2]
        );
    }
                                
    imagefill($base_image, 0, 0, $colBg);

    for($y=0; $y<$h; $y++) {
        for($x=0; $x<$w; $x++) {
            imagesetpixel(
                $base_image,
                $x+$outerFrame,
                $y+$outerFrame,
                $colorBase[$frame[$y][$x]]
            ); 
        }
    }
    
    // creating zoomed version
    $target_image = imagecreate(
        $imgW * $pixelPerPoint + 150, 
        max($imgH * $pixelPerPoint, 250)
    );
    
    $coltBg   = imagecolorallocate($target_image, 255, 255, 255); // BG, white 
    $coltTxt  = imagecolorallocate($target_image, 0, 0, 0);       // TXT, black 
    
    foreach($colorSpec as $colorKey=>$colorDef) {
        $colorTarget[$colorKey] = imagecolorallocate(
            $target_image, 
            $colorDef[0], 
            $colorDef[1], 
            $colorDef[2]
        );
    } 
    
    imagecopyresized(
        $target_image, 
        $base_image, 
        0, 0, 0, 0, 
        $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH
    );
    imagedestroy($base_image);
    
    $pos = 0;
    foreach($colorLegend as $colKey=>$colName) {
        $px = $imgW * $pixelPerPoint + 25;
        $py = $outerFrame * $pixelPerPoint + $pos * 16;
        imagefilledrectangle(
            $target_image, 
            $px-20, $py+3, 
            $px-10, $py+13, 
            $colorTarget[$colKey]
        );
        imagerectangle($target_image, $px-20, $py+3, $px-10, $py+13, $coltTxt);
        imagestring($target_image, 2, $px, $py+1, $colName, $coltTxt);
        $pos++;
    }
    
    imagepng($target_image, $tempDir.$fileName);
    imagedestroy($target_image);

    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.$fileName.'" />'; 
