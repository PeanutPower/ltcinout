<link rel="stylesheet" type="text/css" href="main.css"/>
<?php

	require_once "db.inc";
	require_once "bitcoin/bitcoin.inc";
	//require_once "poll.php"; // uncomment this if you don't want to use cron

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

<div>*Disclaimer* - for educational and entertainment purposes only. Transfer litecoins / play at your own risk. Minimum deposit 0.1 LTC. Maximum deposit 100 LTC. 100 Credits per LTC</div>