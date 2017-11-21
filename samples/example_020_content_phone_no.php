<?php

    require_once('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // how to build raw content - QRCode to call phone number
    
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    
    // here our data
    $phoneNo = '(049)012-345-678';
    
    // we building raw data
    $codeContents = 'tel:'.$phoneNo;
    
    // generating
    QRcode::png($codeContents, $tempDir.'020.png', QR_ECLEVEL_L, 3);
   
    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'020.png" />'; 
