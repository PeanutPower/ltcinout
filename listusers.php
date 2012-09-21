<?php

	require_once "db.php";
	
	$rows = $db->query("SELECT * FROM user id LIMIT 100");

	print "<table class='displayTable'>";
	print "<tr><th>id</th><th>Name</th><th>Email</th><th>Balance</th></tr>";
	
	while ($row = $rows->fetch_object()) {
		
		$id = $row->id;
		$row_name = $row->name;
		$row_email = $row->email;
		$row_balance = $row->balance;
		
		print "<tr><td>$id</td><td>$row_name</td><td>$row_email</td><td>$row_balance</td></tr>";
		
	}

	print "</table>";


?>