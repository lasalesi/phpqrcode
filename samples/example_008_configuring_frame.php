<?php

    require_once('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // how to configure silent zone (frame) size
    
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    
    $codeContents = '123456DEMO';
    
    // generating
    
    // frame config values below 4 are not recomended !!!
    QRcode::png($codeContents, $tempDir.'008_4.png', QR_ECLEVEL_L, 3, 4);  
    QRcode::png($codeContents, $tempDir.'008_6.png', QR_ECLEVEL_L, 3, 6);
    QRcode::png($codeContents, $tempDir.'008_12.png', QR_ECLEVEL_L, 3, 10);

    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'008_4.png" />';
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'008_6.png" />';
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'008_12.png" />'; 
