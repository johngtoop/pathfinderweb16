 # pathfinderweb16
Pathfinders Web system for use with PHP, MySql. You can put all of these files into a subdirectory and the paths should all assume that the files are in the same directory. The php files that access the MySl database use the include dbinfo.php which is a file that looks like this:
<?php
	$dbserver = "servernameOrIP";
	$dbuser   = "username";
	$dbpass   = "UsErPasS";
	$database = "database_name";
?>
plogin.php = file to login to the system. It creates a session object with the user information if the password is entered correctly. We are using MD5 encryption so the passwords cannot be seen. If someone needs a password it must be reset to a known value. The file tables.sql describes the sql structure of the tables in use.
Need routine to update password that sets the password date to today. Need to give this some thought. I somehow need to set a parameter for the passwords to be changed once they are at least "some age" - say 90 days. Need a routine changemypass.php to set the new password. A routine ped.php was started to edit a pathfinder. I need to first compare the security level of the logged in user to determine if they are allowed to edit other members or what - there's a complicated security model so I need to check it.

Next we need to fix the ped.php (Member edit) routine. It was just done badly a few weeks ago and I was focused on pfam.php to list the families.
The preg is a bit odd - I think it requires a password but the database does not require it. The only required field is the id. The password is not really a security thing.
There is a "changemypass.php" that can change the password for a "me". Not intended to work for pathfinders. The edit should allow editng the password.
The MemberTable (paMembrs) is pmId, pmClub, pmName, pmMail, pmActive, pmRole, pmPwd, pmPwdDt, pmFamily, pmLastLogin
The Clubs table (paClubs) is pcId, pcName, pcAddress
The Family table (paFamily) is pfId, pfName
The Roles table (paRoles) is prId, prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers

I do not see a "unit" for a counselor to be in charge of. If he can only edit the campers in his unit, who is in his unit.

The Units needs to have a Club, Name, a grade level, an Id, what about sorting ...?

A event has a club and a date and a description and what else?
