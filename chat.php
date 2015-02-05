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
		$_SESSION['chatroom'] = $roomNum;
		startDB("UPDATE users SET CurrentRoom = '$roomNum' WHERE Name = " ."'".esc($_SESSION['username']) ."'" );
	}else{
		header('Location: chatroom.php?room=' . $roomNum);
	}
}


?>


<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $roomName[$roomIdIndex] . " - " .$siteTitle1 . " " . $siteTitle2 ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="chatmain.css" />
		<link rel="stylesheet" type="text/css" href="footer.css" />
		<script src="prototype.js"></script>
		<script src="chat.js "type="text/javascript"></script>
		<script type="text/javascript">
			var roomId = <?php echo $roomNum ?>
		</script>
		<style type="text/css">
			<?php 
				$topDir = 'Images/Avatars/' ;
				if(substr($_SESSION['userImage'], 0, 4) == 'user'){
					$topDir = 'Images/UserAvatars/';
					}
			?>
			#curUser{
					
				background: url("<?php echo $topDir . $_SESSION['userImage']; ?>");
				background-size: cover;
				background-position: center center;
			}
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
			#chat-back{
				background: url("<?php echo $roomImgLarge[$roomIdIndex]; ?>") no-repeat;
				background-size: cover;
				background-position: center center;
				opacity:0.8;
				
			}
			#chat-desc{
				text-align: left;
				font-family: Arial;
				color: #a3a2a2;
				padding: 10px 10px 20px 10px;
			}
			#arrow{
				display: block;
				
				width: 0px;
				height: 0px;
				border-bottom: 125px solid  #a3a2a2;
				border-left: 2px solid  #a3a2a2;
				border-right:2px solid  #a3a2a2;
				border-top: 0px solid  #a3a2a2;
				
				
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
							<li><a onclick='clearTimeout(timer2); clearTimeout(timer3); logout=true;'>LOGOUT</a></li>
						</ul>

					</li>
					<?php else: ?>
						<li><a href='userlogin.php'>LOGIN</a></li>
					<?php endif ?>
				</ul>
			</div>
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
							<a class="recentUserBoxName fix-t-width"><?php echo $row['Name'] . " [". $row['Sex']."]" ?></a>
							<?php if($_SESSION['username'] != $row['Name']): ?>
							<div class='video-call' alt='Video Call' onclick="videoCall(this, '<?php echo $row['Name'] ?>', '<?php echo $_SESSION['username']; ?>')"></div>
							<div class='user-prof' alt='Video Call' onclick="window.location = 'userprofile.php?username=<?php echo $row['Name'] ?>';"></div>
							
							<?php endif ;?>
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
					<div id='chatBar'>
						<div id='chatBarInner'>
							<div id='loadimg'></div>
						</div>
						<div id='emo-bar'>
							<?php
								$files = scandir('Images/Emoticons');
								foreach($files as $fil):
									if(strpos($fil, ".png")!=FALSE):
							?>
							<div class='emo-img' onclick ="addEmoticon('<?php echo '[emo:'. str_replace(".png","",$fil) .']'; ?>');"style="background: url('Images/Emoticons/<?php echo $fil; ?>') no-repeat; background-size:cover;background-position:center center;">
							</div>
							<?php endif; 
								endforeach; 
								?>
						</div>
						<div id='chatBox'>
							<div id="curUser" class="recentUserBoxImage">
							</div>
							<div id='attachBtn'></div>
							<a id='postBtn'>Post</a>
							<div id='chatTxtHolder'>
							<input type='text' id='chatTxt' value='ENTER TEXT' onclick='if(this.value=="ENTER TEXT"){this.value=""};' onblur='if(this.value==""){this.value="ENTER TEXT"}' >
							</div>
							<div id='emo-btn'>
							</div>
						</div>
					</div>
					<div id='chat-back' class='widget height-200 space-top'>
				
					</div>
					
					<div id='chat-desc' class='widget height-auto '>
						<h2><?php echo $roomName[$roomIdIndex]; ?></h2>
						<?php echo $roomDescription[$roomIdIndex]; ?>
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
		<div id='blackbox'>
			<div id='upload-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Upload File[Max Size: 5MB]</a>
					<a class='edit-close' id='close-upload-edit'>X</a>
				</div>
				<div class='edit-box-body' id='edit-upload-body'>
					<input type='file' name='chatFile' id='chatFile' />
					<a id='upStatus'>File Uploaded Successfully</a>
					<div id='uploadBtn'>
						<a id='upBtn'>upload</a>
						<div id='anim_img'></div>
						<a id='upFName'>File Name</a>
					</div>
					<textarea type='text' name='upTxt' id='upTxt'></textarea>
				</div>
				<div class='upd-div'>
					<input type='submit' id='up-user' name='submit' value='Send' />
				</div>
			</div>
		</div>
		<?php include 'footer.php' ?>
	</body>
</html>