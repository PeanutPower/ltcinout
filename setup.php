<?php

	require_once "db.inc";
	
	// create table "user" with primary key "id" column, an auto incrementing integer
	$result = $db->query("CREATE TABLE user (id int NOT NULL AUTO_INCREMENT, PRIMARY KEY (id));");
	if (!$result){
		printf("error creating table: %s\n", mysqli_error($db));
	}
	
	// add "name" column to "user" table
	$result = $db->query("ALTER TABLE user ADD COLUMN name varchar(20) NOT NULL DEFAULT '';");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
		
	// add "email" column to "user" table
	$result = $db->query("ALTER TABLE user ADD COLUMN email varchar(255) NOT NULL DEFAULT '';");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
		
	// add "pass_sha" column to "user" table
	$result = $db->query("ALTER TABLE user ADD COLUMN pass_sha varchar(40) NOT NULL DEFAULT '';");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// add "balance" column to "user" table
	$result = $db->query("ALTER TABLE user ADD COLUMN balance Decimal (19,4) NOT NULL DEFAULT 0;");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// add "dep_addr" (deposit address) column to "user" table
	// we will only have 1 deposit address per user
	$result = $db->query("ALTER TABLE user ADD COLUMN dep_addr varchar(34) NOT NULL DEFAULT 0;");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	
	
?>