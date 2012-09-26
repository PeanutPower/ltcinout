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
	
	// add unique constraint on email column
	$result = $db->query("ALTER TABLE user ADD CONSTRAINT UNIQUE (email);");
	if (!$result){
		printf("error adding unique constraint to table: %s\n", mysqli_error($db));
	}
		
	// add "pass_sha" column to "user" table
	$result = $db->query("ALTER TABLE user ADD COLUMN pass_sha varchar(40) NOT NULL DEFAULT '';");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// add "balance" column to "user" table
	$result = $db->query("ALTER TABLE user ADD COLUMN balance INT(8) NOT NULL DEFAULT 0;");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// add "verify_code" column to "user" table
	$result = $db->query("ALTER TABLE user ADD COLUMN verify_code varchar(40) NOT NULL DEFAULT '';");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// add "verified" column to "user" table
	$result = $db->query("ALTER TABLE user ADD COLUMN verified int(1) NOT NULL DEFAULT 0;");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// add "dep_addr" (deposit address) column to "user" table
	// we will only have 1 deposit address per user
	$result = $db->query("ALTER TABLE user ADD COLUMN dep_addr varchar(34) NOT NULL DEFAULT '';");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// SETTING TABLE
	
	// create table "setting" with primary key "id" column, an auto incrementing integer if it doesn't already exist
	$result = $db->query("CREATE TABLE setting (id int NOT NULL AUTO_INCREMENT, PRIMARY KEY (id));");
	if (!$result){
		printf("error creating table: %s\n", mysqli_error($db));
	}
	
	// add "name" column to "setting" table
	$result = $db->query("ALTER TABLE setting ADD COLUMN name varchar(20) NOT NULL DEFAULT '';");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// add unique index on email column
	$result = $db->query("ALTER TABLE setting ADD UNIQUE INDEX name_index (name);");
	if (!$result){
		printf("error adding unique index to table: %s\n", mysqli_error($db));
	}
		
	// add "value" column to "setting" table
	$result = $db->query("ALTER TABLE setting ADD COLUMN value varchar(20) NOT NULL DEFAULT '';");
	if (!$result){
		printf("error adding column to table: %s\n", mysqli_error($db));
	}
	
	// add "LAST_POLL_TIME" setting to setting table
	$now = time();
	$result = $db->query("INSERT INTO setting (name,value) VALUES ('LAST_POLL_TIME','$now');");
	if (!$result){
		printf("error adding LAST_POLL_TIME to setting table", mysqli_error($db));
	}
	
	// add "MAX_POLL_FREQ" setting to setting table (every 60 seconds)
	$result = $db->query("INSERT INTO setting (name,value) VALUES ('MAX_POLL_FREQ','60');");
	if (!$result){
		printf("error adding MAX_POLL_FREQ to setting table", mysqli_error($db));
	}
	
	
	
	
?>