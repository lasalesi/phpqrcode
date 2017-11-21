<?php

    include('../lib/qrlib.php');
    include('../lib/qrconfig.php');

    // how to build raw content - QRCode with detailed Business Card (VCard)

    $tempDir = EXAMPLE_TMP_SERVERPATH;

    // here our data
    $name         = 'John Doe';
    $sortName     = 'Doe;John';
    $phone        = '(049)012-345-678';
    $phonePrivate = '(049)012-345-987';
    $phoneCell    = '(049)888-123-123';
    $orgName      = 'My Company Inc.';

    $email        = 'john.doe@example.com';

    // if not used - leave blank!
    $addressLabel     = 'Our Office';
    $addressPobox     = '';
    $addressExt       = 'Suite 123';
    $addressStreet    = '7th Avenue';
    $addressTown      = 'New York';
    $addressRegion    = 'NY';
    $addressPostCode  = '91921-1234';
    $addressCountry   = 'USA';

    // we building raw data
    $codeContents  = 'BEGIN:VCARD'."\n";
    $codeContents .= 'VERSION:2.1'."\n";
    $codeContents .= 'N:'.$sortName."\n";
    $codeContents .= 'FN:'.$name."\n";
    $codeContents .= 'ORG:'.$orgName."\n";

    $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
    $codeContents .= 'TEL;HOME;VOICE:'.$phonePrivate."\n";
    $codeContents .= 'TEL;TYPE=cell:'.$phoneCell."\n";

    $codeContents .= 'ADR;TYPE=work;'.
        'LABEL="'.$addressLabel.'":'
        .$addressPobox.';'
        .$addressExt.';'
        .$addressStreet.';'
        .$addressTown.';'
        .$addressPostCode.';'
        .$addressCountry
    ."\n";

    $codeContents .= 'EMAIL:'.$email."\n";

    $codeContents .= 'END:VCARD';

    // generating
    QRcode::png($codeContents, $tempDir.'026.png', QR_ECLEVEL_L, 3);

    // displaying
    echo '<img src="'.EXAMPLE_TMP_URLRELPATH.'026.png" />'; 
