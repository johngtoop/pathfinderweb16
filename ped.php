<?php
	// ped.php   - Edit Members
	session_start();
	$role = $_SESSION['pmRole'];
	$club = $_SESSION['pmClub'];
	$name = "";
	$email = "";
	$ssql = ".";
	$active = "";
	$trole = "0";
	$tfamily = 99;
	echo "<br>role = " . $role;
	echo "<br>Club = " . $club;

	if (($role == 6) || ($role == 2) || ($role == 3)) {
		echo tophtml("Edit Members");
		echo "<br /><a href='apath.php'>Pathfinder Home</a>";
		echo "</form></body></html>";
	} else {
		echo "Sorry .. not enough permissions.<br />";
		echo "<a href='../pf.php'>Home</a>";
	}

	function tophtml($titl) {
		$t = "<!DOCTYPE html>";
		$t = $t . "<html lang='en'>";
		$t = $t . "<head>";
		$t = $t . "<meta charset='UTF-8'>";
		$t = $t . "<title>" . $titl . "</title>";
		$t = $t . "<link rel='stylesheet' href='zpa.css'>";
		$t = $t . "</head>";
		$t = $t . "<body>";
		$t = $t . "<form action='' method='post'>";
		$t = $t . "<h2>" . $titl . "</h2>";
		return $t;
	}
?>