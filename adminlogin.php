<?php
include 'sitedata.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Admin Login</title>
		<link rel="stylesheet" type="text/css" href="chatmain.css" />
		<link rel="stylesheet" type="text/css" href="footer.css" />
	</head>
	<body>
		<div id='topNav'>
			<div id='siteTilleHolder'>
				<h1 id='siteTile'><?php echo $siteTitle1 . " <span id='st1'>" . $siteTitle2 ."</span>" ?></h1>
			</div>
			<div id='topLinksHolder'>
				<ul>
					<li><a href='index.php'>HOME</a></li>
					<li><a href='about.php'>ABOUT</a></li>
					<li><a href='contact.php'>CONTACT</a></li>
				</ul>
			</div>
		</div>
		<div id="adminLoginMain">
			<div id="adminLoginBox">
				<h2>Admin Login</h2>
				<form method='post' action='adminpanel.php'>
				<div class="adminTxtHolder">
					<a>Username</a><input type='text' id='adminName' name='adminName' >
				</div>
				<div class="adminTxtHolder">
					<a>Password</a><input type='password' id='adminPassword' name='adminPassword' >
				</div>
				<input type='submit' id='adminSubmit' value='Sign In' >
			</form>
			</div>
		</div>
		<?php include 'footer.php' ?>
	</body>

</html>