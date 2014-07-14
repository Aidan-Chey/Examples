var firstName = "";

//Login

function checkLogin(){
	var nCorrect = 0;
	var eCorrect = 0;
	var logName = document.getElementById('loginN').value;
	var	logEmail = document.getElementById('loginE');

//Name
	if(logName == ''){
		document.getElementById('errorN').innerHTML = 'Please fill out this field.';
	}
	else{
		if (logName.indexOf(' ') <= 0 || logName.substring(logName.length-1) == ' '){
	    	document.getElementById('errorN').innerHTML = 'Please enter your Full Name, must be atleast 2 names separated by a space.';
	    }
	    else{
	    	document.getElementById('errorN').innerHTML = '';
	    	nCorrect = 1;
	    }
	}

//Email
    if(logEmail.validity.valid){
    	document.getElementById('errorE').innerHTML = '';
    	eCorrect = 1;
    }
    else{
   		document.getElementById('errorE').innerHTML = logEmail.validationMessage;
    }

//Check if Name and Email are corrct
    if(eCorrect > 0 && nCorrect > 0){
    	firstName = logName.substring(0, logName.indexOf(' '));
    	firstName = upFirst(firstName);
    	pageSwitch();
    }
    else{
    	nCorrect = 0;
    	eCorrect = 0;
    }
}

//Hide login page, Show Quiz page
function pageSwitch(){
	document.getElementById('login').className = 'hide';
	document.getElementById('quiz').className = 'show';
}

//Quizz

//Activtes on Submission
function submitQuiz(){
	var qAmount = document.getElementsByTagName("fieldset").length;
	var notAnswered = "";
	var quizResults = new Array();
	var numCorrect = 0;
	for(i=1; i<=qAmount; i++){
		var isChecked = 0;
		var Questions = document.getElementById("Q"+i);
		var Choices = document.getElementsByName("Q"+i);

//resets Question text color
		Questions.className = "normal";

//checks if Question is answered
		for(a=0; a<Choices.length; a++){
			if(Choices[a].checked){
				isChecked = 1;
				if(parseInt(Choices[a].value) == 1){
					quizResults[i] = 1;
				}
				else{
					quizResults[i] = 0;
				}
			}
		}

//If Question not answered
		if(isChecked == 0){
			Questions.className = "wrong";
			notAnswered = 1;
		}

	}

//Output if Questions are Answered or Not
	if(notAnswered != ""){
		alert("Please answer all Questions.\nThe ones you missed are marked in red.");
	}
	else{
		//colouring the Questions
		for(i=1; i<=qAmount; i++){
			var Questions = document.getElementById("Q"+i);
			if(quizResults[i] == 0){
				Questions.className = "wrong";
			}
			else{
				Questions.className = "correct";
				numCorrect ++; //Counting correct questions
			}
		}
		document.getElementById("key").className = "show";
		alert("Thank you "+firstName+". You scored a "+numCorrect+"/"+qAmount+"!\nYour results are now shown!");
	}
}

// Reset legend color when question clicked on
function legendReset(n){
	console.log(n.children[0].className = 'normal');
}

//Capitalises the First Letter of the string
function upFirst(string){
    return string.charAt(0).toUpperCase() + string.slice(1);
}