<?php
	/* 
	 * use like this
	 *     /api/esr_reference.php?ref=(reference)
	 * */
	 
    include("../lib/esr.php");
   
   	if (isset($_GET['ref']))
    {
		$ref = $_GET['ref'];
    }
    else
    {
		$ref = "1";
	}
	
	echo(ESR::reference_code($ref));
	
