<?php
include 'sitedata.php';
include 'startdb.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $siteTitle1 . " " . $siteTitle2 ?></title>
		<link rel="stylesheet" type="text/css" href="chatmain.css" />
		<link rel="stylesheet" type="text/css" href="footer.css" />
		<style type="text/css">
			#rbJordan{
				background: url('images/avatars/chef-icon.png');
				background-size: cover;
				background-position: center center;
			}
			#rbMike{
				background: url('images/avatars/cop-icon.png');
				background-size: cover;
				background-position: center center;
			}
			#rbSasha{
				background: url('images/avatars/cowboy-icon.png');
				background-size: cover;
				background-position: center center;
			}
			#rbMichelle{
				background: url('images/avatars/doctor-icon.png');
				background-size: cover;
				background-position: center center;
			}
			#welcomeNav{
				background: url(<?php echo $siteBackground ?>) no-repeat;
				background-position:center center;
				background-size: cover;
				background-attachment: fixed;
			}
			<?php for($i=0; $i<count($roomName); $i++): ?>
			<?php echo '#room' . $i . " "; ?> .chatRoomIco{
				background:url(<?php echo $roomImgSmall[$i]; ?>) no-repeat;
				background-position: center center;
				background-size: cover;
			}
			<?php endfor; ?>

		</style>
	</head>
	<body>
		<div id='topNav'>
			<div id='siteTilleHolder'>
				<h1 id='siteTile'><?php echo $siteTitle1 . " <span id='st1'>" . $siteTitle2 ."</span>" ?></h1>
			</div>
			<div id='topLinksHolder'>
				<ul>
					<li>HOME</li>
					<li>ABOUT</li>
					<li>CONTACT</li>
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
		</div>
		<div id='main'>
			<div id='right-sidebar'>
				<div id='leftBar'>
					<h2>Most Recent Users</h2>
					<div id="leftBarBottom">
						<?php
							$usersResult = startDB("SELECT * FROM users ORDER BY lastDetected DESC LIMIT 0, 10");
							while($row = mysql_fetch_array($usersResult)): 
								$style = "background: url('images/avatars/". $row['Image'] . "');";
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
			</div>
			<div id='rightBar'>
				<?php for($i=0; $i<count($roomName); $i++): ?>
					<div class="chatRoomBox" id = "<?php echo 'room' . $i; ?>" onclick="window.location = 'chatroom.php?room=' + <?php echo $roomId[$i]; ?>;">
						<div class="chatRoomBoxIco">
							<div class="chatRoomIco">
								<div class="chatRoomIcoNumUsers">
									<a><?php 
									$numResults = startDB("SELECT * FROM users WHERE CurrentRoom = "."'". $roomId[$i] ."';" );
									echo mysql_num_rows($numResults);

									 ?> 
									 users online</a>
								</div>
							</div>
						</div>
						<div class="chatRoomBoxBtn">
							<h1>Join Chat Room Now</h1>
						</div>
						<div class="chatRoomBoxInfo">
							<div class="chatRoomInfo">
									<h2 class="chatRoomTitle"><?php echo $roomName[$i]; ?></h2>
									<a class="chatRoomText"><?php echo $roomDescription[$i]; ?></a>
							</div>
						</div>

					</div>
				<?php endfor; ?>
			</div>
		</div>
		<?php include 'footer.php' ?>
	</body>
</html>