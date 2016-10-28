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
			echo "</form></body></html>";
		} else {
		// This is posted ... lets save it 
		echo "saving ... not!";
		}
	} else {
		echo "not enough security ...";
	}
	echo "<hr>\n";
	echo "<a href='apath.php'>Pathfinder Home</a>";
	
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
