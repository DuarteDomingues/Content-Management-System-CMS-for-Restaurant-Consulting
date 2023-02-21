function FormRegistValidator(theForm, passwordFilter, telephoneFilter, emailFilter) {

	

   if ( passwordValidator(theForm, passwordFilter) === false || telephoneValidator(theForm, telephoneFilter) === false ||  emailValidator(theForm, emailFilter)===false ){
    	event.preventDefault();
      return false;
  }
  
  else{
  return true;
  
  }
}

 
function emailValidator(theForm, emailFilter){

	if (theForm.email.value!= "" && theForm.email.value!= null ){
    if ( !emailFilter.test( theForm.email.value ) ) {
        alert('Please provide a valid e-mail address');
        theForm.email.focus();
        return false;
  }
  }

  return true;


}

function passwordValidator(theForm, passwordFilter){


	if (theForm.password.value!= "" && theForm.password.value!= null ){
    if ( !passwordFilter.test( theForm.password.value ) ) {
    alert('The password must have at least 8 characters and a upper case character.');
    theForm.password.focus();
    return false;
    }
  }

  

  return true;


}


function telephoneValidator(theForm, telephoneFilter){


if (theForm.telephone.value != "" && theForm.telephone.value != null ){
    if ( !telephoneFilter.test( theForm.telephone.value ) ) {
    alert('Phone number must have 9 numeric digits');
    theForm.telephone.focus();
    return false;
  }

  


  return true;


}







function FormRegistValidatorEdit(theForm, passwordFilter, emailFilter) {


  if ( theForm.username.value === "" ) {
    alert("You must enter a valid name.");
    theForm.username.focus();
    return false;
  }
   if (emailValidator(theForm, emailFilter) === false || passwordValidator(theForm, passwordFilter) === false){
      return false;
  }

  return true;
}
