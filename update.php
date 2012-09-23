<?php

	// todo: prevent this from being triggered by direct page request

	require_once "db.inc";
	
	print "Update stuff happens here";

	$btclient = new BitcoinClient("http",$btclogin["username"],$btclogin["password"],$btclogin["host"],$btclogin["port"],"",$rpc_debug);
		
	$info = $btclient-> getinfo();
		
		
	foreach ($info as $k => $v) {
		print "<li>$k $v</li>";
	}

?>