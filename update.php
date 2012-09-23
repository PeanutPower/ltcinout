<?php

	// todo: prevent this from being triggered by direct page request

	require_once "db.inc";
	
	//print "Update stuff happens here";

	$btclient = new BitcoinClient("http",$btclogin["username"],$btclogin["password"],$btclogin["host"],$btclogin["port"],"",$rpc_debug);
		
	$info = $btclient-> listaccounts();
	
	// display named accounts
	foreach ($info as $account_name => $account_balance) {
		if ($account_name <> ""){
			print "<li>$account_name : $account_balance LTC</li>";
		}
	}
	
	$minimum_send_amount = 50;
	// don't send to safewallet unless hotwallet exceeds this amount to minimise transaction fees
	// i.e. 0.1 / 50 = 0.2% max transaction fees incurred to get funds to safewallet
		
	// perform action for every account that has a balance above 0.1
	foreach ($info as $account_name => $account_balance) {
		if ($account_name <> "" && $account_balance >= 0.1){
			if ($account_name <> "hotwallet"){
				// handle deposit account - move to hotwallet
				$btclient-> move($account_name, "hotwallet", $account_balance);
				$result = $db->query("UPDATE user SET balance = balance + $account_balance WHERE email = '$account_name' LIMIT 1;");
				print "$account_balance moved from $account_name to hot wallet";
			} else {
				// handle hotwallet differently - send to safewallet if balance above minimum send amount
				$amount_to_move = $account_balance - 0.1;
					if ($amount_to_move >= $minimum_send_amount){
					$btclient-> sendfrom("hotwallet", $safe_wallet_address, $amount_to_move);
					print "$amount_to_move forwarded to safe wallet";
				} else {
					print "Hotwallet does not yet have enough funds for efficient transfer to safewallet";
				}
			}
		}
	}
	
	// finally show litecoind status on remote server
	$info = $btclient-> getinfo();
	foreach ($info as $k => $v) {
		print "<li>$k $v</li>";
	}
	

?>