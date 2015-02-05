<?php
include 'startdb.php';
session_start();
						$min =date('i') - 5;
						if($min>0){
							$recTime = date('Y-m-d H:'.$min.':s');
						}else{
							$recTime = date('Y-m-d H:0:0');
						}
						
						//echo date('Y-m-d H:i:s') ." = ".$recTime; 
							$usersResult = startDB("SELECT * FROM users WHERE CurrentRoom = '".$_REQUEST['room']."' and lastDetected > '$recTime' ORDER BY lastDetected DESC");
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