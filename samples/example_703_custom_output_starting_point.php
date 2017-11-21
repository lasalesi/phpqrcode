<?php

    include('../lib/qrlib.php');

    // now the fun begins, we use code generating features of library
    // outputs raw code table, but it is not 1 & 0, lib uses more descriptive 
    // context related bit markers
    
    $codeContents   = '12345ABCDE';
    $version        = 0; // will be autodetected
    $eccLevel       = QR_ECLEVEL_L;
    $encodingHint   = QR_MODE_8;
    $caseSensitive  = false;
    
    $code = new QRcode();
    $code->encodeString($codeContents, $version, $eccLevel, $encodingHint, $caseSensitive);
    
    echo '<pre>';
    foreach ($code->data as $line) {
        echo bin2hex($line);
        echo '<br/>';
    }
    echo '</pre>'; 
