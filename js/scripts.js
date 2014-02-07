function changeUserSearchTextCriteria(){
	var category = document.getElementById("category").value;
	var input = document.getElementById("search_text");

	if(category == "username"){
		input.title = "Must be 4-30 characters.";
		input.pattern = "[a-z]{1,1}[a-z0-9_]{3,29}";
	}else if(category == "student_number"){
		input.title = "Must be 10 characters.";
		input.pattern = "[0-9]{4}-[0-9]{5}";
	}else if(category == "employee_number"){
		input.title = "Must be 9 characters.";
		input.pattern = "[0-9]{9,9}";
	}else if(category == "first_name" || category == "last_name"){
		input.title = 'Must be 2-30 characters.';
		input.pattern='[A-Za-z]{2,30}' 
	}
}