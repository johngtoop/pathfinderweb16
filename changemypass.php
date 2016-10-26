<?php
	// changemypass.php allows a user to set their new password. Here in the first version, it just sets the new password.
	session_start();
	// check login security to ensure we know the pmId
	if (!$_POST) {
		echo tophtml();
		// draw a table with a form to accept a new password
		echo "<table>";
		echo "<tr>";
		echo "  <td class='loginbox'>New Password:</td>";
		echo "  <td><input type='text' name='newpass' /></td></tr>";
		echo "<tr>";
		echo "  <td>&nbsp;</td><td><input type='submt' name='submit'></tr>";
		echo "</table>";
		echo "</form></body></html>";
	} else {
	// processs the password change request
	}
	

	function tophtml() {
		$t = "<!DOCTYPE html>";
		$t = $t . "<html lang='en'>";
		$t = $t . "<head>";
		$t = $t . "<meta charset='UTF-8'>";
		$t = $t . "<title>Create an account</title>";
		$t = $t . "<link rel='stylesheet' href='zpa.css'>";
		$t = $t . "</head>";
		$t = $t . "<body>";
		$t = $t . "<form action='' method='post'>";
		$t = $t . "<h2>Login to Pathfinder site</h2>";
		return $t;
	}
?>