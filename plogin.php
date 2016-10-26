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
			echo tophtml();
			
			echo "<table>";
			echo "	<tr>";
			echo "		<td class='r'>E-Mail Address:</td>";
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
			// Log off ************************************ Log off **********************************
			echo tophtmlr();
			
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

				echo tophtmlr();
				
				//echo "<h2>Login Pathfinder</h2>";
				//echo "<a href='/'>Home</a>";
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
				/// ****************** Authentication failure ******************************
				
				echo tophtmlr();
				
				echo "<br />User Name or password invalid.<a href='plogin.php'>Try to login again</a><br /><a href='apath.php'>Pathfinder Home</a>";
				//echo "quERy = " . $sql . "<br/>";
				
				session_destroy(); 
								
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
	
	function tophtmlr() {
		$t = "<!DOCTYPE html>";
		$t = $t . "<html lang='en'>";
		$t = $t . "<head>";
		$t = $t . "<meta charset='UTF-8'>";
		$t = $t . "<title>Create an account</title>";
		$t = $t . "<link rel='stylesheet' href='zpa.css'>";
		$t = $t . "	<meta http-equiv='refresh' content='2;url=apath.php' />";
		$t = $t . "</head>";
		$t = $t . "<body>";
		$t = $t . "<form action='' method='post'>";
		$t = $t . "<h2>Login to Pathfinder site</h2>";
		return $t;
	}
?>

	
<em>&copy; johntoop.ca 2016</em>
		
</form>
</body>

</html>