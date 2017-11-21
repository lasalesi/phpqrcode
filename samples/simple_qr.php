<?php
   require_once("../qrlib.php");
   
   QRcode::png('some othertext 1234'); // creates code image and outputs it directly into browser
   