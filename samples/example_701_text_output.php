<?php

    include('../lib/qrlib.php');

    // text output  
    $codeContents = '12345';
    
    // generating
    $text = QRcode::text($codeContents);
    
    // displaying
    echo '<pre>';
    echo join("\n", $text);
    echo '</pre>'; 
