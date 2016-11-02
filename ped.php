<?php
	// ped.php   - Edit Members
	session_start();
	require 'pcommon.php';                                 // Common procedures
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
			if (isset($_POST['refresh'])) {
				$ssql = "refresh pressed. " . $_POST['members'];
				$tpm = $_POST['members'];
				// Save the fields back to pmMembrs ...
				// $_POST['pmId']
				// $_POST[]
				// $_POST[]
				// $_POST[]
				// $_POST[]
				// $_POST[]
				// $_POST[]
				// $_POST[]
				// $_POST[]
				echo "<br>tpm=" . $tpm . "<br>";
				echo showmember($tpm);
			} else {
				$ssql = "refresh not pressed";
			}
			echo selectclub($club) . " " . selectpm($tpm) . " <input type='submit' value='refresh' src='refresh.gif' name='refresh' />\n";
			echo "<input type='submit' />";
			// ********************** dump variables *******
			echo "<pre>";
			var_dump($_POST);
			echo "</pre>";
			// ********************** dump variables *******
		}
		echo "<br /><a href='apath.php'>Pathfinder Home</a>\n";
		echo "<br />ssql=" . $ssql;
		echo "</form></body></html>";
	} else {
		echo "Sorry .. not enough permissions.<br />";
		echo "<a href='../pf.php'>Home</a>";
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
		$ss = "";
		require 'dbinfo.php';
		$link = mysqli_connect($dbserver, $dbuser, $dbpass, $database);		
		if($link === false)                                             		                                       // Check connection
			die("ERROR: Could not connect. " . mysqli_connect_error());
		$sql = "SELECT pmClub, pmName, pmUnit, pmMail, pmActive, pmRole, pmFamily FROM `paMembrs` WHERE pmId = $pm ";  // Attempt select query execution
		if($resultc = mysqli_query($link, $sql)){
			if(mysqli_num_rows($resultc) > 0){
				$ss = "<table>\n";
				while($rowc = mysqli_fetch_array($resultc)){
					$ss .= "    <tr><td class='r'>ID:</td><td>" . $pm . "<input type='hidden' name='pmId' value ='" . $pm . "' ></td></tr>\n";
					$ss .= "    <tr><td class='r'>Club:</td><td>" . selectclubm($rowc['pmClub']) . "</td></tr>\n";
					$ss .= "    <tr><td class='r'>Name:</td><td><input type='text' name='pmName' value='" . $rowc['pmName'] . "' ></td></tr>\n";
					$ss .= "    <tr><td class='r'>Unit:</td><td><input type='text' name='pmUnit' value='" . $rowc['pmUnit'] . "' ></td></tr>\n";
					$ss .= "    <tr><td class='r'>Mail:</td><td><input type='text' name='pmMail' value='" . $rowc['pmMail'] . "' ></td></tr>\n";
					$ss .= "    <tr><td class='r'>Active:</td><td><input type='text' name='pmActive' value='" . $rowc['pmActive'] . "' ></td></tr>\n";
					$ss .= "    <tr><td class='r'>Role:</td><td><input type='text' name='pmRole' value='" . $rowc['pmRole'] . "' ></td></tr>\n";
					$ss .= "    <tr><td class='r'>Family:</td><td><input type='text' name='pmFamily' value='" . $rowc['pmFamily'] . "' ></td></tr>\n";
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