<?php

    include('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // how to build raw content - QRCode to send email, with extras
    
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    
    // here our data
    $email = 'john.doe@example.com';
    $subject = 'question';
    $body = 'please write your question here';
    
    // we building raw data
    $codeContents = 'mailto:'.$email.'?subject='.urlencode($subject).'&body='.urlencode($body);
    
    // generating
    QRcode::png($codeContents, $tempDir.'023.png', QR_ECLEVEL_L, 3);
   
    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'023.png" />'; 
