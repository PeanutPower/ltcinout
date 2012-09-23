<link rel="stylesheet" type="text/css" href="main.css"/>
<?php

	require_once "db.inc";
	require_once "bitcoin/bitcoin.inc";

	$perform = $_POST["perform"];
	
	if ($perform == "register"){
	
		$new_name = $db->real_escape_string ($_POST["new_name"]);
		$new_email = $db->real_escape_string ($_POST["new_email"]);
		
		// get a deposit address for our new user
		
		$btclient = new BitcoinClient("http",$btclogin["username"],$btclogin["password"],$btclogin["host"],$btclogin["port"],"",$rpc_debug);
		$dep_addr = $btclient->GetAccountAddress($new_email); // create an address from their email :P
		
		$result = $db->query("INSERT INTO user (name,email,dep_addr) VALUES ('$new_name','$new_email','$dep_addr');");
			
		if (!$result){
		
			printf("error inserting row: %s\n", mysqli_error($db));
		
		} else {
		
			print "New user created";
		
		}
		
	}

	
	if ($perform == "checkbalance"){
	
		$check_account = $db->real_escape_string ($_POST["check_account"]);
			
		$btclient = new BitcoinClient("http",$btclogin["username"],$btclogin["password"],$btclogin["host"],$btclogin["port"],"",$rpc_debug);
		
		$balance = $btclient-> getbalance($check_account);
		
		//print "Balance: $balance";
		
		//$btclient-> sendfrom($check_account, $safe_wallet_address, $balance, $minconf = 1);
		//print "$balance forwarded to safe wallet";
		
		if ($balance > 0.1){
		
		$btclient-> move($check_account, "hotwallet", $balance);
		
		print "$balance moved to hot wallet";
		
		$result = $db->query("UPDATE user SET balance = balance + $balance WHERE email = '$check_account' LIMIT 1;");
		
		} else {
		
		print "No new confimed deposits above 0.1";
		
		}
				
	}
	
	if ($perform == "sendsafe"){
	
		$btclient = new BitcoinClient("http",$btclogin["username"],$btclogin["password"],$btclogin["host"],$btclogin["port"],"",$rpc_debug);
		
		$balance = $btclient-> getbalance("hotwallet");
				
		if ($balance > 1){
		
		$amount_to_move = $balance - 0.1;
		
		$btclient-> sendfrom("hotwallet", $safe_wallet_address, $amount_to_move, $minconf = 1);
		print "$amount_to_move forwarded to safe wallet";
				
		} else {
		
		print "Hotwallet balance less than 1";
		
		}
	
	
	}
	
	include_once "listusers.php";
	
?>

<h2>Register</h2>
<form action="." method="POST">
<table>
<tr>
<td>
<span>Name</span>
</td>
<td>
<input type="text" name="new_name"/>
</td>
</tr>
<tr>
<td>
<span>Email</span>
</td>
<td>
<input type="text" name="new_email"/>
</td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="Register"/>
</td>
</tr>
<input type="hidden" name="perform" value="register"/>
</table>
</form>

<h2>Check Balance</h2>
<form action="." method="POST">
<table>
<tr>
<td>
<span>Email</span>
</td>
<td>
<input type="text" name="check_account"/>
</td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="Check Balance"/>
</td>
</tr>
<input type="hidden" name="perform" value="checkbalance"/>
</table>
</form>

<h2>Hotwallet</h2>
<form action="." method="POST">
<table>
<tr>
<td colspan="2">
<input type="submit" value="Send to SafeWallet"/>
</td>
</tr>
<input type="hidden" name="perform" value="sendsafe"/>
</table>
</form>

<h2>GetInfo</h2>
<form action="." method="POST">
<table>
<tr>
<td colspan="2">
<input type="submit" value="GetInfo"/>
</td>
</tr>
<input type="hidden" name="perform" value="getinfo"/>
</table>
</form>

<?php

	if ($perform == "getinfo"){
	
		$btclient = new BitcoinClient("http",$btclogin["username"],$btclogin["password"],$btclogin["host"],$btclogin["port"],"",$rpc_debug);
		
		$info = $btclient-> getinfo();
		
		
		foreach ($info as $k => $v) {
			print "<li>$k $v</li>";
		}
	
	}

?>