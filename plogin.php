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
		require 'dbinfo.php';
		// dbpass.php looks like ...
		// $dbserver = "pfserver";
		// $dbuser   = "username";
		// $dbpass   = "dbpass";
		// $database = "databasename";
		$link = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
 
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
				echo "<link rel='stylesheet' href='zpa.css'>";
				echo "	<meta http-equiv='refresh' content='12;url=apath.php' />";
				echo "</head>";
				echo "<body>";
				echo "<form action='' method='post'>";
				echo "<h2>Login Pathfinder</h2>";
				echo "<a href='/'>Home</a>";
				//echo "query = " . $sql . "<br/>";
				while($row = mysqli_fetch_array($result)) {
					$_SESSION["pmId"] = $row["pmId"];
					$_SESSION["pmName"] = $row["pmName"];
					$_SESSION["pmClub"] = $row["pmClub"];
					$_SESSION['pmMail'] = $row["pmMail"];
					$_SESSION['pmRole'] = $row["pmRole"];
					
					
				}
				echo "<h1>Logged in</h1>";
				echo "<br /><a href='apath.php'>Pathfinder Home</a>";
				// 	Update LastLogin ...
				// UPDATE pfMembrs SET pfLastLogin = NOW() WHERE pfId = 2
				updatelastlogin($_SESSION['pmId']);
			}
			else {
				echo "<br />User Name or Login invalid.<a href='login.php'>Try again</a><br /><a href='/'>Home</a>";
				echo "quERy = " . $sql . "<br/>";
				$_SESSION['pmId'] = "";
				$_SESSION['pmName'] = "";
				$_SESSION["pmClub"] = "";
				$_SESSION['pmMail'] = "";
				$_SESSION['pmRole'] = "";
				
			}
				
		} else {
			echo "could not run query database " . $sql;
		}
	}

	function updatelastlogin($usrid) {
		//
		require 'dbinfo.php';
		$linku = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		$sqlu = "UPDATE paMembrs SET pmLastLogin = NOW() WHERE pmId = " . $usrid;
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