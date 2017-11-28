<?php
	/* 
	 * use like this
	 *     /api/esr_code.php?amount=(amount)&ref=(reference)&account=(account)
	 * */
	 
    include("../lib/esr.php");
   
   	if (isset($_GET['amount']))
    {
		$amount = $_GET['amount'];
    }
    else
    {
		$amount = 0.00;
	}
	if (isset($_GET['ref']))
    {
		$ref = $_GET['ref'];
    }
    else
    {
		$ref = "1";
	}
	if (isset($_GET['account']))
    {
		$account = $_GET['account'];
    }
    else
    {
		$account = "01-1-1";
	}
	
	echo(ESR::amount_code($amount) . ">" .
		ESR::reference_code($ref) . "+ " .
		ESR::account_code($account) . ">");
	
