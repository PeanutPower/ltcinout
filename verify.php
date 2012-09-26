<?php

	require_once "db.inc";
	
	$supplied_key = $db->real_escape_string ($_GET["key"]);
	
	$rows = $db->query("SELECT * FROM user WHERE verify_code = '$supplied_key' LIMIT 1");

	if ($rows->num_rows == 0){
		print "Invalid code";
		exit;
	}
	
	while ($row = $rows->fetch_object()) {
		
		$id = $row->id;
		$row_name = $row->name;
		$verified = $row->verified;

		if ($verified == 0){
			$db->query("UPDATE user SET verified = 1 WHERE verify_code = '$supplied_key' LIMIT 1");
			print "Thank you $row_name<br>";
			print "Your account has now been activated.";
		} else {
			print "Your account has already been activated<br>";
		}
		$homeurl = "http://".$_SERVER["SERVER_NAME"];
		print "You may now <a href=\"$homeurl\">Login</a>";
		

	}

?>