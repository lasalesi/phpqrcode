<?php

    include('../lib/qrlib.php');

    // text output  
    $codeContents = '12345';
    
    // generating
    $text = QRcode::text($codeContents);
    $raw = join("<br/>", $text);
    
    $raw = strtr($raw, array(
        '0' => '<span style="color:white">&#9608;&#9608;</span>',
        '1' => '&#9608;&#9608;'
    ));
    
    // displaying
    
    echo '<tt style="font-size:7px">'.$raw.'</tt>'; 
