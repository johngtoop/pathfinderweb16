# pathfinderweb16
Pathfinders Web system for use with PHP, MySql. You can put all of these files into a subdirectory and the paths should all assume that the files are in the same directory. The php files that access the MySl database use the include dbinfo.php which is a file that looks like this:
<?php
	$dbserver = "servernameOrIP";
	$dbuser   = "username";
	$dbpass   = "UsErPasS";
	$database = "database_name";
?>
plogin.php = file to login to the system. It creates a session object with the user information if the password is entered correctly. We are using MD5 encryption so the passwords cannot be seen. If someone needs a password it must be reset to a known value. The file tables.sql describes the sql structure of the tables in use.
