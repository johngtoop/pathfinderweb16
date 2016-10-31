<?php
	// pfam.php 	- Families list / edit / Add
	session_start();
	$role = $_SESSION['pmRole'];
	$club = $_SESSION['pmClub'];
	$tfam = "";
	if (isset($_SESSION['tfam']))
		$tfam = $_SESSION['tfam'];
	else
		$tfam = "";
	
	if (($role == 6) || ($role == 2) || ($role == 3)) {
		echo "<h2>Families</h2>";
		if (!$_POST) {
			echo tophtml("New Family");
			echo newfamily();
			echo showfamilys();
			echo selFamily($tfam) . " <input type='submit' value='refresh' src='refresh.gif' name='refresh' />";
			echo "</form></body></html>";
		} else {
		// This is posted ... lets save it 
		//echo "saving ... not!";
		// *********************************** save family info if exists ********************
		$FamilyName = trim($_POST['pfname']);
		if (isset($_POST['selFamily'])) {
			$_SESSION['tfam'] = $_POST['selFamily'];
		}

		if(isset($_POST['refresh'])) {
			echo tophtml("Edit Family");
			echo EditFamily($_POST['selFamily'],getFamilyName($_POST['selFamily']));
			
			if (isset($_POST['selFamily'])) {
				$tfam = $_POST['selFamily'];
			}
			
			echo selFamily($tfam) . " <input type='submit' value='refresh' src='refresh.gif' name='refresh' />";
			echo "pressed Refresh";
			if (isset($_POST['selFamily'])) {
				$_SESSION['tfam'] = $_POST['selFamily'];
			}
			
			echo "<pre>";
			var_dump($_POST);
			echo "</pre>";
		} else if (isset($_POST['update'])) {
			echo tophtml("Edit Family");
			updatefamilyname($_POST['pfId'], $_POST['pfname']);
			echo EditFamily($_POST['selFamily'],getFamilyName($_POST['selFamily']));
			echo selFamily($tfam) . " <input type='submit' value='refresh' src='refresh.gif' name='refresh' />";
			echo "pressed Update";
			//echo "Update familyID " . $_POST['pfId'] . " to value " . $_POST['pfname'] . " some day ...<br />";
			
			
			echo "<pre>";
			var_dump($_POST);
			echo "</pre>";		
		
		} else {
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
					// Show select for families
					echo selFamily($tfam) . " <input type='submit' value='refresh' src='refresh.gif' name='refresh' />";
				} else {
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
			}
		}
		// ***********************************************************************************
		}
	} else {
		echo "not enough security ...";
	}
	echo "<hr>\n";
	echo "<a href='apath.php'>Pathfinder Home</a>";
	
	// The family must have a name longer than 1 character in length
	function isvalid($nam) {
		if (strlen($nam) < 2) {
			return false;
		} else {
			return true;
		}
	}
	
	// Shows a table with all of the families listed
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
		
		// Show the EditFamly form
	function EditFamily($famId, $famName) {
		$ss = "<table>";
		$ss .= "  <tr>\n";
		$ss .= "      <td class='r'>Family Name</td>\n";
		$ss .= "      <td><input type='text' name='pfname' value='" . $famName . "' /></td>\n";
		$ss .= "  </tr>\n";
		$ss .= "  <tr>\n";
		$ss .= "      <td><input type='hidden' name='pfId' value='$famId' ></td>\n";
		$ss .= "      <td><input type='submit' value='update' src='update.gif' name='update' /></td>\n";
		$ss .= "  </tr>\n";
		$ss .= "</table>";
	
		return $ss;
	}
		
	// Select (dropdown to all families)
	function selFamily($dftfam) {
		//SELECT pcId, pcName FROM pfClubs ORDER BY pcName
		require 'dbinfo.php';
		$linkc = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
			
		// Check connection
		if($linkc === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Attempt select query execution
		$sql = "SELECT pfId, pfName FROM paFamily ORDER BY pfName";
		if($resultc = mysqli_query($linkc, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultc) > 0){
				$ss = "<select name='selFamily'>\n";
				while($rowc = mysqli_fetch_array($resultc)){
					if ($rowc['pfId']===$dftfam) {
						$ss .= "<option selected value='" . $rowc['pfId'] . "'>" . $rowc['pfName'] . "</option>\n";
					} else {
						$ss .= "<option value='" . $rowc['pfId'] . "'>" . $rowc['pfName'] . "</option>\n";
					}
				}
				$ss .= "</select>\n";
				// Close result set
				mysqli_free_result($resultc);
			} 
		}
		mysqli_close($linkc);
		return $ss;
	}
	
	// Select (dropdown to all families)
	function getFamilyName($fam) {
		//SELECT pcId, pcName FROM pfClubs ORDER BY pcName
		require 'dbinfo.php';
		$linkc = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
			
		// Check connection
		if($linkc === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Attempt select query execution
		$sql = "SELECT pfName FROM paFamily WHERE pfId='$fam' ";
		if($resultc = mysqli_query($linkc, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultc) > 0){
				while($rowc = mysqli_fetch_array($resultc)){
					$ss = $rowc['pfName'];
				}
				// Close result set
				mysqli_free_result($resultc);
			} 
		}
		mysqli_close($linkc);
		return $ss;
	}
	
	// Update the spelling of the Family Name
	function updatefamilyname($famid,$newname) {
		//
		require 'dbinfo.php';
		$linku = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		$sqlu = "UPDATE paFamily SET pfName = '$newname' WHERE pfId = " . $famid;
		if (mysqli_query($linku,$sqlu))
			return true;
		else
			return false;
		mysqli_close($linku);
	}
?>