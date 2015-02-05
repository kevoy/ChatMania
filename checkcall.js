var timer3;

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
	timer3 = setTimeout("checkReceiveCall()", 7000);
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