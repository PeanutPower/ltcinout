<?php


function sendEmail($email,$subject,$msg) {

$to      = $email;
$subject = $subject;
$message = $msg;
$headers = 'From: noreply@ltcgaming.tk' . "\r\n" .
    'Reply-To: support@ltcgaming.tk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

}

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
				$credit_amount = $account_balance * 100;
				$result = $db->query("UPDATE user SET balance = balance + $credit_amount WHERE email = '$account_name' LIMIT 1;");
				print "$account_balance moved from $account_name to hot wallet<br>";
				sendEmail($account_name,"Credit notification","We have received a deposit of $account_balance LTC to your deposit address.\n $credit_amount credits have been added to your account.");
			} else {
				// handle hotwallet differently - send to safewallet if balance above minimum send amount
				$amount_to_move = $account_balance - 0.1;
					if ($amount_to_move >= $minimum_send_amount){
					$btclient-> sendfrom("hotwallet", $safe_wallet_address, $amount_to_move);
					print "$amount_to_move forwarded to safe wallet";
				} else {
					print "Hotwallet has insufficient funds for efficient transfer to safewallet<br>";
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