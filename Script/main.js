document.getElementById("modal-trigger").onclick = function(){
    var modal = document.getElementById("modal-trigger");
    if(modal.getAttribute("data-toggle") == "false"){
        document.getElementsByClassName("modal")[0].style.display = "block";
    }
};

document.getElementsByClassName("close")[0].onclick = function(){
    document.getElementsByClassName("modal")[0].style.display = "none";
};

document.getElementById("signupbtn").onclick = function(){
    var email = document.forms["signup"]["email"];
    var username = document.forms["signup"]["signupusername"];
    var password = document.forms["signup"]["signuppassword"];
    var name = document.forms["signup"]["name"];
    var address = document.forms["signup"]["shippingaddress"];
    var phonenum = document.forms["signup"]["phonenumber"];
    var flag = true;

    if(isNaN(phonenum.value) || phonenum.value == ""){
        phonenum.style.borderColor = "red";
        flag = false;
    }
    else{
        phonenum.style.borderColor = "#929292";
    }

    if(!email.value.includes(".com") || !email.value.includes("@") || email.value == ""){
        email.style.borderColor = "red";
        flag = false;
    }
    else{
        email.style.borderColor = "#929292";
    }

    if(name.value == ""){
        name.style.borderColor = "red";
        flag = false;
    }
    else{
        name.style.borderColor = "#929292";
    }

    if(address.value == ""){
        address.style.borderColor = "red";
        flag = false;
    }
    else{
        address.style.borderColor = "#929292";
    }

    if(username.value == ""){
        username.style.borderColor = "red";
        flag = false;
    }
    else{
        username.style.borderColor = "#929292";
    }

    if(password.value == ""){
        password.style.borderColor = "red";
        flag = false;
    }
    else{
        password.style.borderColor = "#929292";
    }

    if(flag == true){
        document.getElementById("signupbtn").setAttribute("type","submit");
    }
}

document.getElementById("signinbtn").onclick = function (){
    var username = document.forms["signin"]["signinusername"];
    var password = document.forms["signin"]["signinpassword"];
    var flag = true;

    if(username.value == ""){
        username.style.borderColor = "red";
        flag = false;
    }
    else{
        username.style.borderColor = "#929292";
    }

    if(password.value == ""){
        password.style.borderColor = "red";
        flag = false;
    }
    else{
        password.style.borderColor = "#929292";
    }

    if(flag == true){
        document.getElementById("signinbtn").setAttribute("type","submit");
    }
}

document.getElementById("notsigned").onclick = function (){
  document.getElementsByClassName("modal")[0].style.display = "block";
}
