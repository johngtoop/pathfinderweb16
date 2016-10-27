<?php
	// ped.php   - Edit Members

	echo tophtml("Edit Members");
	echo "</form></body></html>";
	
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
		$t = $t . "<h2>Login to Pathfinder site</h2>";
		return $t;
?>