<?php
   require_once("../lib/qrlib.php");
   
   // creates code image and outputs it directly into browser
   QRcode::png('This is a sample content'); 
   
