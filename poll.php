<?php

	// script to trigger something at a certain frequency driven by page request
	// e.g. batch update which can be done maximum once per minute
	// you can either cron this or require it in every page that relies on updates

	require_once "db.inc";
	require_once "bitcoin/bitcoin.inc";
	
	//todo: optimise as one query into a php array
	$last_poll_time = $db->query("SELECT value FROM setting WHERE name = 'LAST_POLL_TIME' LIMIT 1")->fetch_object()->value;
	$max_poll_freq = $db->query("SELECT value FROM setting WHERE name = 'MAX_POLL_FREQ' LIMIT 1")->fetch_object()->value;
	
	$now = time();
	$elapsed = $now - $last_poll_time;
	$canpoll = ($elapsed >= $max_poll_freq);
	
	print "Last poll time: $last_poll_time<br>";
	print "Time now: $now<br>";
	print "Elapsed seconds: $elapsed<br>";
	print "Maximum poll frequency: $max_poll_freq"."s<br>";
	
	$booltext = Array(false => 'No', true => 'Yes');
	print "Can poll: $booltext[$canpoll]<br>";
	
	if ($canpoll){
		
		// update the last poll time
		$db->query("UPDATE setting SET value = '$now' WHERE name = 'LAST_POLL_TIME' LIMIT 1;");
	
		// do polling stuff
		include_once "update.php";
	
	}

?>