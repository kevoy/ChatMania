<?php
include 'startdb.php';

session_start();
if(!isset($_SESSION['admin'])){
	if(isset($_REQUEST['adminName']) && isset($_REQUEST['adminPassword'])){
		$results = startDB("SELECT * FROM admin");
		while($row=mysql_fetch_array($results)){
			if(($_REQUEST['adminName'] == $row['Username'] || $_REQUEST['adminName'] == $row['Email']) && $_REQUEST['adminPassword'] == $row['Password']){
				$_SESSION['admin'] = $row['Username'];
			}else{
				header("Location: adminlogin.php?result=invalid");
			}
		}
	}else{
		header("Location: adminlogin.php?result=invalid");
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Admin Panel</title>
		<link rel='stylesheet' type='text/css' href='admin.css' />
		<link rel="stylesheet" type="text/css" href="footer.css" /> 
		<script type='text/javascript' src='admin.js'></script>
		<script src="prototype.js"></script>
	</head>
	<body>
		<div id='header-menu'>
			<h2 id='site-title'>Admin Panel</h2>
			<ul id='drop-down'>
				<li id='admin-name'><a>Welcome <?php echo $_SESSION['admin'] ?> &darr;</a>
					<ul id='drop-info'>
						<li id='actsettings-btn'><a> Account Settings</a></li>
						<li id='msg-btn'><a> Messages</a></li>
						<li id='upload-btn'><a> Upload Image</a></li>
						<li id='logout-btn' onclick="window.location = 'admindata.php?logout=true';"><a> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<div id='bottom'>
			<div id='left-menu'>
				<div id='overview-btn' class='left-tab'>
					<span id='img-overview' class='left-btn-img'></span><h2>Overview</h2>
				</div>
				<div id='chatrooms-btn' class='left-tab'>
					<span id='img-chatrooms' class='left-btn-img'></span><h2>Chatrooms</h2>
				</div>
				<div id='users-btn' class='left-tab'>
					<span id='img-users' class='left-btn-img'></span><h2>Users</h2>
				</div>
				<div id='settings-btn' class='left-tab'>
					<span id='img-settings' class='left-btn-img'></span><h2>Site Settings</h2>
				</div>
				<div id='messages-btn' class='left-tab'>
					<span id='img-messages' class='left-btn-img'></span><h2>Messages</h2>
				</div>
			</div>
			<div id='main-display'>
				<div id='overview-panel' class='panel'>
					<div class='panel-header-holder'>
						<h2 class='panel-header'>Overview</h2>
					</div>
					<div class='panel' id='stats-group'>
						<div class='pane pane-250'>
							<div class='top-pane-bar blue'>
							</div>
							<div class='center-pane-bar'>
								<a id='todays-visits'>Loading...</a>
							</div>
							<div class='bottom-pane-bar'>
								<a>Visitors Today</a>
							</div>
						</div>
						<div class='pane pane-250'>
							<div class='top-pane-bar green'>
							</div>
							<div class='center-pane-bar'>
								<a id='yesterdays-visits'>Loading...</a>
							</div>
							<div class='bottom-pane-bar'>
								<a>Visitors Yesterday</a>
							</div>
						</div>
						<div class='pane pane-250'>
							<div class='top-pane-bar red'>
							</div>
							<div class='center-pane-bar'>
								<a id='curmonth-visits'>Loading...</a>
							</div>
							<div class='bottom-pane-bar'>
								<a>Visitors This Month</a>
							</div>
						</div>
						<div class='pane pane-250'>
							<div class='top-pane-bar orange'>
							</div>
							<div class='center-pane-bar'>
								<a id='alltime-visits'>Loading...</a>
							</div>
							<div class='bottom-pane-bar'>
								<a>Total Visits</a>
							</div>
						</div>
					</div>
					<div class='panel' id='user-group'>
						<div class='pane pane-520'>
							<div class='top-pane-bar blue'>
							</div>
							<div class='pane-title'>
								<a>User Statistics</a>
							</div>
							<div class='pane-body'>
								<table border='0'>
									<tbody>
										<tr>
											<td>Total Users</td>
											<td><?php 
												$numResults = startDB("SELECT * FROM users;" );
												echo mysql_num_rows($numResults);

												 ?> 
												</td>
										</tr>
										<tr>
											<td>Users Online</td>
											<td><?php 
												$numResults = startDB("SELECT * FROM users;" );
												echo mysql_num_rows($numResults);

												 ?> </td>
										</tr>
										<tr>
											<td>Total Chatroom Messages</td>
											<td><?php 
												$numResults = startDB("SELECT * FROM chatroom_messages;" );
												echo mysql_num_rows($numResults);

												 ?> </td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class='pane pane-520'>
							<div class='top-pane-bar green'>
							</div>
							<div class='pane-title'>
								<a>Chatroom Statistics</a>
							</div>
							<div class='pane-body' id='chatroom-stats-150'>
								<table border='0'>
									<tbody>
										<?php 
											$rooms = startDB("SELECT * FROM chatrooms;" );
											while($row=mysql_fetch_array($rooms)): ?> 
										<tr>
											<td><?php echo $row['Name'] ?></td>
											<td><?php $numUserResults = startDB("SELECT * FROM users WHERE CurrentRoom = "."'". $row['id'] ."';" );
												echo mysql_num_rows($numUserResults);
											 ?> Users Online</td>
										</tr>
										<?php endwhile; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id='chatrooms-panel' class='panel'>
					<div class='panel-header-holder'>
						<h2 class='panel-header'>Chatrooms</h2>
					</div>
					<div class='panel' id='chatrooms-group'>
						<div class='pane pane-auto'>
							<div class='top-pane-bar blue'>
							</div>
							<div class='pane-body data-view'>
								<table border='0'>
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th>Large Image</th>
											<th>Small Image</th>
											<th>Settings</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$rooms = startDB("SELECT * FROM chatrooms;" );
											$cur_row = "even";
											while($row=mysql_fetch_array($rooms)): 
												if($cur_row == "odd"){
													$cur_row = "even";
												}else{
													$cur_row = "odd";
												}
											?> 
										<tr id="ch<?php echo $row['id']; ?>" class="<?php echo $cur_row ?>">
											<td class='chName'><?php echo $row['Name'] ?></td>
											<td class='chDescription'><?php echo $row['Description'] ?></td>
											<td class='chImgLarge brk-word'><?php echo $row['ImgLarge'] ?></td>
											<td class='chImgSmall brk-word'><?php echo $row['ImgSmall'] ?></td>
											<td><a class="table-button" style="cursor:pointer;" onclick="loadEditChatroom('ch<?php echo $row['id']; ?>', '<?php echo $row['id']; ?>')">Edit</a></td>
										</tr>
										<?php endwhile; ?>
									</tbody>
								</table>
							</div>
						</div>
						<a id='add-chatroom'>Add New Chatroom</a>
					</div>
				</div>
				<div id='users-panel' class='panel'>
					<div class='panel-header-holder'>
						<h2 class='panel-header'>Users</h2>
					</div>
					<div class='panel' id='users-group'>
						<div class='pane pane-auto'>
							<div class='top-pane-bar blue'>
							</div>
							<div class='pane-body data-view'>
								<table border='0'>
									<thead>
										<tr>
											<th>Username</th>
											<th>Chatroom</th>
											<th>Last Detected</th>
											<th>Last Post</th>
											<th>Settings</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$users = startDB("SELECT * FROM users ORDER BY lastDetected DESC LIMIT 0, 10;" );
											$cur_row = "even";
											while($row=mysql_fetch_array($users)): 
												if($cur_row == "odd"){
													$cur_row = "even";
												}else{
													$cur_row = "odd";
												}
												?> 
										<tr  class="<?php echo $cur_row ?>">
											<td><?php echo $row['Name'] ?></td>
											<td><?php $rooms = startDB("SELECT * FROM chatrooms WHERE id = ". $row['CurrentRoom']. "; ");
												while($uRooms = mysql_fetch_array($rooms)){
													echo $uRooms['Name'];
												}
												?></td>
											<td><?php echo $row['lastDetected'] ?></td>
											<td><?php $msgs = startDB("SELECT * FROM chatroom_messages WHERE User = " ."'". esc($row['Name']) ."'"." ORDER BY Time DESC LIMIT 0, 1;" );
												while($uRow = mysql_fetch_array($msgs)){
													echo htmlspecialchars($uRow['Message']);
												}
											 ?></td>
											<td><a class="table-button" onclick="removeUser('<?php echo addslashes($row['Name']) ?>')">Remove User</a></td>
										</tr>
										<?php endwhile; ?>
										
									</tbody>
								</table>
								<a id='load-users'>Load More Users</a>
							</div>
						</div>

					</div>
				</div>
				<div id='sitesettings-panel' class='panel'>
					<div class='panel-header-holder'>
						<h2 class='panel-header'>Site Settings</h2>
					</div>
					<div class='panel' id='sitesettings-group'>
						<div class='pane pane-auto'>
							<div class='top-pane-bar blue'>
							</div>
							<div class='pane-body data-view'>
								<table border='0'>
									<thead>
										<tr>
											<th>Name</th>
											<th>Value/Data</th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
											$data = startDB("SELECT * FROM settings LIMIT 0, 1;" );
											while($row=mysql_fetch_array($data)): ?>
										<tr class="odd">
											<td>Website Name</td>
											<?php 
											$t = explode("#", $row['SiteTitle']);
											$t1 = $t[0];
											$t2 = $t[1];
											?>
											<td id='website-name'><?php echo "<span id='name1'>" . $t1."</span> <span id='name2'>".$t2 ."</span>"  ?></td>
											
										</tr>
										<tr class="even">
											<td>Website Description</td>
											<td id='website-desc'><?php echo $row['SiteDescription'] ?></td>
											
										</tr>
										<tr class="odd">
											<td>Website Background</td>
											<td id='website-back'><?php echo $row['SiteBackground'] ?></td>
											
										</tr>
										<tr class="even">
											<td>About Page</td>
											<td id='website-abt'><?php echo $row['About'] ?></td>
											
										</tr>
										<tr class="odd">
											<td>Contact Page</td>
											<td id='website-cnt'><?php echo $row['Contact'] ?></td>
											
										</tr>
										<tr class="even">
											<td>Adsense Code [Vertical]</td>
											<td id='website-adscode'>Adsense Code 160 X 600<br> [If you haven't already done so, log into adsense 
												and create a 160 X 600 image/text ad copy the entire code and paste it here replacing the current code in the text field]<span id='rawAdCode' style='display:none;'><?php echo $row['AdsCode']; ?></span></td>
										</tr>
										<tr class="odd">
											<td>Adsense Code [Horizontal]</td>
											<td id='website-adscode-h'>Adsense Code 728 X 90<br> [If you haven't already done so, log into adsense 
												and create a 728 X 90 image/text ad copy the entire code and paste it here replacing the current code in the text field]<span id='rawAdCode-h' style='display:none;'><?php echo $row['AdsCodeH']; ?></span></td>
										</tr>
										<?php endwhile; ?>
									</tbody>
								</table>
								<a id='edit-settings'>Edit</a>
							</div>
						</div>

					</div>
				</div>
				<div id='messages-panel' class='panel'>
					<div class='panel-header-holder'>
						<h2 class='panel-header'>Messages</h2>
					</div>
					<div class='panel' id='messages-group'>
						<div class='pane pane-auto'>
							<div class='top-pane-bar blue'>
							</div>
							<div class='pane-body data-view'>
								<table border='0'>
									<thead>
										<tr>
											<th>Name</th>
											<th>From</th>
											<th>Subject</th>
											<th>Message</th>
											<th>Date</th>
											<th>Settings</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$messages = startDB("SELECT * FROM messages ORDER BY Date DESC;" );
											$cur_row = "even";
											while($row=mysql_fetch_array($messages)): 
												if($cur_row == "odd"){
													$cur_row = "even";
												}else{
													$cur_row = "odd";
												}
												?> 
										<tr id="ms<?php echo $row['id'] ?>" class="<?php echo $cur_row ?>">
											<td class='ms-name'><?php echo htmlspecialchars($row['Name']) ?></td>
											<td class='ms-from'><?php echo htmlspecialchars($row['From']) ?></td>
											<td class='ms-subject'><?php echo htmlspecialchars($row['Subject']) ?></td>
											<td class='ms-body'><?php echo htmlspecialchars($row['Body']) ?></td>
											<td class='ms-date'><?php echo $row['Date'] ?></td>
											<td><a class='table-button' onclick="loadMessages('ms<?php echo $row['id']; ?>', '<?php echo $row['id']; ?>')">View</a></td>
						
										</tr>
										<?php endwhile; ?>
									</tbody>
								</table>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div id='blackbox'>
			<div id='upload-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Upload Image</a>
					<a class='edit-close' id='close-upload-edit'>X</a>
				</div>
				<div class='edit-box-body' id='edit-upload-body'>
					<form action='admindata.php' method="post" enctype="multipart/form-data">
						<input type='hidden' name='largeimgupload' value='true'/>
						<div class='box-body-row'>
							<a>Upload Large Image</a>
							<input type='file' name='file' id='file1' class='right-input'/>
							
						</div>
						<div class='box-body-row'>
							<a></a>
							<input type='submit' class='right-input' value='Upload' class='upload-btn'/>
						</div>
				    </form>
				    <form action='admindata.php' method="post" enctype="multipart/form-data">
						<input type='hidden' name='smallimgupload' value='true'/>
						<div class='box-body-row'>
							<a>Upload Small Image</a>
							<input type='file' name='file' id='file1' class='right-input'/>
							
						</div>
						<div class='box-body-row'>
							<a></a>
							<input type='submit' class='right-input' value='Upload' class='upload-btn'/>
						</div>
				    </form>

				</div>
				<div class='edit-box-buttonholder' id='edit-upload-buttonholder'>
					<a class='btn' id='cancel-upload-btn'>Cancel</a>
				</div>
			</div>
			<div id='chatroom-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Edit Chatroom</a>
					<a class='edit-close' id='close-chatroom-edit'>X</a>
				</div>
				<div class='edit-box-body' id='edit-chatroom-body'>
					<div class='box-body-row'>
						<a>Chatroom Name</a>
						<input type='text' name='chatroomName' id='chatroomName' class='right-input'/>
					</div>
					<div class='box-body-row'>
						<a>Chatroom Description</a>
						<textarea type='text' name='chatroomDescription' id='chatroomDescription' class='right-input'></textarea>
					</div>
					<div class='box-body-row'>
						<a>Chatroom Image [Large]</a>
						<div id='chatroomImageLarge' class='right-input'>
							<div class='lt' id='large-lt'><a><</a></div>
							<div class='rt' id='large-rt'><a>></a></div>
							<div class='c' id='large-c'></div>
						</div>
					</div>
					<div class='box-body-row'>
						<a>Chatroom Image [Small]</a>
						<div id='chatroomImageSmall' class='right-input'>
							<div class='lt' id='small-lt'><a><</a></div>
							<div class='rt' id='small-rt'><a>></a></div>
							<div class='c' id='small-c'></div>
						</div>
					</div>
				</div>
				<div class='edit-box-buttonholder' id='edit-chatroom-buttonholder'>
					<a class='btn' id='cancel-chatroom-btn'>Cancel</a>
					<a class='btn' id='delete-chatroom-btn'>Delete</a>
					<a class='btn' id='save-chatroom-btn'>Save</a>
				</div>
			</div>

			<div id='newchatroom-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Create Chatroom</a>
					<a class='edit-close' id='close-newchatroom-edit'>X</a>
				</div>
				<div class='edit-box-body' id='edit-newchatroom-body'>
					<div class='box-body-row'>
						<a>Chatroom Name</a>
						<input type='text' name='chatroomName' id='newChatroomName' class='right-input'/>
					</div>
					<div class='box-body-row'>
						<a>Chatroom Description</a>
						<textarea type='text' name='chatroomDescription' id='newChatroomDescription' class='right-input'></textarea>
					</div>
					<div class='box-body-row'>
						<a>Chatroom Image [Large]</a>
						<div id='newChatroomImageLarge' class='right-input'>
							<div class='lt' id='newlarge-lt'><a><</a></div>
							<div class='rt' id='newlarge-rt'><a>></a></div>
							<div class='c' id='newlarge-c'></div>
						</div>
					</div>
					<div class='box-body-row'>
						<a>Chatroom Image [Small]</a>
						<div id='newChatroomImageSmall' class='right-input'>
							<div class='lt' id='newsmall-lt'><a><</a></div>
							<div class='rt' id='newsmall-rt'><a>></a></div>
							<div class='c' id='newsmall-c'></div>
						</div>
					</div>
				</div>
				<div class='edit-box-buttonholder' id='edit-newChatroom-buttonholder'>
					<a class='btn' id='newcancel-chatroom-btn'>Cancel</a>
					<a class='btn' id='create-chatroom-btn'>Create</a>
				</div>
			</div>

			<div id='message-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Reply To Message</a>
					<a class='edit-close' id='msg-close-btn'>X</a>
				</div>
				<div class='edit-box-body' id='edit-message-body'>
					<div class='box-body-row'>
						<a>Name</a>
						<div id='from-name' class='right-input'>Andrelle</div>
					</div>
					<div class='box-body-row'>
						<a>From</a>
						<div id='emailmsg' class='right-input'>andrelle@yahoo.com</div>
					</div>
					<div class='box-body-row'>
						<a>Subject</a>
						<div id='subject' class='right-input'>Just A Test</div>
					</div>
					<div class='box-body-row'>
						<a>Body</a>
						<div id='body' class='right-input'>this is the body</div>
					</div>
					<div class='box-body-row'>
						<a style='font-weight:bold;'>Reply To This Message</a>
					</div>
					<div class='box-body-row'>
						<a>Reply Body</a>
						<textarea type='text' name='reply-body' id='reply-body' class='right-input'></textarea>
					</div>

				</div>
				<div class='edit-box-buttonholder' id='edit-chatroom-buttonholder'>
					<a class='btn' id='msg-cancel-btn'>Cancel</a>
					<a class='btn' id='msg-delete-btn'>Delete</a>
					<a class='btn' id='msg-send-btn'>Send</a>
				</div>
			</div>
			<div id='settings-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Website Settings</a>
					<a class='edit-close' id='close-settings-edit'>X</a>
				</div>
				<div class='edit-box-body' id='edit-settings-body'>
					<div class='box-body-row'>
						<a>Website Name</a>
						<input type='text' name='siteName1' id='siteName1' class='right-input-name'/>
						<input type='text' name='siteName2' id='siteName2' class='right-input-name'/>
					</div>
					<div class='box-body-row'>
						<a>Website Description</a>
						<textarea type='text' name='siteDescription' id='siteDescription' class='right-input'></textarea>
					</div>
					<div class='box-body-row'>
						<a>Background Image</a>
						<div id='chatroomImageLarge' class='right-input'>
							<div class='lt' id='settings-lt'><a><</a></div>
							<div class='rt' id='settings-rt'><a>></a></div>
							<div class='c' id='settings-c'></div>
						</div>
					</div>
					<div class='box-body-row'>
						<a>About Page</a>
						<textarea type='text' name='abt-page' id='abt-page' class='right-input'></textarea>
					</div>
					<div class='box-body-row'>
						<a>Contact Email</a>
						<input type='text' name='contact' id='contact' class='right-input'/>
					</div>
					<div class='box-body-row'>
						<a>Adsense Code [Vertical]</a>
						<textarea type='text' name='ads-code-vertical' id='ads-code-vertical' class='right-input'></textarea>
					</div>
					<div class='box-body-row'>
						<a>Adsense Code [Horizontal]</a>
						<textarea type='text' name='ads-code-horizontal' id='ads-code-horizontal' class='right-input'></textarea>
					</div>
				</div>
				<div class='edit-box-buttonholder' id='edit-chatroom-buttonholder'>
					<a class='btn' id='cancel-settings-btn'>Cancel</a>
					<a class='btn' id='save-settings-btn'>Save</a>
				</div>
			</div>
			<div id='account-edit-box' class='edit-box'>
				<div class='edit-box-header'>
					<a class='edit-box-title'>Account Settings</a>
					<a class='edit-close'  id='account-close-btn'>X</a>
				</div>
				<div class='edit-box-body' id='edit-account-body'>
					<?php  
						$adminResults = startDB("SELECT * FROM admin LIMIT 0,1");
						while($row=mysql_fetch_array($adminResults)):
					?>
					<div class='box-body-row'>
						<a>Username</a>
						<input type='text' name='userName' id='userName' class='right-input' value="<?php echo $row['Username']; ?>"/>
					</div>
					<div class='box-body-row'>
						<a>Email</a>
						<input type='text' name='email' id='email' class='right-input' value="<?php echo $row['Email']; ?>"/>
					</div>
					<div class='box-body-row'>
						<a>Password</a>
						<input type='password' name='password' id='password' class='right-input' value="<?php echo $row['Password']; ?>"/>
					</div>
					<div class='box-body-row'>
						<a>Confirm Password</a>
						<input type='password' name='confirm-password' id='confirm-password' class='right-input' value="<?php echo $row['Password']; ?>"/>
					</div>
					<?php endwhile; ?>
				</div>
				<div class='edit-box-buttonholder' id='edit-chatroom-buttonholder'>
					<a class='btn' id='account-cancel-btn'>Cancel</a>
					<a class='btn' id='saveaccount-btn'>Save</a>
				</div>
			</div>
		</div>
		<?php include 'footer.php' ?>
	</body>
</html>