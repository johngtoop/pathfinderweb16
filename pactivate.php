<?php
	// pactivate.php	- php Activate members (make active)
	session_start();
	include "pcommon.php";

	//echo "pactivate.php";
		
	// List top inactive user and offer to either make active or delete
	$role = "";
	if (isset($_SESSION['pmRole'])) 
		$role = $_SESSION["pmRole"];
	
	if (isset($_POST['pmId'])) {
		$id = $_POST['pmId'];
		if (isset($_POST['activate'])) {
			if ($_POST['activate']=='Activate') {
				// set the active bit to 1
				updatememberactive($id);
			}
		}
		if (isset($_POST['delete'])) {
			IF ($_POST['delete']=='delete') {
				// delete the user completely
				deletemember($id);
			}			
		}		
	}

	
	
	if (canedituser($role)) {
		echo tophtml("Inactive members");
		if (!isset($_POST['pmId'])) {
			//echo "<br />Post";
			echo showinactive1();
			//echo "<pre>";
			//var_dump($_POST);
			//echo "</pre>";	
		} else {
			echo "Post!";
			echo showinactive1();
						
			//echo "<pre>";
			//var_dump($_POST);
			//echo "</pre>";	
		}
		echo "<br /><a href='apath.php'>Pathfinder Home</a>";
		echo "</form></body></html>";
		//echo "Can edit";
	} else {
		echo tophtml("inactivate Members");
		echo "Your user rights do not allow you to edit a member's Active flag.";
		echo "</form></body></html>";			
	}
		
	
	
	
	
	
	// Shows a table with all of the families listed
	function showinactive1() {
		//SELECT pcId, pcName FROM pfClubs ORDER BY pcName
		require 'dbinfo.php';
		$link = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		$ss = "";
		// Check connection
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Attempt select query execution
		$sql = "SELECT pmId, pmName, pmMail FROM paMembrs WHERE pmActive = 0 LIMIT 1";
		if($resultc = mysqli_query($link, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultc) > 0){
				$ss = "<table>\n";
				$ss .= "  <tr>\n";
				$ss .= "    <th>Member</th><th>Action</th>\n";
				$ss .= "  </tr>\n";
				while($rowc = mysqli_fetch_array($resultc)){
					$ss .= "  <tr>\n";
					$ss .= "<td><input type='hidden' name='pmId' value='" . $rowc['pmId'] . "' />";
					$ss .= " " . $rowc['pmName'] . " " . $rowc['pmMail'] . "</td><td><input type='submit' value='Activate' src='iactivate.gif' name='activate' /> <input type='submit' value='delete' src='idelete.gif' name='delete' /></td>\n";
					$ss .= "  </tr>\n";
				}
				$ss .= "</table>\n";
				// Close result set
				mysqli_free_result($resultc);
			} else {
				$ss = "<br />No inactive members here<br />";
			}
		}
		mysqli_close($link);
		return $ss;
	}
	
	// Update the member to Active = 1
	function updatememberactive($usrid) {
		//
		require 'dbinfo.php';
		$linku = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		$sqlu = "UPDATE paMembrs SET pmActive = 1 WHERE pmId = " . $usrid;
		if (mysqli_query($linku,$sqlu))
			return true;
		else
			return false;
		mysqli_close($linku);
	}
	
	// Update the member to Active = 1
	function deletemember($usrid) {
		require 'dbinfo.php';
		$linku = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		$sqlu = "DELETE FROM paMembrs WHERE pmId = " . $usrid;
		if (mysqli_query($linku,$sqlu))
			return true;
		else
			return false;
		mysqli_close($linku);
	}
	
	?>