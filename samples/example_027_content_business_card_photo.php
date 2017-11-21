<?php

    include('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // how to build raw content - QRCode with Business Card (VCard) + photo
    
    $tempDir = EXAMPLE_TMP_SERVERPATH;
    
    // here our data
    $name = 'John Doe';
    $phone = '(049)012-345-678';
    
    // WARNING! here jpeg file is only 40x40, grayscale, 50% quality!
    // with bigger images it will simply be TOO MUCH DATA for QR Code to handle!
    
    $avatarJpegFileName = 'avatar.jpg';
    
    // we building raw data
    $codeContents  = 'BEGIN:VCARD'."\n";
    $codeContents .= 'FN:'.$name."\n";
    $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
    $codeContents .= 'PHOTO;JPEG;ENCODING=BASE64:'.base64_encode(file_get_contents($avatarJpegFileName))."\n";
    $codeContents .= 'END:VCARD';
    
    // generating
    QRcode::png($codeContents, $tempDir.'027.png', QR_ECLEVEL_L, 3);
   
    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'027.png" />'; 
