<?php
include 'sitedata.php';
include 'startdb.php';
session_start();

if(!isset($_SESSION['username']) || !isset($_REQUEST['vidroomname'])){
	header("Location: index.php");
}
$vidRoom = $_REQUEST['vidroomname'];
if(isset($_REQUEST['recv'])){
	startDB("UPDATE videopeers SET State = 'inprogress' WHERE VideoRoomName = '". $_REQUEST['vidroomname']."'");
	$_SESSION['vidroomname'] = $_REQUEST['vidroomname'];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $siteTitle1 . " " . $siteTitle2 ?></title>
		<link rel="stylesheet" type="text/css" href="chatmain.css" />
		<link rel="stylesheet" type="text/css" href="footer.css" />
		<script src="prototype.js"></script>
		<script src="http://simplewebrtc.com/latest.js"></script> 
		<script src="video.js"></script> 
		<script type="text/javascript">
			var vidRoom = "<?php echo $vidRoom ?>";
			var webRTC = new SimpleWebRTC({
				localVideoEl: "local-video",
				remoteVideoEl: "remote-video",
				autoRequestMedia: true
			});

			webRTC.on('readyToCall', function () {
		    // you can name it anything
		    	webRTC.joinRoom(vidRoom);
			});

			webRTC.on('videoAdded', function (video, peer) {
                console.log('video added', peer);
                var remotes = document.getElementById('remote-video');
                if (remotes) {
                    
                    remotes.appendChild(video);
                }
           	 });

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
					<?php if(isset($_SESSION['username'])){
						echo "<li><a href='userlogout.php'>LOGOUT</a></li>";
					}else{
						echo "<li><a href='userlogin.php'>LOGIN</a></li>";
					}
					?>
				</ul>
			</div>
		</div>
		<div id='main'>
			<div id='vidcallstatus'>
				<h1 id='vidstatus'>Waiting for user to join chat ...</h1> 
			</div>
			<div id='video-bar'>
				<div id='remote-video'>
					<div id='local-video'>
					</div>
				</div>
				
			</div>
		</div>
		<?php include 'footer.php' ?>
	</body>
</html>