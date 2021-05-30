function checksignin() {
  var x, y , z, text;
  
  x = document.getElementById("email").value;
  y = document.getElementById("password").value;
  z = x.indexOf("@");
 
  
  if (x == "" ) {
  text =("Please Type in Your E-mail");
  }
  else if (z==-1){
   text =("E-mail Must Contain @");
  }
   else if ( y == ""){
	text =("Please Type in Your Password");
   }	
  else if(isNaN(y)) {
    text = "Password Must Only Contain Numbers";
  } else {
    text = "Signed In !";
  }
  document.getElementById("alert").innerHTML = text;
}

function checksignup() {
  var x, y , z,a, text;
  a=document.getElementById("name").value;
  x = document.getElementById("email").value;
  y = document.getElementById("password").value;
  b=document.getElementById("re_password").value;
  z = x.indexOf("@");
 
  if(a==""){
	  text =("Please Type in Your Name");
  }
  else if (x == "" ) {
  text =("Please Type in Your E-mail");
  }
  else if (z==-1){
   text =("E-mail Must Contain @");
  }
   else if ( y == ""){
	text =("Please Type in Your Password");
   }
  else if ( b == ""){
	text =("Please Re-Type Your Password");
   }
   else if ( b != y){
	text =("Passwords Doesn't Match !");
   }    
  else if(isNaN(y)) {
    text = "Password Must Only Contain Numbers";
  } else {
    text = "Signed In !";
  }
  document.getElementById("alert").innerHTML = text;
}

function check(){
 var x=document.getElementById("che").value;


if(x%5 == 0){
 document.getElementById("alert2").innerHTML = "The Number Is Divisable by 5";
}
else {
 document.getElementById("alert2").innerHTML = "The Number Is Not Divisable by 5";
}

if(x%11 == 0){
 document.getElementById("alert3").innerHTML = "The Number Is Divisable by 11";
}
else {
document.getElementById("alert3").innerHTML ="The Number Is Not Divisable by 11";
}



}

  
  