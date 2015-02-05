<?php
include 'sitedata.php';
include 'startdb.php';
$roomNum = $_REQUEST['room'];
$roomIdIndex = array_search($roomNum, $roomId);
session_start();
if(mysql_num_rows(startDB("SELECT * FROM chatrooms WHERE id='$roomNum';"))<1){
	header('Location: index.php');
}else{
	if(isset($_SESSION['username'])){
		header('Location: chat.php?room=' . $roomNum);
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $roomName[$roomIdIndex] . " - " .$siteTitle1 . " " . $siteTitle2 ?></title>
		<link rel="stylesheet" type="text/css" href="chatmain.css" />
		<link rel="stylesheet" type="text/css" href="footer.css" />
		<script src="adduser.js" type="text/javascript"></script>
		<script src="prototype.js"></script>
		<script type="text/javascript">
			var roomNum = <?php echo $roomNum ?>;
		</script>
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
			#newUser{
				background: url('Images/Avatars/cop-icon.png');
				background-size: cover;
				background-position: center center;
			}
			#newPassword{
				background: url('Images/1406261375_settings02.png');
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
				background: url(<?php echo $roomImgLarge[$roomIdIndex] ?>) no-repeat;
				background-position:center center;
				background-size: cover;
				
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
					<?php if(isset($_SESSION['username'])){
						echo "<li><a href='userlogout.php'>LOGOUT</a></li>";
					}else{
						echo "<li><a href='userlogin.php'>LOGIN</a></li>";
					}
					?>
				</ul>
			</div>
		</div>
		<div id='welcomeNav'>
			<div id='welcomeRight'>
				<h2 id='wrTitle'><?php echo $roomName[$roomIdIndex]; ?></h2>
				<a id="wrText"><?php echo $roomDescription[$roomIdIndex]; ?><br><span id='dots'>...</span></a>
			</div>
		</div>
		<div id='bottomNav'>
			<a class="bottomNavText"><span class="infoNum">1</span> Select A Chatroom <span class="infoNum">2</span> Choose a Name <span class="infoNum">3</span> Start Chatting</a>
		
		</div>
		<div id='main'>
			<div id='right-sidebar'>
				<div id='leftBar'>
					<h2>Users Online</h2>
					<div id="leftBarBottom" class='maxheight'>
						<?php
						$min =date('i') - 5;
						if($min>0){
							$recTime = date('Y-m-d H:'.$min.':s');
						}else{
							$recTime = date('Y-m-d H:0:0');
						}
						
						//echo date('Y-m-d H:i:s') ." = ".$recTime; 
							$usersResult = startDB("SELECT * FROM users WHERE CurrentRoom = $roomNum and lastDetected > '$recTime' ORDER BY lastDetected DESC");
							if(mysql_num_rows($usersResult)<1){
								echo "<h4 style='display: block;color: #838080;text-align: center;font-family: Courier;padding: 5px 5px 5px 5px;border-radius: 10px;margin: 0px 15px 0px 15px;border: 1px solid #838080;'>No Users In This Chatroom</h4>";
							}
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
			</div>
			<div id='rightBar'>
				<div id='formInfo'>
					<h2 id='formName'>Enter Your Name and Start Chatting</h2>
					<div class='formBox'>
						<div id="newUser" class="recentUserBoxImage">
						</div>
						<input type='text' id='newUserName' value='ENTER YOUR NAME' onclick='if(this.value=="ENTER YOUR NAME"){this.value=""};' onblur='if(this.value==""){this.value="ENTER YOUR NAME"}' >
					</div>
					<div class='formBox'>
						<div id="newPassword" class="recentUserBoxImage">
						</div>
						<input type='password' id='newUserPassword' >
					</div>
					<div class='formBox'>
						<a class='formText'>I AM A:</a>
						<input class='radiobox' type='radio' value='male' id='male' name='sex' checked ><a class='radioText'>MALE</a>
						<input class='radiobox' type='radio' value='female' id='female' name='sex' ><a class='radioText'>FEMALE</a>
					</div>
					<h2 id='startBtn'>START CHATTING</h2> 
				</div>
				<div id='logInfo'>
					<h2 id='logbtn' onclick="window.location = 'userlogin.php';" >Login</h2>
				</div>
			</div>
		</div>
		<?php include 'footer.php' ?>
		<div id='blackbox'>
			<div id='upload-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Upload Image</a>
					<a class='edit-close' id='close-upload-edit'>X</a>
				</div>
				<form action = 'uploadavatar.php' method="post" enctype="multipart/form-data">
					<input type='hidden' name='room' value='<?php echo $roomNum ;?>' />
				<div class='edit-box-body' id='edit-upload-body'>
					
						<div class='upd-div'>
							<input type='radio' id='up-rnd' name='up-img' value='rnd' checked /> <a>Random Avatar</a>
						</div>
						<div class='upd-div'>
							<h2 class='upd-or'>OR</h2>
						</div>
						<div class='upd-div'>
							<input type='radio' id='up-img' name='up-img' value='user' /> <a>Upload Avatar</a>
						</div>
						<div class='upd-imgpreview-div'>
							<div id='upd-invisible'>
								<input type='file' id='file' name='file'  />
							</div>
						</div>
				</div>
				<div class='upd-div'>
					<input type='submit' id='up-pro' name='submit' value='Proceed' />
				</div>
				</form>
			</div>
		</div>
	</body>
</html>