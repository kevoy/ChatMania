var message = "test";
var timer1, timer2, timer3, timer4;
var receiverName, curUserName, curVidBtn;
var fileUp = 'None';
var logout = false;
var oncall=false;
var emoState = "CLOSED";
window.onload = function(){
	var postBtn = document.getElementById('postBtn');
	postBtn.onclick = postMessage;
	var enterPostBtn = document.getElementById('chatTxt');
	enterPostBtn.onkeypress = postMessageOnenter;
	document.getElementById('upBtn').onclick = uploadUserFile;
	document.getElementById('up-user').onclick = postUpload;
	document.getElementById('attachBtn').onclick = showFileUpload;
	document.getElementById('close-upload-edit').onclick = closePopup;
	document.getElementById('emo-btn').onclick = growEmoBar;
	deleteOldMessages();
	getAllMessages();
	checkChangeChatroom();
	updateUsersOnline();
	checkReceiveCall();

}
function deleteOldMessages(){
	new Ajax.Request("chatroommessages.php?method=del",
	{
		method: 'get',
		onSuccess: deleteResponse
	});
	
}
function deleteResponse(data){
	console.log(data.responseText);
}
function updateUsersOnline(){
	new Ajax.Request("updateUsersOnline.php?room="+roomId,
	{
		method: 'get',
		onSuccess: updateUsersResponse
	});
}
function updateUsersResponse(data){
	if(data.responseText.substr(0,4)=="<div" && oncall==false){
		document.getElementById('leftBarBottom').innerHTML=data.responseText;

	}
	timer4 = setTimeout("updateUsersOnline()", 7000);
	
}
function getAllMessages(){
	new Ajax.Request("chatroommessages.php?method=all",
	{
		method: 'get',
		onSuccess: embedAllMessages
	});
	
}

function embedAllMessages(data){
	if(data.responseText.length >0 && data.responseText.substr(0,4)=="<div"){
		document.getElementById('chatBarInner').innerHTML = data.responseText;
		var chatBarInner = document.getElementById('chatBarInner');
		chatBarInner.scrollTop = chatBarInner.scrollHeight;
		
	}else if(data.responseText.length < 1){
		document.getElementById('chatBarInner').innerHTML = "<a style='display:block; text-align:center; margin-top:10px;'>Be the first to post...</a>";
	}
	getRecentMessages();
}
function embedMessage(msg){

}
function getRecentMessages(){
	new Ajax.Request("chatroommessages.php?method=recent",
	{
		method: 'get',
		onSuccess: embedRecentMessages
	});
	
}
function embedRecentMessages(data){
	if(data.responseText.length >0 && data.responseText.substr(0,4)=="<div"){
		document.getElementById('chatBarInner').innerHTML += data.responseText;
		var chatBarInner = document.getElementById('chatBarInner');
		chatBarInner.scrollTop = chatBarInner.scrollHeight;
	}
	if(logout==false){
		timer1 =setTimeout("getRecentMessages()", 4000);
	}else{
		clearTimeout(timer1);
		window.location="userlogout.php";
	}
}
function postMessage(){
	document.getElementById('postBtn').style.backgroundColor ="#626261";
	document.getElementById('postBtn').innerHTML ="....";
	var msg = encodeURIComponent(document.getElementById('chatTxt').value);
	new Ajax.Request("chatroommessages.php?method=send&message=" + msg,
	{
		method: 'get',
		onSuccess: postMessageResponse
	});
}
function postMessageOnenter(e){
	
	if(e.keyCode === 13){
		document.getElementById('postBtn').style.backgroundColor ="#626261";
		document.getElementById('postBtn').innerHTML ="....";
		var msg = encodeURIComponent(document.getElementById('chatTxt').value);
		new Ajax.Request("chatroommessages.php?method=send&message=" + msg,
		{
			method: 'get',
			onSuccess: postMessageResponse
		});
	}
}
function postMessageResponse(data){
	if(data.responseText == "SUCCESS"){
		document.getElementById('chatTxt').value="ENTER TEXT";
	}else if(data.responseText == "BLOCKED"){
		alert("You have been blocked by the administrator\nplease read our rules for posting in a chatroom");
		window.location = "index.php";
	}else{
		alert("An error occurred please try sending your message again");
	}
	document.getElementById('postBtn').style.backgroundColor ="#dd5d24";
	document.getElementById('postBtn').innerHTML ="Post";
}
function checkChangeChatroom(){
	new Ajax.Request("chatroommessages.php?method=check&chatroom="+roomId,
	{
		method: 'get',
		onSuccess: changeChatroomResponse
	});
	
}
function changeChatroomResponse(data){
	if(data.responseText=="CHANGE"){
		clearTimeout(timer2);
		alert("You can only be in one chatroom at a time");
		window.location = "index.php";

	}else{
	timer2 = setTimeout("checkChangeChatroom()", 9000);
	}
	
	
}
function videoCall(self, recName, name){
	receiverName = recName;
	curUserName = name;
	self.style.background = "url(\"Images/ld.gif\") no-repeat";
	self.style.backgroundSize= "cover";
	self.style.backgroundPosition = "center center";
	curVidBtn= self;
	oncall=true;
	clearTimeout(timer4);
	new Ajax.Request("chatroommessages.php?method=vid&videocall="+recName,
	{
		method: 'get',
		onSuccess: videoCallResponse
	}

		);
}
function videoCallResponse(data){
	if(data.responseText == "SUCCESS"){
		//clearTimeout(timer2);
		window.location = "videocall.php?vidroomname="+receiverName+curUserName;
		
	}else if(data.responseText == "USER_BUSY"){
		alert("Sorry the user is already in a video chat");
		curVidBtn.style.background = "url(\"Images/video.png\") no-repeat";
		curVidBtn.style.backgroundSize= "cover";
		curVidBtn.style.backgroundPosition = "center center";
	}else if(data.responseText == "CUR_USER_BUSY"){
		alert("You are already in a video chat, if you need to do another video chat end the current chat");
	}else{
		alert("An error occurred\n"+data.responseText);
	}
}
function checkReceiveCall(){
	new Ajax.Request("chatroommessages.php?method=checkrecv",
	{
		method: 'get',
		onSuccess: checkReceiveCallResponse
	});
	
}
function checkReceiveCallResponse(data){
	if(data.responseText.substr(0,3) == "YES"){
		//clearTimeout(timer3);
		//alert("New Video Chat"+ data.responseText.substr(3));
		//window.location = "videocall.php?vidroomname="+data.responseText.substr(3);
		var img = data.responseText.split("->")[2];
		var link = data.responseText.split("->")[1];
		var caller_name = data.responseText.split("->")[3];
		document.getElementById('videoChatBar').style.display = "block";
		document.getElementById('caller-img').setAttribute('style',img);
		console.log(img);
		document.getElementById('caller-name').innerHTML = caller_name;
		document.getElementById('caller-info').onclick = function(){
			window.location = "videocall.php?recv=true&vidroomname="+link;
		};
	}else{
		document.getElementById('videoChatBar').style.display = "none";
		
	}
	timer3 = setTimeout("checkReceiveCall()", 6000);
	console.log(data.responseText);
	
}
function rejectCall(){
	new Ajax.Request("chatroommessages.php?method=rejectcall",
	{
		method: 'get',
		onSuccess: rejectCallResponse
	});
}
function rejectCallResponse(data){
	document.getElementById("videoChatBar").style.display="none";
	checkReceiveCall();

}
function uploadUserFile(){
	var file = document.getElementById('chatFile');
	if(file.files.length === 0){
		alert("You have not selected a file");
	}else{
		document.getElementById('upBtn').style.display = "none";
		document.getElementById('anim_img').style.display = "block";
		var data = new FormData();
		data.append('newfile', file.files[0]);
		data.append('method', 'userfile');
		var xml = new XMLHttpRequest();
		xml.onload = uploadUserFileResponse;
		xml.open('POST', 'chatroommessages.php');
		xml.send(data);
	}
}
function uploadUserFileResponse(){
	if(this.responseText.substr(0,4) == "file"){
		//alert("file name:"+ this.responseText.split("-")[1]);
		fileUp = this.responseText.split("<->")[1];
		document.getElementById('anim_img').style.display = "none";
		document.getElementById('chatFile').style.display = "none";
		document.getElementById('upFName').style.display = "block";
		document.getElementById('upStatus').style.display = "block";
		document.getElementById('upFName').innerHTML=fileUp;
	}else{
		alert("error"+this.responseText);
		document.getElementById('anim_img').style.display = "none";
		document.getElementById('upBtn').style.display = "inline";
		document.getElementById('chatFile').style.display = "block";
	}
}
function postUpload(){
	if(fileUp != "None" && document.getElementById('upTxt').value.length>1){
		//document.getElementById('anim_img').style.display = "none";
		document.getElementById('chatFile').style.display = "block";
		document.getElementById('upBtn').style.display = "inline";
		document.getElementById('upFName').style.display = "none";
		document.getElementById('upStatus').style.display = "none";
		var fileMsg = document.getElementById('upTxt').value;
		document.getElementById('blackbox').style.display = "none";
		new Ajax.Request("chatroommessages.php?method=send&file=true&message=" + fileMsg+"&filename="+ fileUp,
		{
			method: 'get',
			onSuccess: postMessageResponse
		});

	}else{
		alert("You need to upload a file and a enter post message");
	}
	
}
function showFileUpload(){
	document.getElementById('blackbox').style.display = "block";
}
function closePopup(){
	fileUp = "None";
	document.getElementById('blackbox').style.display = "none";
	document.getElementById('chatFile').style.display = "block";
	document.getElementById('upBtn').style.display = "inline";
	document.getElementById('upFName').style.display = "none";
	document.getElementById('upStatus').style.display = "none";
}
function growEmoBar(){
	if(emoState == "CLOSED"){
		document.getElementById('emo-bar').style.visibility = "visible";
		document.getElementById('emo-bar').style.opacity = "1";
		document.getElementById('emo-bar').style.height = "auto";

		emoState = "OPEN";
	}else{
		document.getElementById('emo-bar').style.opacity = "0";
		document.getElementById('emo-bar').style.visibility = "hidden";
		document.getElementById('emo-bar').style.height = "0px";
		emoState = "CLOSED";

	}
	
}
function addEmoticon(emo){
	if(chatTxt.value == "ENTER TEXT"){
		chatTxt.value = emo;
	}else{
		chatTxt.value = chatTxt.value + emo;
	}
}