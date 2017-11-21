<?php

    include('../lib/qrlib.php');

    // debuging vector area finding module, shape classification 
    
    $codeContents   = 'Let see what the code structure looks like with a little bit bigger code';
    $eccLevel       = QR_ECLEVEL_H;
    
    $enc = QRencode::factory($eccLevel, 1, 0);
    $tab_src = $enc->encode($codeContents, false);
    $area = new QRarea($tab_src);
    $area->detectGroups();
    $area->detectAreas();
    
    echo '<b style="color:red">red edged</b> - complex shapes<br/>';
    echo '<b>without edge</b> - simple shapes (single pixels, rectangles, 3-pixel L shapes)<br/>';
    
    $area->dumpEdges(); 
