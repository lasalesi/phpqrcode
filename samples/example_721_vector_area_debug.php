<?php

    include('../lib/qrlib.php');

    // debuging vector area finding module 
    
    $codeContents   = 'Let see what the code structure looks like with a little bit bigger code';
    $eccLevel       = QR_ECLEVEL_H;
    
    $enc = QRencode::factory($eccLevel, 1, 0);
    $tab_src = $enc->encode($codeContents, false);
    $area = new QRarea($tab_src);
    $area->detectGroups();
    $area->detectAreas();
    
    $area->dumpTab(); 
