<?php

    require_once('../lib/qrlib.php');
    include('./lib/qrconfig.php');

    // how to save PNG codes to server
    
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    
    $codeContents = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a';
    
    // generating
    QRcode::png($codeContents, $tempDir.'006_L.png', QR_ECLEVEL_L);
    QRcode::png($codeContents, $tempDir.'006_M.png', QR_ECLEVEL_M);
    QRcode::png($codeContents, $tempDir.'006_Q.png', QR_ECLEVEL_Q);
    QRcode::png($codeContents, $tempDir.'006_H.png', QR_ECLEVEL_H);
        
    // end displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'006_L.png" />';
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'006_M.png" />';
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'006_Q.png" />';
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'006_H.png" />'; 
