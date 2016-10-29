<?php
	// pfam.php 	- Families list / edit / Add
	session_start();
	$role = $_SESSION['pmRole'];
	$club = $_SESSION['pmClub'];
	
	if (($role == 6) || ($role == 2) || ($role == 3)) {
		echo "<h2>Families</h2>";
		if (!$_POST) {
			echo tophtml("New Family");
			echo newfamily();
			echo showfamilys();
			echo "</form></body></html>";
		} else {
		// This is posted ... lets save it 
		//echo "saving ... not!";
		// *********************************** save family info if exists ********************
		$FamilyName = trim($_POST['pfname']);
		
		if (isvalid($FamilyName)) {
			// Connect
			require 'dbinfo.php';
			$link = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
			
			// Check connection
			if($link === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
			 
			// Escape user inputs for security
			 
			// attempt insert query execution
			$sql = "INSERT INTO paFamily (pfName)  VALUES ('$FamilyName')";
			
			if(mysqli_query($link, $sql)){
				echo tophtml("New Family");
				echo "Family added successfully.";
			} else {
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
			}
		}
		// ***********************************************************************************
		}
	} else {
		echo "not enough security ...";
	}
	echo "<hr>\n";
	echo "<a href='apath.php'>Pathfinder Home</a>";
	
	// to be valid a family name must be longer than 1 letter long
	function isvalid($nam) {
		if (strlen($nam) < 2) {
			return false;
		} else {
			return true;
		}
	}
	
	// Show the families
	function showfamilys() {
		//SELECT pcId, pcName FROM pfClubs ORDER BY pcName
		require 'dbinfo.php';
		$link = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		
		// Check connection
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Attempt select query execution
		$sql = "SELECT pfId, pfName FROM paFamily ORDER BY pfName";
		if($resultc = mysqli_query($link, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultc) > 0){
				$ss = "<table>\n";
				$ss .= "  <tr>\n";
				$ss .= "    <th>Family ID</th><th>Name</th>\n";
				$ss .= "  </tr>\n";
				while($rowc = mysqli_fetch_array($resultc)){
					$ss .= "  <tr>\n";
					$ss .= "    <td>" . $rowc['pfId'] . "</td><td>" . $rowc['pfName'] . "</td>\n";
					$ss .= "  </tr>\n";
				}
				$ss .= "</table>\n";
				// Close result set
				mysqli_free_result($resultc);
			} 
		}
		mysqli_close($link);
		return $ss;
	}

	// html for top of page
	function tophtml($titl) {
		$t = "<!DOCTYPE html>\n";
		$t .= "<html lang='en'>\n";
		$t .= "<head>\n";
		$t .= "<meta charset='UTF-8'>\n";
		$t .= "<title>" . $titl . "</title>\n";
		$t .= "<link rel='stylesheet' href='zpa.css'>\n";
		$t .= "</head>\n";
		$t .= "<body>\n";
		$t .= "<form action='' method='post'>\n";
		$t .= "<h2>" . $titl . "</h2>\n";
		return $t;
	}
	
	// Show the newfamly form
	function newfamily() {
		$ss = "<table>";
		$ss .= "  <tr>\n";
		$ss .= "      <td class='r'>Family Name</td>\n";
		$ss .= "      <td><input type='text' name='pfname' /></td>\n";
		$ss .= "  </tr>\n";
		$ss .= "  <tr>\n";
		$ss .= "      <td>&nbsp;</td>\n";
		$ss .= "      <td><input type='submit' value='Save Family' /></td>\n";
		$ss .= "  </tr>\n";
		$ss .= "</table>";
		
		return $ss;
		}
?>
