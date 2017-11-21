<?php
   require_once("../lib/qrlib.php");
   
   // creates code image and outputs it directly into browser
   // ECC options are L (smallest), M, Q, H (best)
   // Pixel sizes are 1..10
   // Frame sizes are e.g. 4, 6, 12
   QRcode::png('Sample content text', false, 'H', 4, 2);
   
