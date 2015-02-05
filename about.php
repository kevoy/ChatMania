<?php
include 'sitedata.php';
include 'startdb.php';
session_start();
?>


<!DOCTYPE html>
<html>
	<head>
		<title><?php echo "About - " .$siteTitle1 . " " . $siteTitle2 ?></title>
		<link rel="stylesheet" type="text/css" href="chatmain.css" />
		<link rel="stylesheet" type="text/css" href="footer.css" />
		<script src="prototype.js"></script>
		<?php if(isset($_SESSION['username'])): ?>
		<script src="checkcall.js "type="text/javascript"></script>
		<script type="text/javascript">
		window.onload = function(){
			checkReceiveCall();

		}
		</script>
		<?php endif; ?>
		<style type="text/css">
			<?php if(isset($_SESSION['username'])): ?>
			<?php 
				$topDir = 'Images/Avatars/' ;
				if(substr($_SESSION['userImage'], 0, 4) == 'user'){
					$topDir = 'Images/UserAvatars/';
					}
			?>
			#userprofimg{
				display:block;
				width:34px;
				height:34px;
				border-radius:100%;
				border: 3px solid #ddd;
				background: url("<?php echo $topDir . $_SESSION['userImage']; ?>");
				background-size: cover;
				background-position: center center;
			}
			<?php endif; ?>
			#curUser{
				background: url("images/avatars/<?php echo $_SESSION['userImage'] ?>");
				background-size: cover;
				background-position: center center;
			}
			#welcomeNav{
				background: url(<?php echo $siteBackground ?>);
				background-position:center center;
				/*background-size: cover;*/
				background-attachment: fixed;
			}
		</style>
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
					<?php if(isset($_SESSION['username'])): ?>
					<li id='usr'><a id='userprofimg'></a>
						<ul id='usr-drop'>
							<li><a href='userprofile.php?username=<?php echo $_SESSION['username'] ?>'>MY PROFILE</a></li>
							<li><a href='userlogout.php'>LOGOUT</a></li>
						</ul>

					</li>
					<?php else: ?>
						<li><a href='userlogin.php'>LOGIN</a></li>
					<?php endif ?>
				</ul>
			</div>
		</div>
		<div id='welcomeNav'>
			<div id='welcomeText'>
				<a><?php echo "<span id='wt1'>" . $siteTitle1 . "  </span> <span id='wt2'>" . $siteTitle2 ."</span>" ?></a>
				<a id='welcomeDescription'><?php echo $siteDescription ?></a>
			</div>
		</div>
		<div id='bottomNav'>
			<a class="bottomNavText"><span class="infoNum">1</span> Select A Chatroom <span class="infoNum">2</span> Choose a Name <span class="infoNum">3</span> Start Chatting</a>
		</div>
		<div id='main'>
			<div id='right-sidebar'>
				<div id='leftBar'>
					<h2>Most Recent Users</h2>
					<div id="leftBarBottom">
						<?php
							$usersResult = startDB("SELECT * FROM users ORDER BY lastDetected DESC LIMIT 0, 10");
							while($row = mysql_fetch_array($usersResult)): 
								$topDir = 'Images/Avatars/' ;
								if(substr($row['Image'], 0, 4) == 'user'){
									$topDir = 'Images/UserAvatars/';
								}
								$style = "background: url('". $topDir. $row['Image'] . "');";
								$style .= "background-size: cover;";
								$style .= "background-position: center center;";
						?>
						<div class="recentUserBox">
							<div style="<?php echo $style; ?>" class="recentUserBoxImage">
							</div>
							<a class="recentUserBoxName"><?php echo $row['Name'] ?></a>
						</div>
						<?php endwhile; ?>
					</div>
				</div>
				<div class='widget height-auto space-top'>
					<h2>Joke Of The Day</h2>
					
					<!-- Joke-Pages.com Joke of the Day Code -->
					<script language="JavaScript">
						var jCode = '';
						document.write('<s' + 'cript src="http://www.Joke-Pages.com/scripts/joke-of-the-day-javascript.asp?width=280">');
						document.write('</' + 's' + 'cript>');
					</script>
					<script language="JavaScript">document.write(jCode);</script>
					<!--  End Joke-Pages.com Joke of the Day Code -->

				</div>
			</div>
			<div id='rightBar'>
				<div id='left-sidebar'>
					<div class='widget adBar'>
						<h2>Advertisement</h2>
						<?php if(strlen($adsv) <=1){
							echo "<img src=\"Images/adsv.png\" width=\"160\" height=\"600\" />";
						}else{
							echo $adsv;
						}

						 ?>
						
					</div>
					<div class='widget height-auto space-top'>
						<h2>Clock</h2>
						<script type="text/javascript" src="http://100widgets.com/js_data.php?id=170"></script>
					</div>
				</div>
				<div id='center-bar'>
					<div class='widget height-500 space-top'>
						<div id="content-title">
							<h1>About</h1>
							<h6>Date <?php echo date("Y-m-d") ?></h6>
						</div>
						<div id='content'>
							<p><?php  $content = startDB("SELECT * FROM settings;");
							while($row=mysql_fetch_array($content)){
								echo $row['About'];
							}
							 ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id='videoChatBar'>
			<div id='caller-img' class="recentUserBoxImage">
			</div>
			<h2 id="reject-call" onclick="rejectCall()">X</h2>
			<h4 id='caller-info'>New Video Call From<br><span id='caller-name'>User Name</span></h4>
			
		</div>
		<?php include 'footer.php' ?>
	</body>
</html>