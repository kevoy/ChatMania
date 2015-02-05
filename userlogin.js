window.onload = function(){
	var startBtn = document.getElementById('startBtn');
	startBtn.onclick = validateUser;
	var enterBtn = document.getElementById('newUserName');
	enterBtn.onkeypress = validateUserOnenter;
	var passBtn = document.getElementById('newUserPassword');
	passBtn.onkeypress = validateUserOnenter;
	
}
function validateUser(){
	var newUserName = document.getElementById('newUserName').value;
	var newUserPassword = document.getElementById('newUserPassword').value;
	
	
	if(newUserName == "ENTER YOUR NAME" || newUserName.length <=1 || newUserPassword == "ENTER YOUR PASSWORD" || newUserPassword.length <=3){
		displayError('Enter Your Login Name and password(Aleast 8 characters long, use numbers and letters only)');
	}else{

		new Ajax.Request(
		"processlogin.php?username=" + newUserName+ "&userpassword="+ newUserPassword,
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
	if(e.keyCode === 13){
		
		if(newUserName == "ENTER YOUR NAME" || newUserName.length <=1 || newUserPassword == "ENTER YOUR PASSWORD" || newUserPassword.length <=3){
			displayError('Enter A Name and password(Aleast 8 characters long, use numbers and letters only)');
		}else{

			new Ajax.Request(
			"processlogin.php?username=" + newUserName+ "&userpassword="+ newUserPassword,
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
		window.location = "index.php";
	}else{
		displayError('Invalid Login Credentials');
	}
}

function displayError(errormsg){
	alert(errormsg);
}