<?php
	// make sure nothing is before the php tag
	// load QR code library
	require_once('../lib/qrlib.php');

	// load configuration
	include_once("config.php");

	// collect parameters
	if (isset($_POST['iban'])) {
		$iban = $_POST['iban'];
	}
	else {
		if (isset($_GET['iban'])) {
			$iban = $_GET['iban'];
		} else {
			$iban = "";
		}
	}
    $iban = str_replace (" ", "", $iban);           // replace whitespaces
	if (isset($_POST['bic'])) {
		$bic = $_POST['bic'];
	}
	else {
		if (isset($_GET['bic'])) {
			$bic = $_GET['bic'];
		} else {
			$bic = "";
		}
	}
    $bic = str_replace (" ", "", $bic);             // replace whitespaces
    
	if (isset($_GET['receiver_name'])) {
		$receiver_name = str_replace("_", " ", $_GET['receiver_name']);
	} else {
		$receiver_name = "";
	}

	if (isset($_GET['amount']))
    {
		$amount = $_GET['amount'];
    }
    else
    {
		$amount = "";
	}
	if (isset($_GET['currency']))
    {
		$currency = $_GET['currency'];
    }
    else
    {
		$currency = "";
	}
	if (isset($_GET['payer_name']))
    {
		$payer_name = $_GET['payer_name'];
    }
    else
    {
		$payer_name = "";
	}	
	if (isset($_GET['reference_free']))
    {
		$reference_free  = $_GET['reference_free'];
    }
    else
    {
		$reference_free = "";
	}	
	if (isset($_GET['reference']))
    {
		$reference = $_GET['reference'];
    }
    else
    {
		$reference = "";
	}	
	if (isset($_GET['message']))
    {
		$message  = $_GET['message'];
    }
    else
    {
		$message = "";
	}
	
	// create floating text content
	$content = 	"BCD" . PHP_EOL . 					// fixed service tag
				"002" . PHP_EOL . 					// Version
				"1" . PHP_EOL . 					// Encoding (utf-8)
                "SCT" . PHP_EOL .                   // SEPA credit transfer (fixed)
                $bic . PHP_EOL .	                // receiver BIC
                $receiver_name . PHP_EOL . 			// receiver name
				$iban . PHP_EOL .					// destination account 
                $currency . $amount . PHP_EOL . 	// payment details: amount
				"" . PHP_EOL .                      // purpose (4 digits)
				$reference . PHP_EOL . 				// reference (SCOR: see ISO 11649)
                $reference_free . PHP_EOL . 		// unstructured reference (max 140 characters) 
				$message . PHP_EOL; 				// reference message
	   
    // create QR code first through in a temporary file
    $fileName = 'qr_invoice_at-' . date('Y-m-d-H-i-s') . '-' . md5($content) . '.png';
    $pngAbsoluteFilePath = TEMPDIR . $fileName;
    $urlRelativeFilePath = URLRELDIR . $fileName;
    QRcode::png($content, $pngAbsoluteFilePath, "M", 10, 2);
    $qrcode = imagecreatefrompng($pngAbsoluteFilePath);
			
	// return image to browser
	header('Content-Type: image/png');
	imagepng($qrcode);
	
	// free memory
	imagedestroy($qrcode);
