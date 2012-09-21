<link rel="stylesheet" type="text/css" href="main.css"/>
<?php

	require_once "db.php";

	$perform = $_POST["perform"];
	
	if ($perform == "register"){
	
		$new_name = $db->real_escape_string ($_POST["new_name"]);
		$new_email = $db->real_escape_string ($_POST["new_email"]);
		
		$result = $db->query("INSERT INTO user (name,email) VALUES ('$new_name','$new_email');");
			
		if (!$result){
		
			printf("error inserting row: %s\n", mysqli_error($db));
		
		} else {
		
			print "New user created";
		
		}
		
	}

	include_once "listusers.php";
	
?>

<h2>Register</h2>
<form action="." method="POST">
<table>
<tr>
<td>
<span>Name</span>
</td>
<td>
<input type="text" name="new_name"/>
</td>
</tr>
<tr>
<td>
<span>Email</span>
</td>
<td>
<input type="text" name="new_email"/>
</td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="Register"/>
</td>
</tr>
<input type="hidden" name="perform" value="register"/>
</table>
</form>