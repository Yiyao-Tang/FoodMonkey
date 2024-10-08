function chkName(event) {
  var myName = event.currentTarget;
  var pos = myName.value.search(/^[A-Za-z ]+$/);
  if (pos != 0) {
    alert("The name you entered (" + myName.value + 
          ") is not in the correct form. \n" +
          "Name should contains alphabet characters and character spaces only.");
    myName.focus();
    myName.select();
    return false;
  } 
}

function chkEmail(event) {
var myEmail = event.currentTarget;
var pos = myEmail.value.search(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
if (pos != 0) {
    alert("The email you entered (" + myEmail.value +
            ") is not in the correct form. \n");
    myEmail.focus();
    myEmail.select();
    return false;
} 
}

function chkDate(event) {

var myExpiryDate = new Date(event.currentTarget.value);

var today = new Date();

var pos = (myExpiryDate.getTime() > today.getTime());

if (!pos) {
  alert("The date choosen ("+ event.currentTarget.value+")is not in the right form. \n"+
    "You must choose a date after the current date.\n");
  myExpiryDate.focus();
  myExpiryDate.select();
return false;
} 
}


var firstNameNode = document.getElementById("firstName");
var lastNameNode = document.getElementById("lastName");
var emailNode = document.getElementById("email");
var dateNode = document.getElementById("expiryDate");
;

firstNameNode.addEventListener("change", chkName, false);
lastNameNode.addEventListener("change", chkName, false);
emailNode.addEventListener("change", chkEmail, false);
dateNode.addEventListener("change", chkDate, false);