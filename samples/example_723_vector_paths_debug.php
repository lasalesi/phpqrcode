 <?php

    include('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // debuging vector subshapes
    // visible object categories:
    // pixels (black), rectangles (gray), LShapes (blue), markers(green)
    // and complicated paths (outlined color)
    
    $codeContents   = 'Let see what the code structure looks like with a little bit bigger code';
    $eccLevel       = QR_ECLEVEL_H;
    $pixelPerPoint  = 12;
    $marginSize     = 2;
    $tempDir        = EXAMPLE_TMP_SERVERPATH;
    $fileName       = '723_path_debug.png';
    
    // because PHP does not have macros or closures
    function mapCoord($pos) {
        return ($pos+2)*12;
    }
    
    // from: http://stackoverflow.com/questions/3597417/php-hsv-to-rgb-formula-comprehension by: Artefacto
    function HSVtoRGB(array $hsv) {
        list($H,$S,$V) = $hsv;
        $H *= 6;
        $I = floor($H);
        $F = $H - $I;
        $M = $V * (1 - $S);
        $N = $V * (1 - $S * $F);
        $K = $V * (1 - $S * (1 - $F));
        switch ($I) {
            case 0:
                list($R,$G,$B) = array($V,$K,$M);
                break;
            case 1:
                list($R,$G,$B) = array($N,$V,$M);
                break;
            case 2:
                list($R,$G,$B) = array($M,$V,$K);
                break;
            case 3:
                list($R,$G,$B) = array($M,$N,$V);
                break;
            case 4:
                list($R,$G,$B) = array($K,$M,$V);
                break;
            case 5:
            case 6: //for when $H=1 is given
                list($R,$G,$B) = array($V,$M,$N);
                break;
        }
        return array($R, $G, $B);
    }
    
    // QR code lib area finding
    $enc = QRencode::factory($eccLevel, 1, 0);
    $tab_src = $enc->encode($codeContents, false);
    $area = new QRarea($tab_src);
    $area->detectGroups();
    $area->detectAreas();
  
    // GD2 magical rendering
    $imgW = $area->width;
    $imgH = $area->width;
    
    $target_image = imagecreate(
        ($imgW + $marginSize*2) * $pixelPerPoint, 
        ($imgH + $marginSize*2) * $pixelPerPoint
    );
    
    $colBg      = imagecolorallocate($target_image, 255, 255, 255); // BG, white 
    $colTxt     = imagecolorallocate($target_image, 0, 0, 0);       // TXT, black 
    
    $colPix     = imagecolorallocate($target_image, 40, 40, 40);    // Pixel 
    $colRect    = imagecolorallocate($target_image, 190, 190, 190); // Rect 
    $colTracker = imagecolorallocate($target_image, 0, 220, 0);     // Tracker 
    $colTrackBg = imagecolorallocate($target_image, 0, 255, 0);     // Tracker-Bg
    $colLshape  = imagecolorallocate($target_image, 30, 30, 255);   // L-Shape 
    $colBgL     = imagecolorallocate($target_image, 240, 240, 255); // L-Shape Cut-out 
    
    $pNum = 0;
    
    // shape rendering ------------------------
    
    foreach ($area->paths as $path) {
        switch ($path[0]) {
        
            case QR_AREA_PATH:

                    // nice random colors
                    $rgb = HSVtoRGB(array(
                        mt_rand(0, 360) / 360.0,
                        ((mt_rand(0, 25))+75) / 100.0,
                        0.9
                    ));
                    
                    $colShape = imagecolorallocate(
                        $target_image, 
                        floor($rgb[0]*255), 
                        floor($rgb[1]*255), 
                        floor($rgb[2]*255)
                    );
                    $subShape = 0;
                    
                    // fill pattern
                    $fill_image = imagecreatetruecolor(5, 5);
                    $colFillBg = imagecolorallocate($fill_image, 255, 255, 255);
                    $colFill = imagecolorallocate(
                        $fill_image, 
                        floor($rgb[0]*255), 
                        floor($rgb[1]*255), 
                        floor($rgb[2]*255)
                    );
                    imagefilledrectangle ($fill_image, 0, 0, 5, 5, $colFillBg);
                    imagesetthickness($fill_image, 1);
                    imageline($fill_image, 0 , 4 , 4 , 0 , $colFill);

                    // we iterate over all subshapes of shape
                    foreach($path[1] as $pathDetails) {
                        
                        $points = array();
                        $px = array_shift($pathDetails);
                        $py = array_shift($pathDetails);
                        $rle_steps = array_shift($pathDetails);

                        $points[] = mapCoord($px);
                        $points[] = mapCoord($py);
                        
                        while(count($rle_steps) > 0) {
                        
                            $delta = 1;
                            
                            $operator = array_shift($rle_steps);
                            if (($operator != 'R') && ($operator != 'L') 
                                && ($operator != 'T') && ($operator != 'B')) {
                                $delta = (int)$operator;
                                $operator = array_shift($rle_steps);
                            }
                            
                            if ($operator == 'R') $px += $delta;
                            if ($operator == 'L') $px -= $delta;
                            if ($operator == 'T') $py -= $delta;
                            if ($operator == 'B') $py += $delta;
                        
                            $points[] = mapCoord($px);
                            $points[] = mapCoord($py);
                        }
                        
                        if ($subShape == 0) { 
                        
                            // first polygon is outline
                            
                            // fill
                            imagesettile($target_image, $fill_image);
                            imagesetthickness($target_image, 2);
                            imagefilledpolygon(
                                $target_image, 
                                $points, 
                                count($points)/2, 
                                IMG_COLOR_TILED
                            );
                            
                            // look mom, Decimal System!
                            $labelCharCount = 1+floor(log10(max(1, $pNum)));
                            
                            // label BG + TXT
                            imagefilledrectangle(
                                $target_image, mapCoord($px)+2, 
                                mapCoord($py)+2, 
                                mapCoord($px)+2+imagefontwidth(1)*$labelCharCount, 
                                mapCoord($py)+2+imagefontheight(1), 
                                $colBg
                            );
                            imagestring(
                                $target_image, 
                                1, 
                                mapCoord($px)+2, 
                                mapCoord($py)+2, 
                                $pNum, 
                                $colTxt
                            );
                            
                            // outline line
                            imagepolygon($target_image, $points, count($points)/2 , $colShape);
                            
                        } else { 
                        
                            // other polygons describes "holes" in shape
                            imagesetthickness($target_image, 2);
                            imagefilledpolygon($target_image, $points, count($points)/2 , $colBg);
                            imagepolygon($target_image, $points, count($points)/2 , $colShape);
                            imagestring($target_image, 1, mapCoord($px)+2, mapCoord($py)+2, $pNum, $colShape);
                            
                        }
                                           
                        
                        $subShape++;
                    }
                    
                    imagedestroy($fill_image);
                    $pNum++;
                    
                break;
                
            case QR_AREA_POINT:
                        
                    $symb = array_shift($path);
                    
                    while(count($path) > 0) {
                        $px = array_shift($path);
                        $py = array_shift($path);
                        
                        imagefilledrectangle(
                            $target_image, 
                            mapCoord($px), 
                            mapCoord($py), 
                            mapCoord($px+1)-1, 
                            mapCoord($py+1)-1, 
                            $colPix
                        );
                    }
                    
                break;
                
            case QR_AREA_RECT:
                    
                    $symb = array_shift($path);
                    
                    while(count($path) > 0) {
                        $px = array_shift($path);
                        $py = array_shift($path);
                        $ex = array_shift($path);
                        $ey = array_shift($path);
                        
                        imagefilledrectangle(
                            $target_image, 
                            mapCoord($px), 
                            mapCoord($py), 
                            mapCoord($ex)-1, 
                            mapCoord($ey)-1, 
                            $colRect
                        );
                    }
                    
                break;                      
                
            case QR_AREA_LSHAPE:

                    $symb = array_shift($path);
                    
                    while(count($path) > 0) {
                        $px = array_shift($path);
                        $py = array_shift($path);
                        $mode = (int)array_shift($path);
                        
                        imagefilledrectangle(
                            $target_image, 
                            mapCoord($px), 
                            mapCoord($py), 
                            mapCoord($px+2)-1, 
                            mapCoord($py+2)-1, 
                            $colLshape
                        );
                    
                        $offsetX = $px + ($mode % 2);
                        $offsetY = $py + floor($mode / 2);
                        imagefilledrectangle(
                            $target_image, 
                            mapCoord($offsetX), 
                            mapCoord($offsetY), 
                            mapCoord($offsetX+1)-1, 
                            mapCoord($offsetY+1)-1, 
                            $colBgL
                        );
                    }
                    
                break;
                
            case QR_AREA_TRACKER:
                    
                    $symb = array_shift($path);
                    
                    $px = array_shift($path);
                    $py = array_shift($path);
                        
                    imagefilledrectangle(
                        $target_image, 
                        mapCoord($px), 
                        mapCoord($py), 
                        mapCoord($px+7)-1, 
                        mapCoord($py+7)-1, 
                        $colTracker
                    );
                    imagefilledrectangle(
                        $target_image, 
                        mapCoord($px+1), 
                        mapCoord($py+1), 
                        mapCoord($px+6)-1, 
                        mapCoord($py+6)-1, 
                        $colTrackBg
                    );
                    imagefilledrectangle(
                        $target_image, 
                        mapCoord($px+2), 
                        mapCoord($py+2), 
                        mapCoord($px+5)-1, 
                        mapCoord($py+5)-1, 
                        $colTracker
                    );
                    
                break;  
        }
    }
            
    imagepng($target_image, $tempDir.$fileName);
    imagedestroy($target_image);
    
    // displaying
    
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.$fileName.'" />'; 
