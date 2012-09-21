<?php

$db_host = ""; 				// mysql host
$db_user = ""; 				// mysql username
$db_pass = ""; 				// mysql password
$db_name = ""; 				// mysql database name
$db_port = 3306;

$db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>