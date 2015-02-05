var timer1, timer2;
window.onload = function(){
	checkStatus();
}
window.onbeforeunload = function(){
	new Ajax.Request("videoconf.php?method=exit",
	{
		method: 'get',
		onSuccess: exitVideoChat
	});
}
function exitVideoChat(data){

}
function checkStatus(){
	new Ajax.Request("videoconf.php?method=status",
	{
		method: 'get',
		onSuccess: checkStatusResponse
	});
}
function checkStatusResponse(data){
	if(data.responseText == "reject"){
		alert("The user rejected your call...");
		window.history.back();
		clearTimeout(timer1);
	}else if(data.responseText == "inprogress"){
		//alert("The user has joined the video call");
		document.getElementById('vidstatus').innerHTML = "You are currently in a video call";
		document.getElementById('vidcallstatus').style.backgroundColor = "#38C03F";
		clearTimeout(timer1);
		updateTime();
	}else {
		timer1 = setTimeout("checkStatus()", "5 * 10000");
	}
	
}
function updateTime(){
	new Ajax.Request("videoconf.php?method=time",
	{
		method: 'get',
		onSuccess: updateTimeResponse
	});
}
function updateTimeResponse(data){
	if(data.responseText == "cancel"){
		alert("The user has left the chatroom");
		window.history.back();
		clearTimeout(timer2);
	}else {
		timer2 = setTimeout("updateTime()", "7 * 10000");
	}
}