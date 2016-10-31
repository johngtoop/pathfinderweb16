<?php 
	session_start();
	$email_error = "";
	$passw_error = "";
	$isvalid = false;
	$str1 = "john@canada.ca";
	$str2 = "john_at_canada_dot_ca";
	
	
	if (!$_POST ) {
		echo tophtml();
		
		echo "    <table>";
		echo "		<tr>";
		echo "			<td class='r'>E-Mail Address / Name (First Last)</td>";
		echo "			<td><input type='text' name='usrEmail' id='usrEmail'>";
		echo "             " . $email_error;
		echo "             </td>";
		echo " 		</tr>";
		echo "		<tr>";
		echo "			<td class='r'>Password:</td>";
		echo "			<td><input type='password' name='usrPwd' id='usrPwd'>";
		echo "          " . $passw_error;
		echo "			</td>";
		echo "		</tr>";
		echo "		<tr>";
		echo "			<td>&nbsp;</td>";
		echo "			<td><input type='submit' value='Register'></td>";
		echo "		</tr>";
		echo "	</table>";
		echo "<input type='hidden' value='2' name='club' />";
		echo "<br />";
		echo "<p>Please do not worry about passwords for pathfinders. They do not need to login and have ";
		echo "minimal rights even if they do login. Give them a name (first last) only to prevent login.";
		echo "<p>If the admin gives you rights, then you can change your Profile items such as your password or Name spelling.</p>";
		echo "<p>Forget the password you assign? No problem, let me know and I'll reset it.</p>";
		echo "<p><a href='plogin.php'>Login</a></p>";
		echo "<p><a href='apath.php'>Home</a></p>";
		echo "</form>";
			
	} else {
		
		$usrEmail = trim($_POST['usrEmail']);
		$usrPwd = $_POST['usrPwd'];
		$club = $_POST['club'];
		
		if (isvalid($usrEmail,$usrPwd)) {
			// Connect
			require 'dbinfo.php';
			$link = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
			
			// Check connection
			if($link === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
			 
			// Escape user inputs for security
			 
			// attempt insert query execution
			if (isemail($usrEmail) )
				$sql = "INSERT INTO paMembrs (pmMail, pmClub, pmPwd, pmActive, pmRole ) VALUES (LOWER('$usrEmail'), $club , MD5('$usrPwd'), 0, 14)";
			else
				$sql = "INSERT INTO paMembrs (pmName, pmClub, pmPwd, pmActive, pmRole )  VALUES ('$usrEmail' ,$club , MD5('$usrPwd'), 0, 14)";
			
			if(mysqli_query($link, $sql)){
				echo tophtml();
				echo "Pathfinder added successfully.";
			} else {
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
			}
			 
			echo "<br /><a href='preg.php'>Register Another Pathfinder</a>";
			echo "<br /><a href='apath.php'>Home</a><br />";
			// close connection
			mysqli_close($link);
		} else {
			echo "<div class='alert'>Error! Password length must be at least 1 and email must be unique '" . $eml . "'/'" . $pwd . "'</div>";
			echo "<a href='preg.php'>Try again to register</a><br />";
			echo "<a href='/apath.php'>Home</a><br />";
		}
		
	}
	
	function isemail($txt) {
		$sometext = "x" . $txt;
		if (strpos($sometext,"@") !== false)
			return true;
		else
			return false;		
	}
	
	function isvalid($email, $pwd) {
		$password = trim($pwd);
		if (strlen($password) < 1) {
			return false;
		} else if (!isemail($email)) {
			return true;
		}
		else if (email_found($email) > 0) {
			return false;
		} else {
			return true;
		}		
	}
	
	function email_found($email) {
		$numfound = -1;
		require 'dbinfo.php';
		$link = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
		$sql = "SELECT COUNT( * ) AS NumFound FROM paMembrs WHERE pmMail =  '" . $email . "'";
		if($result = mysqli_query($link, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$numfound = $row['NumFound'];
				}
			}
		}
		mysqli_free_result($result);
		mysqli_close($link);
		
		return $numfound;
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
		$t = $t . "<h2>Register for Pathfinder site</h2>";
		return $t;
	}
?>


</form>
</body>
</html>