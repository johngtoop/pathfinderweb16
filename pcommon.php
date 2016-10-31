<?php
	// pcommon.php

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
	
	
	// return a true or false if the provided user can edit members
	function canedituser($rol) {
		require 'dbinfo.php';
		$linkc = mysqli_connect($dbserver, $dbuser, $dbpass, $database);
		// Check connection
		if($linkc === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}		 
		// Query to find out if the $who can edit users
		$sql = "SELECT prEditUsers FROM paRoles WHERE prId = $rol ";
		// Attempt select query execution
		if($resultc = mysqli_query($linkc, $sql)){
			$ss = "";
			if(mysqli_num_rows($resultc) > 0){
				while($rowc = mysqli_fetch_array($resultc)){
					$ss = $rowc['prEditUsers'];
				}
				mysqli_free_result($resultc);  // Close result set
			} 
		}
		mysqli_close($linkc);  // close connection
		return $ss;
	}
	

?>