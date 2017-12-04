 <?php
   
    /* use like this
     *
     * api/qrcode.php?content=your text&ecc=H&size=10&frame=4
     * 
     */
    
    // load QR code library
    require_once('../lib/qrlib.php');
    
    // we need to be sure our script does not output anything!!!
    // otherwise it will break up PNG binary!  
    ob_start("callback");
 
    // read parameters, remember to sanitize that - it is user input!
    if (isset($_GET['content']))
    {
		$content = $_GET['content'];
    }
    else
    {
		$content = "No content provided";
	}
	if (isset($_GET['ecc']))
    {
		$ecc = $_GET['ecc'];
    }
    else
    {
		$ecc = "L";
	}
    if (isset($_GET['size']))
    {
		$size = $_GET['size'];
    }
    else
    {
		$size = 4;
	}    
    if (isset($_GET['frame']))
    {
		$frame = $_GET['frame'];
    }
    else
    {
		$frame = 2;
	}
    
    // here DB request or some processing
    // $codeText = 'DEMO - '.$param;
    
    // end of processing here
    $debugLog = ob_get_contents();
    ob_end_clean();

    // outputs image directly into browser, as PNG stream
    QRcode::png($content, false, $ecc, $size, $frame); 

    
