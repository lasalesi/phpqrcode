<?php

    include('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // how to build raw content - QRCode to send SMS
    
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    
    // here our data
    $phoneNo = '(049)012-345-678';
    
    // we building raw data
    $codeContents = 'sms:'.$phoneNo;
    
    // generating
    QRcode::png($codeContents, $tempDir.'021.png', QR_ECLEVEL_L, 3);
   
    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'021.png" />'; 
