<?php

    include('../lib/full/qrlib.php');

    // now the fun begins, we use code generating features of library
    $codeContents   = 'Let see what the code structure looks like with a little bit bigger code';
    $version        = 0; // will be autodetected
    $eccLevel       = QR_ECLEVEL_H;
    $encodingHint   = QR_MODE_8;
    $caseSensitive  = true;
    
    $code = new QRcode();
    $code->encodeString($codeContents, $version, $eccLevel, $encodingHint, $caseSensitive);
    
    QRspec::debug($code->data, false); 
