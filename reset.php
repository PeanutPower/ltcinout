<?php

	// REMEMBER TO DELETE THIS FILE

	require_once "db.inc";
	
	$result = $db->query("DROP TABLE user");
	if (!$result){
		printf("error dropping table: %s\n", mysqli_error($db));
	}
	
	$result = $db->query("DROP TABLE setting");
	if (!$result){
		printf("error dropping table: %s\n", mysqli_error($db));
	}
	
	
?>