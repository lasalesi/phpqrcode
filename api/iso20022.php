<?php
	// make sure nothing is before the php tag
	
	// we need to be sure our script does not output anything!!!
    // otherwise it will break up PNG binary!  
    ob_start();
    
	// load configuration
	include_once("config.php");
	
	// collect parameters
	if (isset($_GET['iban']))
    {
		$iban = $_GET['iban'];
    }
    else
    {
		$iban = "CH1212341234123412349";
	}
	if (isset($_GET['receiver_name']))
    {	
		$receiver_name = $_GET['receiver_name'];
    }
    else
    {
		$receiver_name = "";
	}
	if (isset($_GET['receiver_street']))
    {
		$receiver_street = $_GET['receiver_street'];
    }
    else
    {
		$receiver_street =  "";
	}	
	if (isset($_GET['receiver_number']))
    {
		$receiver_number = $_GET['receiver_number'];
    }
    else
    {
		$receiver_number = "";
	}
	if (isset($_GET['receiver_pincode']))
    {
		$receiver_pincode = $_GET['receiver_pincode'];
    }
    else
    {
		$receiver_pincode = "";
	}
	if (isset($_GET['receiver_town']))
    {
		$receiver_town = $_GET['receiver_town'];
    }
    else
    {
		$receiver_town = "";
	}	
	if (isset($_GET['receiver_country']))
    {
		$receiver_country = $_GET['receiver_country'];
    }
    else
    {
		$receiver_country = "";
	}
	if (isset($_GET['final_receiver_name']))
    {
		$final_receiver_name = $_GET['final_receiver_name'];
    }
    else
    {
		$final_receiver_name = "";
	}
	if (isset($_GET['final_receiver_street']))
    {
		$final_receiver_street  = $_GET['final_receiver_street'];
    }
    else
    {
		$final_receiver_street = "";
	}	
	if (isset($_GET['final_receiver_number']))
    {
		$final_receiver_number = $_GET['final_receiver_number'];
    }
    else
    {
		$final_receiver_number = "";
	}	
	if (isset($_GET['final_receiver_pincode']))
    {
		$final_receiver_pincode = $_GET['final_receiver_pincode'];
    }
    else
    {
		$final_receiver_pincode = "";
	}	
	if (isset($_GET['final_receiver_town']))
    {
		$final_receiver_town = $_GET['final_receiver_town'];
    }
    else
    {
		$final_receiver_town = "";
	}
	if (isset($_GET['final_receiver_country']))
    {
		$final_receiver_country = $_GET['final_receiver_country'];
    }
    else
    {
		$final_receiver_country = "";
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
	if (isset($_GET['due_date']))
    {
		$due_date = $_GET['due_date'];
    }
    else
    {
		$due_date = "";
	}	
	if (isset($_GET['payer_name']))
    {
		$payer_name = $_GET['payer_name'];
    }
    else
    {
		$payer_name = "";
	}
	if (isset($_GET['payer_street']))
    {
		$payer_street  = $_GET['payer_street'];
    }
    else
    {
		$payer_street = "";
	}	
	if (isset($_GET['payer_number']))
    {
		$payer_number  = $_GET['payer_number'];
    }
    else
    {
		$payer_number = "";
	}	
	if (isset($_GET['payer_pincode']))
    {
		$payer_pincode = $_GET['payer_pincode'];
    }
    else
    {
		$payer_pincode = "";
	}	
	if (isset($_GET['payer_town']))
    {
		$payer_town = $_GET['payer_town'];
    }
    else
    {
		$payer_town = "";
	}	
	if (isset($_GET['payer_country']))
    {
		$payer_country = $_GET['payer_country'];
    }
    else
    {
		$payer_country = "";
	}	
	if (isset($_GET['reference_type']))
    {
		$reference_type  = $_GET['reference_type'];
    }
    else
    {
		$reference_type = "";
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
	
	// create xml content
	$content = "<QRCH>" .
	   "<Header>" . /* header */
	       "<QRType>SPC</QRType>" .
	       "<Version>0100</Version>" .
	       "<Coding>1</Coding>" .
	   "</Header>" .
	   "<CdtrInf>" . /* destination account */
	       "<IBAN>" . $iban . "</IBAN>" .
	   "</CdtrInf>" .
	   "<Cdtr>" . /* receiver */
		   "<Name>" . $receiver_name . "</Name>" .
		   "<StrtNm>" . $receiver_street . "</StrtNm>" .
		   "<BldgNb>" . $receiver_number . "</BldgNb>" .
		   "<PstCd>" . $receiver_pincode . "</PstCd>" .
		   "<TwnNm>" . $receiver_town . "</TwnNm>" .
		   "<Ctry>" . $receiver_country . "</Ctry>" .
	   "</Cdtr>" .
	   "<UltmtCdtr>" . /* final receiver */
		   "<Name>" . $final_receiver_name . "</Name>" .
		   "<StrtNm>" . $final_receiver_street . "</StrtNm>" .
		   "<BldgNb>" . $final_receiver_number . "</BldgNb>" .
		   "<PstCd>" . $final_receiver_pincode . "</PstCd>" .
		   "<TwnNm>" . $final_receiver_town . "</TwnNm>" .
		   "<Ctry>" . $final_receiver_country . "</Ctry>" .	   
	   "</UltmtCdtr>" .
	   "<CcyAmtDate>" . /* payment details */
	       "<Amt>" . $amount . "</Amt>" .
	       "<Ccy>" . $currency . "</Ccy>" . 
	       "<ReqdExctnDt>" . $due_date . "</ReqdExctnDt>" .
	   "</CcyAmtDate>" .
	   "<UltmtDbtr>" . /* payer */
	   	   "<Name>" . $payer_name . "</Name>" .
		   "<StrtNm>" . $payer_street . "</StrtNm>" .
		   "<BldgNb>" . $payer_number . "</BldgNb>" .
		   "<PstCd>" . $payer_pincode . "</PstCd>" .
		   "<TwnNm>" . $payer_town . "</TwnNm>" .
		   "<Ctry>" . $payer_country . "</Ctry>" .
	   "</UltmtDbtr>" . 
	   "<RmtInf>" . /* reference */
	       "<Tp>" . $reference_type . "</Tp>" . /* QRR, SCOR or NON */
	       "<Ref>" . $reference . "</Ref>" .
	       "<Ustrd>" . $message . "</Ustrd>" .
	   "</RmtInf>" .
	   "<AltPmtInf>" . /* alternative procedure */
	       "<AltPmt></AltPmt>" .
	   "</AltPmtInf>" .
	   "</QRCH>";
	   
    // create QR code first through the API
    $src = HOST . '/phpqrcode/api/qrcode.php?content=' . $content . '&ecc=M&size=10&frame=2';
    $qrcode = imagecreatefromstring(file_get_contents($src));
    
    // load the stamp
    $stamp = imagecreatefrompng("CH-Kreuz_7mm.png");
    
    // define location and dimension of the stamp
    $width = imagesx($stamp);
    $height = imagesy($stamp);
    $margin_right = 10;
    $margin_bottom = 10;
    
    // merge stamp onto QR code
	$pos_x = (imagesx($qrcode) / 2) - ($width / 2);
	$pos_y = (imagesy($qrcode) / 2) - ($height / 2);
	imagecopymerge($qrcode, $stamp, $pos_x, $pos_y, 0, 0,
		imagesx($stamp), imagesy($stamp), 100);
			
	// return image to browser
	header('Content-Type: image/png');
	imagepng($qrcode);
	
	// free memory
	imagedestroy($qrcode);
	imagedestroy($stamp);
	
	// finalise output
	ob_end_clean();
