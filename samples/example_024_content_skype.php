<?php

    include('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // how to build raw content - QRCode to call with Skype
    
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    
    // here our data
    $skypeUserName = 'echo123';
    
    // we building raw data
    $codeContents = 'skype:'.urlencode($skypeUserName).'?call';
    
    // generating
    QRcode::png($codeContents, $tempDir.'024.png', QR_ECLEVEL_L, 3);
   
    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'024.png" />'; 
