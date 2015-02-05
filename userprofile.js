var curFile= "";
var fileUp="";
var user = "";
var userShareMode = false;
var receiverName, curUserName, curVidBtn;
window.onload = function(){
	document.getElementById('search-btn').onclick = getUsers;
	document.getElementById('up-user').onclick = putShareFile;
	//document.getElementById('up-bt').onclick = showUploadPane;
	document.getElementById('upBtn').onclick = uploadUserFile;
	document.getElementById('select-upload').onclick = showUploadPane;
	document.getElementById('select-myfiles').onclick = showMyFilesPane;
	//document.getElementById('user-share-btn').onclick = showSelectPane;
	//document.getElementById('name-val').onkeyup = getUsers;
	checkReceiveCall();
}
function showMyFilesPane(){
	hidePopup('select-edit-box');
	displayPopup('u-upload-edit-box');
}
function showSelectPane(){
	userShareMode = true;
	displayPopup('select-edit-box');
}
function showUploadPane(){
	hidePopup('select-edit-box');
	displayPopup('upload-edit-box2');
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
		if(userShareMode == true){
			user = user2;
			curFile = fileUp;
			putShareFile();
		}
	}else{
		alert("error"+this.responseText);
		document.getElementById('anim_img').style.display = "none";
		document.getElementById('upBtn').style.display = "inline";
		document.getElementById('chatFile').style.display = "block";
	}
}
function setName(name, e){
	user =name;
	var fils = document.getElementById('name-result-bar').getElementsByClassName('name-result-box');
	for(var i=0; i<fils.length; i++){
		fils[i].style.backgroundColor = "#E4E2E2";

	}
	e.style.backgroundColor = "#7B7BFF";
}
function getUsers(){
	var name = document.getElementById('name-val').value;
	var data = new FormData();
	data.append('method', 'getuser');
	data.append('name', encodeURIComponent(name));
	var xml =new XMLHttpRequest();
	xml.onload = processSearch;
	xml.open('POST', 'processsharefile.php');
	xml.send(data);
}
function processSearch(){
	if(this.responseText.substr(0,7) == "success"){
		document.getElementById('name-result-bar').innerHTML = this.responseText.split('<->')[1];
	}else if(this.responseText.substr(0,9) == "nosuccess"){
		document.getElementById('name-result-bar').innerHTML = "Sorry, No User With That Name...";
	}else{
		alert("Error: "+ this.responseText);
	}
}
function shareFile(fName){
	displayPopup('share-edit-box');
	curFile=fName;
}
function deleteFile(fName, sender){
	var data = new FormData();
		data.append('method', 'delete');
		data.append('filename', fName);
		data.append('sender', sender);
		var xml = new XMLHttpRequest();
		xml.onload = processDeleteFile;
		xml.open('POST', 'processsharefile.php');
		xml.send(data);
}
function processDeleteFile(){
	if(this.responseText == "success"){
		alert("File Deleted Successully");
	}else{
		alert("Error "+ this.responseText);
	}
}
function putShareFile(){
	if(user.length >0){
		var data = new FormData();
		data.append('method', 'share');
		data.append('filename', curFile);
		data.append('user', encodeURIComponent(user));
		var xml = new XMLHttpRequest();
		xml.onload = processShareFile;
		xml.open('POST', 'processsharefile.php');
		xml.send(data);
	}else{
		alert("Please Select a User to Share the File With");
	}
	

}
function processShareFile(){
	if(this.responseText == "success"){
		alert("File Shared Successully");
	}else{
		alert("Error: "+this.responseText);
	}
}
function setFName(fName, e){
	curFile = fName;
	user = user2;
	var fils = document.getElementById('name-result-bar2').getElementsByClassName('u-f-name');
	for(var i=0; i<fils.length; i++){
		fils[i].style.backgroundColor = "#E4E2E2";

	}
	e.style.backgroundColor = "#7B7BFF";
}
function shareFile2(){
	if(curFile.length>1){
		putShareFile();
	}else{
		alert("Please Select a File To Share");
	}
	
}
function displayPopup(id){
	document.getElementById('blackbox').style.display = "block";
	document.getElementById(id).style.display = "block";
}
function hidePopup(id){
	document.getElementById('blackbox').style.display = "none";
	document.getElementById(id).style.display = "none";
}
function videoCall(self, recName, name){
	receiverName = recName;
	curUserName = name;
	self.style.backgroundColor = "#4F4F4F";
	self.innerHTML="Calling...";
	curVidBtn= self;
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
		self.style.backgroundColor = "#7B7BFF";
		self.innerHTML="Video Call";
	}else if(data.responseText == "CUR_USER_BUSY"){
		alert("You are already in a video chat, if you need to do another video chat end the current chat");
	}else{
		alert("An error occurred\n"+data.responseText);
	}
}