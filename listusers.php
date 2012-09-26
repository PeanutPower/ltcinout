<?php

	require_once "db.inc";
	
	$rows = $db->query("SELECT * FROM user id LIMIT 100");

	print "<table class='displayTable'>";
	print "<tr><th>id</th><th>Name</th><th>Credits</th><th>Deposit Address</th></tr>";
	
	while ($row = $rows->fetch_object()) {
		
		$id = $row->id;
		$row_name = $row->name;
		$row_email = $row->email;
		$row_balance = $row->balance;
		$row_deposit_address = $row->dep_addr;
		$row_verified = $row->verified;
		
		if ($row_verified) {
			$linkhtml = "<a href=\"http://explorer.litecoin.net/address/$row_deposit_address\">$row_deposit_address</a>";
		} else {
			$linkhtml = "Email unverified";
		}
		
		print "<tr><td>$id</td><td>$row_name</td><td>$row_balance</td><td>$linkhtml</td></tr>";
		
	}

	print "</table>";


?>