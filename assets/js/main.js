// Show Password in Login and Reset Password

var password;
var eye;
function show(){
    password =  document.getElementById("password");
    eye = document.getElementById("eye");
    state? showpassword() :  hidepassword();
}

function showconfirm(){
    password =  document.getElementById("confirmpassword");
    eye = document.getElementById("eye1");
    state? showpassword() :  hidepassword();
}

function showpassword(){
    password.setAttribute("type","password");
    eye.style.color='#B6B682';
    state = false;
}

function hidepassword(){
    password.setAttribute("type","text");
    eye.style.color='#5A817A';
    state = true; 
}




// Menu Navbar
let settingsmenu = document.querySelector (".settings-menu");

function settingsMenuToggle(){
   //fix onclick
   settingsmenu.classList.remove("settings-menu-height");
    if ($('.navbar .navbar-toggler').attr('aria-expanded') == 'true'){
        $('button[aria-expanded="true"]').click();
    }
   
   //fix multiple firing event
   var newHandle = function(e) { settingsmenu.classList.toggle("settings-menu-height");   };
    document.addEventListener('click', newHandle,false); 

}


// if user clicks outside the navbar, collapse user menu
function checkMousePointer(){
    
    document.addEventListener('click', function(e) {
       
        if (e.target == settingsmenu && e.target.parentNode == settingsmenu) return;
          settingsmenu.classList.remove("settings-menu-height");
        
    })
}



// JQuery Close Navbar when clicked outside
$(window).on('click', function(event){
    // element over which click was made
    var clickOver = $(event.target)
    if ($('.navbar .navbar-toggler').attr('aria-expanded') == 'true' && clickOver.closest('.navbar').length === 0) {
        $('button[aria-expanded="true"]').click();
    }
    else if ($('.navbar .navbar-toggler').attr('aria-expanded') == 'true') {
        settingsmenu.classList.remove("settings-menu-height");
    }


});




// Change Cover Photo
let coverphoto = document.querySelector("#coverphoto");
let filecover = document.querySelector("#filecover");
if(filecover){
filecover.addEventListener('change', function(){
    //this refers to file
    const choosedCover = this.files[0];
    if (choosedCover) {
        const reader = new FileReader(); //FileReader is a predefined function of JS
        reader.addEventListener('load', function(){
            coverphoto.setAttribute('src', reader.result);
        });
        reader.readAsDataURL(choosedCover);
    }
});
}


// Change Profile Photo
let profilephoto = document.querySelector("#profilephoto");
let fileprofile = document.querySelector("#fileprofile");
let userpic= document.querySelector(".userpic");
if(fileprofile){
fileprofile.addEventListener('change', function(){
    //this refers to file
    const choosedFile = this.files[0];
    if (choosedFile) {
        const reader = new FileReader(); //FileReader is a predefined function of JS
        reader.addEventListener('load', function(){
            profilephoto.setAttribute('src', reader.result);
            userpic.setAttribute('src', reader.result);
        });
        reader.readAsDataURL(choosedFile);
    }
});
}