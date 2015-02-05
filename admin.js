var largeImages = [];
var lIncrement =0;
var smallImages = [];
var sIncrement =0;
var currentChatroom_Id;
var currentMessage_Id
var mode;
window.onload = function(){
	//hidePanels();
	loadHits();
	getLargeImages();
	getSmallImages();
	var obtn = document.getElementById('overview-btn');
	obtn.onclick = showOverviewPanel;

	var cbtn = document.getElementById('chatrooms-btn');
	cbtn.onclick = showChatroomsPanel;

	var ubtn = document.getElementById('users-btn');
	ubtn.onclick = showUsersPanel;

	var sbtn = document.getElementById('settings-btn');
	sbtn.onclick = showSettingsPanel;

	var mbtn = document.getElementById('messages-btn');
	mbtn.onclick = showMessagesPanel;

	var large_lt = document.getElementById('large-lt');
	large_lt.onclick = showPreviousLargeImage;

	var large_rt = document.getElementById('large-rt');
	large_rt.onclick = showNextLargeImage;

	var small_lt = document.getElementById('small-lt');
	small_lt.onclick = showPreviousSmallImage;

	var small_rt = document.getElementById('small-rt');
	small_rt.onclick = showNextSmallImage;

	var newlarge_lt = document.getElementById('newlarge-lt');
	newlarge_lt.onclick = showPreviousLargeImage;

	var newlarge_rt = document.getElementById('newlarge-rt');
	newlarge_rt.onclick = showNextLargeImage;

	var newsmall_lt = document.getElementById('newsmall-lt');
	newsmall_lt.onclick = showPreviousSmallImage;

	var newsmall_rt = document.getElementById('newsmall-rt');
	newsmall_rt.onclick = showNextSmallImage;

	var settings_lt = document.getElementById('settings-lt');
	settings_lt.onclick = showPreviousLargeImage;

	var settings_rt = document.getElementById('settings-rt');
	settings_rt.onclick = showNextLargeImage;

	var saveBtn = document.getElementById('save-chatroom-btn');
	saveBtn.onclick = saveChatroomEdit;

	var deleteChatroomBtn = document.getElementById('delete-chatroom-btn');
	deleteChatroomBtn.onclick = deleteChatroomEdit;

	var createBtn = document.getElementById('create-chatroom-btn');
	createBtn.onclick = createNewChatroom;

	var closeChatroomEditBtn = document.getElementById('close-chatroom-edit');
	closeChatroomEditBtn.onclick = closeChatroomEditBox;
	
	var cancelChatroomEditBtn = document.getElementById('cancel-chatroom-btn');
	cancelChatroomEditBtn.onclick = closeChatroomEditBox;

	var closeNewChatroomEditBtn = document.getElementById('close-newchatroom-edit');
	closeNewChatroomEditBtn.onclick = closeNewChatroomBox;
	
	var cancelNewChatroomEditBtn = document.getElementById('newcancel-chatroom-btn');
	cancelNewChatroomEditBtn.onclick = closeNewChatroomBox;

	var addChatroomBtn = document.getElementById('add-chatroom');
	addChatroomBtn.onclick = loadNewChatroom;

	var settingsBtn = document.getElementById('edit-settings');
	settingsBtn.onclick = loadSettings;

	var saveSettingsBtn = document.getElementById('save-settings-btn');
	saveSettingsBtn.onclick = saveSettings;

	var closeSettingsBtn = document.getElementById('close-settings-edit');
	closeSettingsBtn.onclick = closeSettingsBox;
	
	var cancelSettingsBtn = document.getElementById('cancel-settings-btn');
	cancelSettingsBtn.onclick = closeSettingsBox;

	var actBtn = document.getElementById('actsettings-btn');
	actBtn.onclick = loadACTSettings;

	var saveActBtn = document.getElementById('saveaccount-btn');
	saveActBtn.onclick = saveAccountData;

	var closeAccountBtn = document.getElementById('account-close-btn');
	closeAccountBtn.onclick = closeAccountBox;
	
	var cancelAccountBtn = document.getElementById('account-cancel-btn');
	cancelAccountBtn.onclick = closeAccountBox;

	var sendMsgBtn = document.getElementById('msg-send-btn');
	sendMsgBtn.onclick = sendMessage;

	var deleteMsgBtn = document.getElementById('msg-delete-btn');
	deleteMsgBtn.onclick = deleteMessage;

	var closeMessageBtn = document.getElementById('msg-close-btn');
	closeMessageBtn.onclick = closeMessagesBox;
	
	var cancelMessageBtn = document.getElementById('msg-cancel-btn');
	cancelMessageBtn.onclick = closeMessagesBox;

	var dropdownMessageBtn = document.getElementById('msg-btn');
	dropdownMessageBtn.onclick = showMessagesPanel;

	var dropdownUploadBtn = document.getElementById('upload-btn');
	dropdownUploadBtn.onclick = showUploadBox;

	var closeUploadBtn = document.getElementById('close-upload-edit');
	closeUploadBtn.onclick = closeUploadEditBox;

	var cancelUploadBtn = document.getElementById('cancel-upload-btn');
	cancelUploadBtn.onclick = closeUploadEditBox;

	var loadUsersBtn = document.getElementById('load-users');
	loadUsersBtn.onclick = loadMoreUsers;
}
function sendMessage(){
	var msg = document.getElementById('reply-body').value;
	var msgSubj = document.getElementById('subject').innerHTML;
	var msgEmail = document.getElementById('emailmsg').innerHTML;
	new Ajax.Request("admindata.php",
	{
		method: 'post',
		parameters: {
			sendmsg: 'true',
			msgsubj: msgSubj,
			msgemail: msgEmail,
			msgbody: msg
		},
		onSuccess: sendMessageResult
	});
}
function sendMessageResult(data){
	if(data.responseText == "SUCCESS"){
		alert("Message sent successfully");
	}else{
		alert("Error sending message:\n"+ data.responseText);
	}
}
function loadMoreUsers(){
	var count = document.querySelectorAll("#users-panel tbody tr").length;
	new Ajax.Request("admindata.php?loadusers=true&count="+count,
	{
		method: 'get',
		onSuccess: loadMoreUsersResult
	});
}
function loadMoreUsersResult(data){
	if(data.responseText.substring(0,3) == "<tr"){
		document.querySelector("#users-panel tbody").innerHTML += data.responseText;
	}else if(data.responseText == "end"){
		document.getElementById('load-users').style.display = "none";
	}else{
		alert("Error: See Details Below\n"+data.responseText);
	}
}
function deleteMessage(){
	new Ajax.Request("admindata.php?deletemsg=true&id="+currentMessage_Id,
	{
		method: 'get',
		onSuccess: returnMsgResult
	});
}
function returnMsgResult(data){
	if(data.responseText == "SUCCESS"){
		alert("Message Deleted\nThe page will be reloaded to display changes");
		window.location = "adminpanel.php";
	}else{
		alert("Error: See Details Below\n"+data.responseText);
	}
}
function loadHits(){
	new Ajax.Request("stats.php?getdate=true&getcount=today",
	{
		method: 'get',
		onSuccess: returnTHits
	});
	new Ajax.Request("stats.php?getdate=true&getcount=yesterday",
	{
		method: 'get',
		onSuccess: returnYHits
	});
	new Ajax.Request("stats.php?getdate=true&getcount=thismonth",
	{
		method: 'get',
		onSuccess: returnMHits
	});
	new Ajax.Request("stats.php?getdate=true&getcount=all",
	{
		method: 'get',
		onSuccess: returnAHits
	});
}
function returnTHits(data){
	document.getElementById('todays-visits').innerHTML = data.responseText;
}
function returnYHits(data){
	document.getElementById('yesterdays-visits').innerHTML = data.responseText;
}
function returnMHits(data){
	document.getElementById('curmonth-visits').innerHTML = data.responseText;
}
function returnAHits(data){
	document.getElementById('alltime-visits').innerHTML = data.responseText;
}
function saveSettings(){
	var siteName1 = document.getElementById('siteName1').value ;
	var siteName2 = document.getElementById('siteName2').value ;
	var siteDesc = document.getElementById('siteDescription').value ;
	var abtPage = document.getElementById('abt-page').value;
	var cnt = document.getElementById('contact').value;
	var adsv =  btoa(document.getElementById('ads-code-vertical').value);
	var adsh =  btoa(document.getElementById('ads-code-horizontal').value);
	new Ajax.Request("admindata.php",
		{
			method: 'post',
			parameters:{
				savesettings: 'true',
				sitename: siteName1+"-s-"+siteName2,
				desc: siteDesc,
				back: largeImages[lIncrement],
				abt: abtPage,
				cnt: cnt,
				adsv: adsv,
				adsh: adsh
			},
			onSuccess: saveSettingsResponse
		});
	$.post(
		
		)
}
function saveSettingsResponse(data){
	//alert("Settings saved successfully");
	if(data.responseText == "SUCCESS"){
		alert("Settings saved successfully\nThe page will be reloaded to display changes");
		window.location = "adminpanel.php";
	}else{
		alert("Error: See Details Below\n"+data.responseText);
	}
}
function saveAccountData(){
	var username = document.getElementById('userName').value;
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
	var confPassword = document.getElementById('confirm-password').value;
	if(username.length >1 && email.length >1 && password.length >4 && password == confPassword){
		new Ajax.Request("admindata.php?saveaccount=true&username="+username+ "&email="+email+ "&password="+ password,
		{
			method: 'get',
			onSuccess: returnResultData
		});
	}else{
		alert("Error: Please follow the guildlines below:\n1) Ensure that no fields are empty\n2) Ensure that your password is atleast 4 characters in length\n3) Ensure that the password and confirm password fields are the same.");
	}
	
}
function returnResultData(data){
	//alert("Settings Saved Successfully");
	if(data.responseText == "SUCCESS"){
		alert("Settings Saved Successfully\nThe page will be reloaded to display changes");
		window.location = "adminpanel.php";
	}else{
		alert("Error: See Details Below\n"+data.responseText);
	}
}
function removeUser(user){
	new Ajax.Request("admindata.php?removeuser=true&name="+user,
		{
			method: 'get',
			onSuccess: removeUserResponse
		});
}
function removeUserResponse(data){
	//alert("The user has been removed along with all posts made by the user");
	if(data.responseText == "SUCCESS"){
		alert("The user has been removed along with all posts made by the user\nThe page will be reloaded to display changes");
		window.location = "adminpanel.php";
	}else{
		alert("Error: See Details Below\n"+data.responseText);
	}
}
function createNewChatroom(){
	var chatroomName = encodeURIComponent(document.getElementById('newChatroomName').value);
	var chatroomDescription = encodeURIComponent(document.getElementById('newChatroomDescription').value);
	var chatroomLargeImg = largeImages[lIncrement];
	var chatroomSmallImg = smallImages[sIncrement];
	if(chatroomName.length > 0 && chatroomDescription.length >0){
		new Ajax.Request("admindata.php?createchatroom=true&name="+chatroomName+"&desc="+chatroomDescription+"&largeimg="+chatroomLargeImg+"&smallimg="+chatroomSmallImg,
		{
			method: 'get',
			onSuccess: createRoom
		});
	}else{
		alert("Please enter a Chatroom Name and Description.");
	}
	
	

}
function createRoom(data){
	//alert('Your Chatroom was created successfully');
	if(data.responseText == "SUCCESS"){
		alert("Your Chatroom was created successfully\nThe page will be reloaded to display changes");
		window.location = "adminpanel.php";
	}else{
		alert("Error: See Details Below\n"+data.responseText);
	}
	closeChatroomEditBox();
}
function saveChatroomEdit(){
	var chatroomName = encodeURIComponent(document.getElementById('chatroomName').value);
	var chatroomDescription = encodeURIComponent(document.getElementById('chatroomDescription').value);
	var chatroomLargeImg = largeImages[lIncrement];
	var chatroomSmallImg = smallImages[sIncrement];
	if(chatroomName.length > 0 && chatroomDescription.length >0){
		new Ajax.Request("admindata.php?editchatroom=true&name="+chatroomName+"&desc="+chatroomDescription+"&largeimg="+chatroomLargeImg+"&smallimg="+chatroomSmallImg+"&id="+currentChatroom_Id,
		{
			method: 'get',
			onSuccess: saveEdits
		});
	}else{
		alert("Please enter a Chatroom Name and Description.");
	}
	
	

}
function saveEdits(data){
	//alert('Settings were saved successfully');
	if(data.responseText == "SUCCESS"){
		alert("Settings were saved successfully\nThe page will be reloaded to display changes");
		window.location = "adminpanel.php";
	}else{
		alert("Error: See Details Below\n"+data.responseText);
	}
	closeChatroomEditBox();
}
function deleteChatroomEdit(){
	
		new Ajax.Request("admindata.php?deletechatroom=true&id="+currentChatroom_Id,
		{
			method: 'get',
			onSuccess: deleteChatroom
		});
}
function deleteChatroom(data){
	//alert('Chatroom Deleted successfully');
	if(data.responseText == "SUCCESS"){
		alert("Chatroom Deleted successfully\nThe page will be reloaded to display changes");
		window.location = "adminpanel.php";
	}else{
		alert("Error: See Details Below\n"+data.responseText);
	}
	closeChatroomEditBox();
}
function showPreviousLargeImage(){
	var large_c ;
	if(mode == "EditChatroom"){
		large_c = document.getElementById('large-c');
	}else if(mode == "CreateChatroom"){
		large_c = document.getElementById('newlarge-c');
	}else{
		large_c = document.getElementById('settings-c');
	}
	
	if(lIncrement>0){
		lIncrement -=1;
		large_c.style.background = "url('"+largeImages[lIncrement]+"') no-repeat";
		large_c.style.backgroundPosition = "center center";
		large_c.style.backgroundSize = "cover";
		
	}
}
function showNextLargeImage(){
	var large_c ;
	if(mode == "EditChatroom"){
		large_c = document.getElementById('large-c');
	}else if(mode == "CreateChatroom"){
		large_c = document.getElementById('newlarge-c');
	}else{
		large_c = document.getElementById('settings-c');
	}

	if(lIncrement< largeImages.length-1){
		lIncrement +=1;
		large_c.style.background = "url('"+largeImages[lIncrement]+"') no-repeat";
		large_c.style.backgroundPosition = "center center";
		large_c.style.backgroundSize = "cover";
		
	}
}
function showPreviousSmallImage(){
	var small_c ;
	if(mode == "EditChatroom"){
		small_c = document.getElementById('small-c');
	}else{
		small_c = document.getElementById('newsmall-c');
	}
	if(sIncrement>0){
		sIncrement -=1;
		small_c.style.background = "url('"+smallImages[sIncrement]+"') no-repeat";
		small_c.style.backgroundPosition = "center center";
		small_c.style.backgroundSize = "cover";
		
	}
}
function showNextSmallImage(){
	var small_c ;
	if(mode == "EditChatroom"){
		small_c = document.getElementById('small-c');
	}else{
		small_c = document.getElementById('newsmall-c');
	}
	if(sIncrement< smallImages.length-1){
		sIncrement +=1;
		small_c.style.background = "url('"+smallImages[sIncrement]+"') no-repeat";
		small_c.style.backgroundPosition = "center center";
		small_c.style.backgroundSize = "cover";
		
	}
}
function getLargeImages(){
	new Ajax.Request("admindata.php?getLargeImgs=true",
	{
		method: 'get',
		onSuccess: loadLargeImages
	});
	
}
function loadLargeImages(data){
	largeImages = data.responseText.split(";");
	//alert(largeImages[0]);
}
function getSmallImages(){
	new Ajax.Request("admindata.php?getSmallImgs=true",
	{
		method: 'get',
		onSuccess: loadSmallImages
	});
	
}
function loadSmallImages(data){
	smallImages = data.responseText.split(";");
	//alert(smallImages[0]);
}
function loadEditChatroom(id, chatroom_id){
	var chName = document.getElementById(id).getElementsByClassName('chName')[0].innerHTML;
	var chDescription = document.getElementById(id).getElementsByClassName('chDescription')[0].innerHTML;
	var chImgLarge = document.getElementById(id).getElementsByClassName('chImgLarge')[0].innerHTML;
	var chImgSmall = document.getElementById(id).getElementsByClassName('chImgSmall')[0].innerHTML;

	document.getElementById('chatroomName').value = chName;
	document.getElementById('chatroomDescription').value = chDescription;
	

	var imgCSS_Large = document.getElementById('chatroomImageLarge').getElementsByClassName('c')[0];
	imgCSS_Large.style.background = "url('"+chImgLarge+"') no-repeat";
	imgCSS_Large.style.backgroundPosition = "center center";
	imgCSS_Large.style.backgroundSize = "cover";

	var imgCSS_Small = document.getElementById('chatroomImageSmall').getElementsByClassName('c')[0];
	imgCSS_Small.style.background = "url('"+chImgSmall+"') no-repeat";
	imgCSS_Small.style.backgroundPosition = "center center";
	imgCSS_Small.style.backgroundSize = "cover";

	mode = "EditChatroom";
	lIncrement=0;
	sIncrement=0;
	if(largeImages.indexOf(chImgLarge) != -1){
		lIncrement = largeImages.indexOf(chImgLarge);
	}
	if(smallImages.indexOf(chImgSmall) != -1){
		sIncrement = smallImages.indexOf(chImgSmall);
	}

	// getLargeImages();
	// getSmallImages();
	currentChatroom_Id = chatroom_id;
	showPopup("chatroom-edit-box");
}
function loadNewChatroom(){
	mode= "CreateChatroom";
	lIncrement=0;
	sIncrement=0;
	// getLargeImages();
	// getSmallImages();

	var imgCSS_Large = document.getElementById('newlarge-c');
	imgCSS_Large.style.background = "url('"+largeImages[0]+"') no-repeat";
	imgCSS_Large.style.backgroundPosition = "center center";
	imgCSS_Large.style.backgroundSize = "cover";

	var imgCSS_Small = document.getElementById('newsmall-c');
	imgCSS_Small.style.background = "url('"+smallImages[0]+"') no-repeat";
	imgCSS_Small.style.backgroundPosition = "center center";
	imgCSS_Small.style.backgroundSize = "cover";
	
	showPopup("newchatroom-edit-box");
}
function loadSettings(){
	var websiteName_1 = document.getElementById('name1').innerHTML;
	var websiteName_2 = document.getElementById('name2').innerHTML;
	var websiteDesc = document.getElementById('website-desc').innerHTML;
	var websiteBack = document.getElementById('website-back').innerHTML;
	var websiteAbt = document.getElementById('website-abt').innerHTML;
	var websiteCnt = document.getElementById('website-cnt').innerHTML;
	var websiteAds = document.getElementById('rawAdCode').innerHTML;
	var websiteAdsH = document.getElementById('rawAdCode-h').innerHTML;

	document.getElementById('siteName1').value = websiteName_1;
	document.getElementById('siteName2').value = websiteName_2;
	document.getElementById('siteDescription').value = websiteDesc;
	document.getElementById('abt-page').value = websiteAbt;
	document.getElementById('contact').value = websiteCnt;
	document.getElementById('ads-code-vertical').value = websiteAds;
	document.getElementById('ads-code-horizontal').value = websiteAdsH;

	mode = "settings"
	lIncrement=0;
	sIncrement=0;
	if(largeImages.indexOf(websiteBack) != -1){
		lIncrement = largeImages.indexOf(websiteBack);
	}
	var imgCSS = document.getElementById('settings-c');
	imgCSS.style.background = "url('"+websiteBack+"') no-repeat";
	imgCSS.style.backgroundPosition = "center center";
	imgCSS.style.backgroundSize = "cover";

	showPopup("settings-edit-box");
}
function loadACTSettings(){
	showPopup('account-edit-box');
}
function showUploadBox(){
	showPopup('upload-edit-box');
}
function loadMessages(id, message_id){
	var name = document.getElementById(id).getElementsByClassName('ms-name')[0].innerHTML;
	var from = document.getElementById(id).getElementsByClassName('ms-from')[0].innerHTML;
	var subject = document.getElementById(id).getElementsByClassName('ms-subject')[0].innerHTML;
	var body = document.getElementById(id).getElementsByClassName('ms-body')[0].innerHTML;
	var date = document.getElementById(id).getElementsByClassName('ms-date')[0].innerHTML;

	document.getElementById("from-name").innerHTML = name;
	document.getElementById("emailmsg").innerHTML = from;
	document.getElementById("subject").innerHTML = subject;
	document.getElementById("body").innerHTML = body;
	currentMessage_Id = message_id;
	showPopup("message-edit-box");
}

function showPopup(id){
	document.getElementById("blackbox").style.display = "block";
	document.getElementById(id).style.display = "block";
}
function hidePopup(id){
	document.getElementById("blackbox").style.display = "none";
	document.getElementById(id).style.display = "none";
}
function closeUploadEditBox(){
	hidePopup("upload-edit-box");
}
function closeChatroomEditBox(){
	hidePopup("chatroom-edit-box");
}
function closeNewChatroomBox(){
	hidePopup("newchatroom-edit-box");
}
function closeSettingsBox(){
	hidePopup("settings-edit-box");
}
function closeAccountBox(){
	hidePopup("account-edit-box");
}
function closeMessagesBox(){
	hidePopup("message-edit-box");
}
function showOverviewPanel(){
	hidePanels();
	showPanel("#overview-panel");
}
function showChatroomsPanel(){
	hidePanels();
	showPanel("#chatrooms-panel");
}
function showUsersPanel(){
	hidePanels();
	showPanel("#users-panel");
}
function showSettingsPanel(){
	hidePanels();
	showPanel("#sitesettings-panel");
}
function showMessagesPanel(){
	hidePanels();
	showPanel("#messages-panel");
}
function showPanel(id){
	document.querySelector(id).style.display = "block";
}
function hidePanels(){
	document.querySelector('#overview-panel').style.display = "none";
	document.querySelector('#chatrooms-panel').style.display = "none";
	document.querySelector('#users-panel').style.display = "none";
	document.querySelector('#sitesettings-panel').style.display = "none";
	document.querySelector('#messages-panel').style.display = "none";
}