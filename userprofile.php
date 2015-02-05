<?php
include 'sitedata.php';
include 'startdb.php';
session_start();
$presUser = FALSE;
if(isset($_SESSION['username']) && isset($_REQUEST['username'])){
	if($_REQUEST['username'] == $_SESSION['username']){
		$presUser = TRUE;
	}
	
}else{
	header('Location: index.php');
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $siteTitle1 . " " . $siteTitle2 ?></title>
		<link rel="stylesheet" type="text/css" href="chatmain.css" />
		<link rel="stylesheet" type="text/css" href="footer.css" />
		<script src="prototype.js"></script>
		<script type="text/javascript" src="userprofile.js"></script>
		<?php if(isset($_SESSION['username'])): ?>
		<script src="checkcall.js "type="text/javascript"></script>
		<?php endif; ?>
		<script type="text/javascript">
		var user2 = "<?php echo $_REQUEST['username'] ?>";
		</script>
		<style type="text/css">
			<?php 
				$topDir = 'Images/Avatars/' ;
				if(substr($_SESSION['userImage'], 0, 4) == 'user'){
					$topDir = 'Images/UserAvatars/';
					}
			?>
			<?php
				$imgResult = startDB("SELECT * FROM users WHERE Name = '" .$_REQUEST['username'] . "'");
				$imgRow = mysql_fetch_array($imgResult);
				$topDir2 = 'Images/Avatars/' ;
				if(substr($imgRow['Image'], 0, 4) == 'user'){
					$topDir2 = 'Images/UserAvatars/';
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
			#user-profile-img{
				display: block;
				position:absolute;
				width:100px;
				height:100px;
				top:150px;
				left:50%;
				margin-left:-50px;
				border:3px solid white;
				border-radius:100%;
				background-color:#C0AFAF;
				background-image: url("<?php echo $topDir2 . $imgRow['Image']; ?>");
				background-size: cover;
				background-position: center center;
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
		<div id='main'>
			<div id='profile-holder'>
				<div id='profile-back-img'>
				</div>
				<div id='profile-main'>
					<?php
						$userResult = startDB("SELECT * FROM users JOIN chatrooms WHERE users.CurrentRoom = id and users.Name = '" .$_REQUEST['username'] . "'");
						$userRow = mysql_fetch_array($userResult);
						$tm = date('Y-m-d H:i:s');
						$tm2 = $userRow['lastDetected'];
						$time_diff = strtotime($tm) - strtotime($tm2);
						$numDays="Today";
						if($time_diff>86400 && $time_diff<172800){
							$numDays="Yesterday";

						}else if($time_diff>172800){
							$numDays=floor($time_diff/86400). " Days ago";
							
						}
					?>
					<h2 id='user-profile-name'><?php echo $_REQUEST['username'];?></h2>
					<h3 id='user-profile-sex'>Sex: <?php echo $userRow['Sex'];?></h3>
					<h3 id='user-profile-status'>Status: <?php if($time_diff<300){echo "Online";} else {echo "Offline"; }?></h3>
					<h3 id='user-profile-access'>Last Access: <?php  echo $numDays;?></h3>
					<h3 id='user-profile-room'>Last Chat Room: <?php echo $userRow['Name'];?></h3>
					<?php if($presUser == TRUE): ?>
					<div id='myfiles-pane'>
						<div class="top-pane-bar">
						</div>
						<h2 class='fileheader'>My Files</h2>
						<table id='filetb'>
							<?php $res = startDB("SELECT * FROM userfiles WHERE User = '". $_SESSION['username']."'");
							if(mysql_num_rows($res)<1){
								echo "<h4 class='nof'>No Files</h4>";
							}
							$num=1;
							while($row = mysql_fetch_array($res)): ?>
							<tr>
								<td style='text-align:left; padding-left:30px;'><a class='filename' ><span class='file-count'><?php echo $num."</span>". $row['Name'] ?><a></td>
								<td><a class='filebtn' onclick='shareFile("<?php echo $row['Name'] ?>")'>Share<a></td>
								<td><a class='filebtn-delete' onclick='deleteFile("<?php echo $row['Name'] ?>", "<?php echo $row['User'] ?>")'>Delete<a></td>
							</tr>
							<?php $num+=1;?>
						<?php endwhile; ?>
						</table>
					</div>
					<div id='up-bt' onclick='showUploadPane();'>Upload File</div>
					<div id='sharefiles-pane'>
						<div class="top-pane-bar">
						</div>
						<h2 class='fileheader'>Files Shared With Me</h2>
						<table id='filetb2'>
							<?php $res2 = startDB("SELECT * FROM userfiles WHERE Receiver LIKE '%;". $_SESSION['username']."%'");
							if(mysql_num_rows($res2)<1){
								echo "<h4 class='nof'>No Files</h4>";
							}
							$num=1;
							while($row = mysql_fetch_array($res2)): 
								$names=explode(";", $row['Receiver']);
								if(in_array($_SESSION['username'], $names)):
								?>
								<tr>
									<td style='text-align:left; padding-left:30px;'><a class='filename' ><span class='file-count'><?php echo $num."</span>". $row['Name'] ?><a></td>
									<td><a class='filebtn' onclick="window.location='<?php echo "UserFiles/". $row['Name'] ?>'">Download<a></td>
									
								</tr>
							<?php $num+=1;?>
							<?php endif; ?>
							<?php endwhile; ?>
						</table>
					</div>
					<?php else: ?>
					<div id='user-connect-bar'>
						<h2 id='user-share-btn' onclick='showSelectPane();'>Share File</h2>
						<h2 id='user-vidcall-btn' onclick="videoCall(this, '<?php echo $_REQUEST['username'] ?>', '<?php echo $_SESSION['username']; ?>')">Video Call</h2>
					</div>

					<?php endif; ?>
				</div>
				<div id='user-profile-img'>
				</div>
			</div>
		</div>
		<div id='blackbox'>
			<div id='share-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Share File</a>
					<a class='edit-close' id='close-share-edit' onclick='hidePopup("share-edit-box")'>X</a>
				</div>
				<div class='edit-box-body' id='edit-share-body'>
					<div id='name-search-bar'>
						<h2 id='name-txt'>Enter Name:</h2>
						<h2 id='search-btn'>Search</h2>
						<div id='name-bar'>
							<input type='text' name='name-val' id='name-val'/>
						</div>
					</div>
					<div id='name-result-bar'>
						
					</div>
				</div>
				<div class='upd-div'>
					<input type='submit' id='up-user' name='submit' value='Send' />
				</div>
			</div>
			<div id='upload-edit-box2' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Upload File[Max Size: 5MB]</a>
					<a class='edit-close' id='close-upload-edit' onclick='hidePopup("upload-edit-box2")'>X</a>
				</div>
				<div class='edit-box-body' id='edit-upload-body2'>
					<input type='file' name='chatFile' id='chatFile' />
					<a id='upStatus'>File Uploaded Successfully</a>
					<div id='uploadBtn'>
						<a id='upBtn'>upload</a>
						<div id='anim_img'></div>
						<a id='upFName'>File Name</a>
					</div>
					
				</div>
				<div class='upd-div'>
					<input type='submit' id='up-user2' name='submit' value='Close'  onclick='hidePopup("upload-edit-box2")'/>
				</div>
			</div>
			<div id='select-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Share File</a>
					<a class='edit-close' id='close-upload-edit' onclick='hidePopup("select-edit-box")'>X</a>
				</div>
				<div class='edit-box-body' id='edit-select-body'>
					<h2 id='select-myfiles'>SELECT FROM MY FILES</h2>
					<h2 id='select-upload'>UPLOAD FILE TO SHARE</h2>
				</div>
			</div>
			<div id='u-upload-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Share File</a>
					<a class='edit-close' id='close-u-upload-edit' onclick='hidePopup("u-upload-edit-box")'>X</a>
				</div>
				<div class='edit-box-body' id='edit-u-upload-body'>
					<div id='name-result-bar2'>
						<?php if($presUser == FALSE): 
						$res = startDB("SELECT * FROM userfiles WHERE User = '". $_SESSION['username']."'");
							if(mysql_num_rows($res)<1){
								echo "<h4 class='nof'>No Files</h4>";
							}
							$num=1;
							while($row = mysql_fetch_array($res)): ?>
						<h3 class='u-f-name' onclick='setFName("<?php echo $row['Name'] ?>", this)'><?php echo $num.") ". $row['Name'] ?></h3>
						<?php $num+=1;?>
						<?php 
						endwhile;
						endif; ?>
					</div>
				</div>
				<div class='upd-div'>
					<input type='submit' id='up-user3' name='submit' value='Share' onclick='shareFile2()'/>
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