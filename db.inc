<?php

require "config.php";

$db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>