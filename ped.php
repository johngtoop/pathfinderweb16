<?php
	// ped.php   - Edit Members
	session_start();
	$role = $_SESSION['pmRole'];
	if (isset($_SESSION['pmClubf'])) 
		$club = $_SESSION['pmClubf'];
	else
		$club = "";
	$name = "";
	$email = "";
	$ssql = "+";
	$active = "";
	$trole = "0";
	
	$tpm = "";
	if (isset($_POST['members']))
		$tpm = $_POST['members'];              // temp member
	else
		$tpm = "0";
	
	
	$tfamily = 99;          // temp family
	echo "<br>role = " . $role;
	echo "<br>Club = " . $club;

	if (($role == 6) || ($role == 2) || ($role == 3)) {
		echo tophtml("Edit Members");
		if (!$_POST) {
			echo selectclub($club) . " " . selectpm($tpm) . " <input type='submit' value='refresh' src='refresh.gif' name='refresh' />\n";
			echo "<input type='submit' />";
		} else {
			if ($_POST['refresh']) {
				$ssql = "refresh pressed. " . $_POST['members'];
				$tpm = $_POST['members'];
				// Save the fields back to pmMembrs ...
				echo showmember($tpm);
			} else {
				$ssql = "refresh not pressed";
			}
			echo selectclub($club) . " " . selectpm($tpm) . " <input type='submit' value='refresh' src='refresh.gif' name='refresh' />\n";
			echo "<input type='submit' />";
		}
		echo "<br /><a href='apath.php'>Pathfinder Home</a>\n";
		echo "<br />ssql=" . $ssql;
		echo "</form></body></html>";
	} else {
		echo "Sorry .. not enough permissions.<br />";
		echo "<a href='../pf.php'>Home</a>";
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
	
	// Select (dropdown to all clubs)
	function selectclub($dftclub) {
		//SELECT pcId, pcName FROM pfClubs ORDER BY pcName
		require 'dbinfo.php';
		$linkc = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		
		// Check connection
		if($linkc === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Attempt select query execution
		$sql = "SELECT pcId, pcName FROM paClubs ORDER BY pcName";
		if($resultc = mysqli_query($linkc, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultc) > 0){
				$ss = "<select name='pmClubf'>\n";
				while($rowc = mysqli_fetch_array($resultc)){
					if ($rowc['pcId']===$dftclub) {
						$ss .= "<option selected value='" . $rowc['pcId'] . "'>" . $rowc['pcName'] . "</option>\n";
					} else {
						$ss .= "<option value='" . $rowc['pcId'] . "'>" . $rowc['pcName'] . "</option>\n";
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
	
		// Select (dropdown to all clubs)
	function selectclubm($dftclub) {
		//SELECT pcId, pcName FROM pfClubs ORDER BY pcName
		require 'dbinfo.php';
		$linkc = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		
		// Check connection
		if($linkc === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Attempt select query execution
		$sql = "SELECT pcId, pcName FROM paClubs ORDER BY pcName";
		if($resultc = mysqli_query($linkc, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultc) > 0){
				$ss = "<select name='pmClub'>\n";
				while($rowc = mysqli_fetch_array($resultc)){
					if ($rowc['pcId']===$dftclub) {
						$ss .= "<option selected value='" . $rowc['pcId'] . "'>" . $rowc['pcName'] . "</option>\n";
					} else {
						$ss .= "<option value='" . $rowc['pcId'] . "'>" . $rowc['pcName'] . "</option>\n";
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
	
	// Select pathfinder member
	function selectpm($pm) {
		
		require 'dbinfo.php';
		$linkm = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		
		// Check connection
		if($linkm === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Attempt select query execution
		$sql = "SELECT pmId, pmName, pmMail FROM paMembrs ORDER BY UPPER(pmName)";
		if($resultm = mysqli_query($linkm, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultm) > 0){
				$ss .= "<select name='members'>\n";
				while($rowm = mysqli_fetch_array($resultm)){
					if ($rowm['pmId']==$pm)
						$ss .= "<option value='" . $rowm['pmId'] . "' selected>" . $rowm['pmName'] . " " . $rowm['pmMail'] . "</option>\n";
					else
						$ss .= "<option value='" . $rowm['pmId'] . "'>" . $rowm['pmName'] . " " . $rowm['pmMail'] . "</option>\n";
				}
				$ss .= "</select>\n";
				mysqli_free_result($resultm); 		// Close result set
			} 
		}		
		mysqli_close($linkm); // Close connection
		return $ss;
	}
	
	// Shows a table with all of the families listed
	function showmember($pm) {
		//SELECT pcId, pcName FROM pfClubs ORDER BY pcName
		require 'dbinfo.php';
		$link = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		
		// Check connection
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Attempt select query execution
		$sql = "SELECT pmClub, pmName, pmUnit, pmMail, pmActive, pmRole, pmFamily FROM `pamembrs` WHERE pmId = $pm ";
		if($resultc = mysqli_query($link, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultc) > 0){
				$ss = "<table>\n";
				$ss .= "  <tr>\n";
				$ss .= "    <th>ID</th><th>Club</th><th>Name</th><th>Unit</th><th>Mail</th><th>Active</th><th>Role</th><th>Family</th>\n";
				$ss .= "  </tr>\n";
				while($rowc = mysqli_fetch_array($resultc)){
					$ss .= "  <tr>\n";
					$ss .= "    <td>" . $pm . "<input type='hidden' name='pmId' value ='" . $pm . "' ></td>\n";
					$ss .= "    <td>" . selectclubm($rowc['pmClub']) . "</td>\n";
					$ss .= "    <td><input type='text' name='pmName' value='" . $rowc['pmName'] . "' ></td>\n";
					$ss .= "    <td><input type='text' name='pmUnit' value='" . $rowc['pmUnit'] . "' ></td>\n";
					$ss .= "    <td><input type='text' name='pmMail' value='" . $rowc['pmMail'] . "' ></td>\n";
					$ss .= "    <td><input type='text' name='pmActive' value='" . $rowc['pmActive'] . "' ></td>\n";
					$ss .= "    <td><input type='text' name='pmRole' value='" . $rowc['pmRole'] . "' ></td>\n";
					$ss .= "    <td><input type='text' name='pmFamily' value='" . $rowc['pmFamily'] . "' ></td>\n";
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
?>