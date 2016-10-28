<?php
	session_start();
	
	function laction() {
		if (isset($_SESSION["pmMail"])) {
			$mymail = $_SESSION["pmMail"];
			return "Logout";
		} else 
			return "Login";
	}

	function whologgedin() {
		$myname = "";
		if (isset($_SESSION["pmMail"])) {
			$myname = "Hello " . $_SESSION["pmName"] . " (" . $_SESSION["pmMail"] . ")";
			
		}		
		return $myname;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Pathfinders Home</title>
<link rel='stylesheet' href='zpa.css'>
</head>
	<body>
	<h1>Pathfinders <?php echo whologgedin(); ?></h1>
	<div class="loginbox">[ <a href='plogin.php'><?php echo laction(); ?></a> ]</div>
	<p>The Pathfinder club started in the past century as the <em>MV</em> club and the focus has always been on Missionary Volunteer Youth.</p>
	<img src="../pf/mvemblem.png" alt="Pathfinder Emblem" style="width:180px;height:188px;float:left;"} 
	<p><h4>About this site</h4>
	This is a development site. That is to say that the developers are building the way it works
	as they go. The site is intented to allow Parent(s), pathfinders or staff to register members. Ideally we 
	do not have duplicate members and do not make logic that traps users with required fields for which
	there is no possible way for a member to know what information is required to proceed.</p>
	<h4>Privacy</h4>
	<p>The information we collect (is not verified) and is as follows. Name, Email, (family/parent), password, 
	home club and last login date. We use the name to identify the member (These have to be uniquie for now 
	- we may figure out a way of using either the name or the email address as unique but we are still workng 
	on that). The email is not necessary but used for login. It's not much good for regular pathfinders as there's 
	nothing they can do if they login anyway. We are not sending emails (for now and no plans) so it's not really necessary.</p>
	<p>The family/parent field
	is intended to allow parents to manage the information of their kids and keeps multiple parents/grandparents etc. 
	associated with only their kids. The password is encrypted so even people with access to the data cannot see what a 
	password is. It is only used for authentication. It can be quite long but i only use the first hundred or so characters. 
	Last Login date is used to see if members are using this site. Working 
	on Events so we can get the number of kids that are coming to an event. Not all fields will have data for 
	each member. A members may choose to attend or not attend an event. Not every member has parents that register them. Not 
	every parent is a staff member. Parents are able to edit the spelling of their child's name. Counselors 
	are able to add pathfinders to events such as "Billy is coming to the warsaw caves campout on October 24-25 
	2016 and has paid $8.00".</p>
	<p><h4>more details ...</h4>
	This explanation is getting more and more complex and hopefully we will not get bogged down with complicated
	details but can provide a fast, easy system for the staff and the pathfinders during registration. Please keep
	in mind that this is a development site and not all of the details have been worked out yet. Our priorities are 
	safety and security and ease of use.</p>
	<p>Feel free to contact the development team if you'd like to play with this system. You can message a developer
	<a href="mailto:jt@johntoop.ca?Subject=Pathfinder Site" target="_top">by selecting this address</a> if you wish. I have 
	another job so I do not check this email very often.</p>
	<p>Of course if you see a security problem or a potential problem, I would appreciate being advised.</p>
	</div>
	<h2>Menus</h2>
	<ul class="dev">
		<li><a href="preg.php">Register new user</a></li>
		<li><a href="plogin.php">Login</a></li>
		<?php
			if (laction()=="Logout") {
				echo "<li><a href='changemypass.php'>Change Password</a></li>";
				echo "<li><a href='ped.php'>Edit Members</a></li>";
				echo "<li><a href='pfam.php'>Edit Families</a></li>";
			}
		?>
	</ul>
	<hr>
	<ul>
		<li><a href="../">Site Home</a></li>
	</ul>
	<hr>
	&nbsp;User = <?php echo $_SESSION["pmMail"]; ?><br />
	Role = <?php echo $_SESSION["pmRole"]; ?>
	</body>
</html>
