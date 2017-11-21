 <?php
   
    // use like this
    // $ourParamId = 1234;
    // echo '<img src="example_003_simple_png_output_param.php?id='.$ourParamId.'" />'; 

    require_once('../lib/qrlib.php');
        
    $param = $_GET['id']; // remember to sanitize that - it is user input!
    
    // we need to be sure ours script does not output anything!!!
    // otherwise it will break up PNG binary!
    
    ob_start("callback");
    
    // here DB request or some processing
    $codeText = 'DEMO - '.$param;
    
    // end of processing here
    $debugLog = ob_get_contents();
    ob_end_clean();
    
    // outputs image directly into browser, as PNG stream
    QRcode::png($codeText); 
