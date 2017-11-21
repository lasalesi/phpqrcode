<?php

    include('../lib/qrlib.php');
    
    // SVG file format support
    
    $svgCode = QRcode::svg('PHP QR Code :)');
    
    echo $svgCode; 
