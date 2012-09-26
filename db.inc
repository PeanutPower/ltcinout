<?php

require "config.php";

$db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// global support functions

function sendEmail($email,$subject,$msg) {

$to      = $email;
$subject = $subject;
$message = $msg;
$headers = 'From: noreply@ltcgaming.tk' . "\r\n" .
    'Reply-To: support@ltcgaming.tk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

}

?>