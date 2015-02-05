window.onload = function(){
	var startBtn = document.getElementById('startBtn');
	startBtn.onclick = validateUser;
	var enterBtn = document.getElementById('newUserName');
	enterBtn.onkeypress = validateUserOnenter;
	var passBtn = document.getElementById('newUserPassword');
	passBtn.onkeypress = validateUserOnenter;
	var selectFileBtn = document.getElementById('file');
	selectFileBtn.onchange = displayPreview;
}
function validateUser(){
	var newUserName = document.getElementById('newUserName').value;
	var newUserPassword = document.getElementById('newUserPassword').value;
	var sex = document.getElementById('male');
	if(sex.checked){
		sex= 'M';
	}else{
		sex = 'F';
	}
	if(newUserName == "ENTER YOUR NAME" || newUserName.length <=1 || newUserPassword == "ENTER YOUR PASSWORD" || newUserPassword.length <=3){
		displayError('Enter A Name and password(Aleast 8 characters long, use numbers and letters only)');
	}else{

		new Ajax.Request(
		"newuser.php?username=" + newUserName+"&sex="+ sex + "&room=" +roomNum + "&userpassword="+ newUserPassword,
		{
			method: 'get',
			onSuccess: checkError
		}
		);
	}
	

}
function validateUserOnenter(e){
	var newUserName = document.getElementById('newUserName').value;
	var newUserPassword = document.getElementById('newUserPassword').value;
	var sex = document.getElementById('male');
	if(e.keyCode === 13){
		if(sex.checked){
			sex= 'M';
		}else{
			sex = 'F';
		}
		if(newUserName == "ENTER YOUR NAME" || newUserName.length <=1 || newUserPassword == "ENTER YOUR PASSWORD" || newUserPassword.length <=3){
			displayError('Enter A Name and password(Aleast 8 characters long, use numbers and letters only)');
		}else{

			new Ajax.Request(
			"newuser.php?username=" + newUserName+"&sex="+ sex + "&room=" +roomNum + "&userpassword="+ newUserPassword,
			{
				method: 'get',
				onSuccess: checkError
			}
			);
		}
	}
	
	

}

function checkError(data){
	if(data.responseText == 'Success'){
		//window.location = "chat.php?room=" +roomNum;
		document.getElementById('blackbox').style.display = 'block';
	}else{
		displayError('The name already exists');
	}
}

function displayError(errormsg){
	alert(errormsg);
}
function displayPreview(){
	//alert('ok');
	if(this.files && this.files[0] && document.getElementById('up-img').checked){
		var reader = new FileReader();

		reader.onload = function(e){
			var imgPrev = document.getElementById('upd-invisible');
			imgPrev.style.background = 'url(\'' + e.target.result + '\') no-repeat';
			imgPrev.style.backgroundSize = 'Cover';
			imgPrev.style.backgroundPosition = 'Center Center';
		}
		reader.readAsDataURL(this.files[0]);
	}
}