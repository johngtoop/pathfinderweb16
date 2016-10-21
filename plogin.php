<?php 
	session_start();
	$cookiecheck = "pdmail";
	$myemail = "";
	if(isset($_COOKIE[$cookiecheck])) {
		$pdmail = $_COOKIE[$cookiecheck];
	}
	
	if (!$_POST) {
		if (!$_SESSION) {
			// Form to logon
			echo "<!DOCTYPE html>";
			echo "<html>";
			echo "<head>";
			echo "<meta charset='UTF-8'>";
			echo "<title>Login Pathfinder</title>";
			echo "<link rel='stylesheet' href='zpa.css'>";
			echo "</head>";
			echo "<body>";
			echo "<form action='' method='post'>";
			echo "<h2>Login Pathfinder</h2>";
			echo "<table>";
			echo "	<tr>";
			echo "		<td class='r'>Mail address:</td>";
			echo "		<td><input type='text' name='pEmail' value='" . $pdmail . "'></td>";
			echo "	</tr>";
			echo "	<tr>";
			echo "		<td class='r'>Password:</td>";
			echo "		<td><input type='password' name='pPwd' autofocus ></td>";
			echo "	</tr>";
			echo "  <tr>";
			echo "  	<td><input type='checkbox' name='savepuser' value='savepuser' checked>Remember me?</td>";
			echo "		<td><input type='submit' name='Login' value='Login' /></td>";
			echo "	</tr>";
			echo "</table>Get";
			echo "</form>";
		} else {
			// Log off
			echo "<!DOCTYPE html>";
			echo "<html>";
			echo "<head>";
			echo "  <link rel='stylesheet' href='../pf.css'>";
			echo "	<meta http-equiv='refresh' content='3;url=apath.php' />";
			echo "</head>";
			echo "<body>";
			
			session_unset(); 

			// destroy the session 
			session_destroy(); 
			
			echo "<p>Logging off ...";
			echo "</body>";
			echo "</html>";
		}	
	}
	else {
		// validate the users password
			// Create a link
		$link = mysqli_connect("johntoop.ca.mysql", "johntoop_ca", "fRed17t", "johntoop_ca");
 
		// Check connection
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
 
		// Escape user inputs for security
		$usrEmail = mysqli_real_escape_string($link, $_POST['pEmail']);
		$usrPwd = mysqli_real_escape_string($link, $_POST['pPwd']);
		$rememberMe = mysqli_real_escape_string($link, $_POST['savepuser']);
		$rememberMe2 = "?";
		if ($rememberMe == 'savepuser' ) {
			$cookie_name = "pdmail";
			$cookie_value = $usrEmail;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
		} else {
			$rememberMe2 = "Don't save";
		}
 
		// Select query 
		$sql = "SELECT pmId, pmClub, pmName, pmMail, pmActive, pmRole, pmFamily FROM paMembrs  WHERE pmMail = LOWER('$usrEmail') AND pmPwd = MD5('$usrPwd') AND pmActive=1 ";
		
		
		
		if($result = mysqli_query($link, $sql)){
			if(mysqli_num_rows($result) > 0){
				echo "<!DOCTYPE html>";
				echo "<html>";
				echo "<head>";
				echo "<meta charset='UTF-8'>";
				echo "<title>Login Pathfinder</title>";
				echo "<link rel='stylesheet' href='../pf.css'>";
				echo "	<meta http-equiv='refresh' content='2;url=../pf.php' />";
				echo "</head>";
				echo "<body>";
				echo "<form action='' method='post'>";
				echo "<h2>Login Pathfinder</h2>";
				echo "<a href='/'>Home</a>";
				//echo "query = " . $sql . "<br/>";
				while($row = mysqli_fetch_array($result)) {
					$_SESSION["pfId"] = $row["pfId"];
					$_SESSION["pfName"] = $row["pfName"];
					$_SESSION["pfHomeClub"] = $row["pfHomeClub"];
					$_SESSION["pcName"] = $row["pcName"];
					$_SESSION['pfEmail'] = $row["pfEmail"];
					$_SESSION['pfrName'] = $row["pfrName"];
					$_SESSION['pfRole'] = $row['pfRole'];
					
				}
				echo "<h1>Logged in</h1>";
				echo "<br /><a href='../pf.php'>Pathfinder Home</a>";
				// 	Update LastLogin ...
				// UPDATE pfMembrs SET pfLastLogin = NOW() WHERE pfId = 2
				updatelastlogin($_SESSION['pfId']);
			}
			else {
				echo "<br />User Name or Login invalid.<a href='login.php'>Try again</a><br /><a href='/'>Home</a>";
				echo "quERy = " . $sql . "<br/>";
				$_SESSION['pfId'] = "";
				$_SESSION['pfName'] = "";
				$_SESSION["pfHomeClub"] = "";
				$_SESSION['pcName'] = "";
				$_SESSION['pfEmail'] = "";
				$_SESSION['pfrName'] = "";
				$_SESSION['pfRole'] = "";
				
			}
				
		} else {
			echo "could not run query database " . $sql;
		}
	}

	function updatelastlogin($usrid) {
		//
		$linku = mysqli_connect("johntoop.ca.mysql", "johntoop_ca", "fRed17t", "johntoop_ca");
		$sqlu = "UPDATE paMembrs SET pfLastLogin = NOW() WHERE pfId = " . $usrid;
		if (mysqli_query($linku,$sqlu))
			return true;
		else
			return false;
		mysqli_close($linku);
	}
?>

	
<em>&copy; johntoop.ca 2016</em>
		
</form>
</body>

</html>