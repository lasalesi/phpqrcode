<?php

    require_once('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // how to configure pixel "zoom" factor
    
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    
    $codeContents = '123456DEMO';
    
    // generating
    QRcode::png($codeContents, $tempDir.'007_1.png', QR_ECLEVEL_L, 1);
    QRcode::png($codeContents, $tempDir.'007_2.png', QR_ECLEVEL_L, 2);
    QRcode::png($codeContents, $tempDir.'007_3.png', QR_ECLEVEL_L, 3);
    QRcode::png($codeContents, $tempDir.'007_4.png', QR_ECLEVEL_L, 4);
        
    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'007_1.png" />';
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'007_2.png" />';
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'007_3.png" />';
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'007_4.png" />'; 
