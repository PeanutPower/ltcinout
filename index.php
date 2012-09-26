<link rel="stylesheet" type="text/css" href="main.css"/>
<?php

	require_once "db.inc";
	require_once "bitcoin/bitcoin.inc";
	//require_once "poll.php"; // uncomment this if you don't want to use cron

	$perform = $_POST["perform"];
	
	if ($perform == "register"){
	
		$new_name = $db->real_escape_string ($_POST["new_name"]);
		$new_email = $db->real_escape_string ($_POST["new_email"]);
		
		$reg_err = "";
		
		if (strlen($new_name) < 3){
			$reg_err = $reg_err ."Usernames must be at least 3 characters<br>";

		}
		if (strlen($new_name) > 20){
			$reg_err = $reg_err . "Usernames must be less than 20 characters<br>";

		}
		
		if (strlen($new_email) < 6){
			$reg_err = $reg_err . "Invalid email address<br>";
	
		}
		if (strlen($new_email) > 30){
			$reg_err = $reg_err . "Sorry email address must be less than 30 characters<br>";
		}
		
		// prevent email from being uses more than once
		$email_used = $db->query("SELECT name from user WHERE email = '$new_email' LIMIT 1;")->num_rows;
		if ($email_used == 1){
			$reg_err = $reg_err ."Sorry that email address has already been used<br>";
		}
		
		// if no errors create account
		if ($reg_err == ""){
		
		// get a deposit address for our new user
		
		$btclient = new BitcoinClient("http",$btclogin["username"],$btclogin["password"],$btclogin["host"],$btclogin["port"],"",$rpc_debug);
		$dep_addr = $btclient->GetAccountAddress($new_email); // create an address from their email :P
		
		$sha = sha1(md5($new_email.$salt));
		$result = $db->query("INSERT INTO user (name,email,dep_addr,verify_code) VALUES ('$new_name','$new_email','$dep_addr','$sha');");
			
		if (!$result){
		
			printf("error inserting row: %s\n", mysqli_error($db));
		
		} else {
		
			$linkurl = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."verify.php?key=$sha";
			sendEmail($new_email,"Complete your registration","Please verify your email address using the link below:\n\n$linkurl\n\n You will then be able to purchase tokens with your account.");
			print "New user created";
		
		}
		
		} else {
		
			print "$reg_err";
		
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

<div>
*Disclaimer*<br>
For educational and entertainment purposes only.<br>
Transfer litecoins / use at your own risk.<br>
Minimum deposit 0.1 LTC.<br>
Maximum deposit 100 LTC.<br>
100 credits will be given per LTC with inexact amounts rounded down to the nearest whole credit.<br>
</div>