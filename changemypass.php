<?php
	// changemypass.php allows a user to set their new password. Here in the first version, it just sets the new password.
	session_start();
	// check login security to ensure we know the pmId
	if (!$_POST) {
		echo tophtml();
		// draw a table with a form to accept a new password
		echo "<table>";
		echo "<tr>";
		echo "  <td class='r'>New Password:</td>";
		echo "  <td><input type='password' name='newpass' /></td></tr>";
		echo "<tr>";
		echo "  <td>&nbsp;</td><td><input type='submit' name='submit'></tr>";
		echo "</table>";
		echo "<a href='apath.php'>Pathfinder Home</a><br />";
		
		echo "</form></body></html>";
	} else {
	// processs the password change request
		echo tophtml();
		$usr = $_SESSION["pmId"];
		$pwd = trim($_POST["newpass"]);
		updatepassword($usr,$pwd);
		echo "Password updated ...";
		echo "<br /><a href='apath.php'>Pathfinder Home</a>";
		echo "</form></body></html>";
	}
	

	function updatepassword($usrid,$newpass) {
		//
		require 'dbinfo.php';
		$linku = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		$sqlu = "UPDATE paMembrs SET pmPwd = MD5('" . $newpass . "'), pmPwdDt = NOW() WHERE pmId = " . $usrid;
		if (mysqli_query($linku,$sqlu))
			return true;
		else
			return false;
		mysqli_close($linku);
	}
	
	function tophtml() {
		$t = "<!DOCTYPE html>";
		$t = $t . "<html lang='en'>";
		$t = $t . "<head>";
		$t = $t . "<meta charset='UTF-8'>";
		$t = $t . "<title>Change my password!</title>";
		$t = $t . "<link rel='stylesheet' href='zpa.css'>";
		$t = $t . "</head>";
		$t = $t . "<body>";
		$t = $t . "<form action='' method='post'>";
		$t = $t . "<h2>Change Password for " . $_SESSION["pmMail"] ."</h2>";
		return $t;
	}
?>