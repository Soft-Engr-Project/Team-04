
// Menu Navbar
var settingsmenu = document.querySelector (".settings-menu");

function settingsMenuToggle(){
    settingsmenu.classList.toggle("settings-menu-height");
}


// Change Cover Photo
let coverphoto = document.querySelector("#coverphoto");
let filecover = document.querySelector("#filecover");
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


// Change Profile Photo
let profilephoto = document.querySelector("#profilephoto");
let fileprofile = document.querySelector("#fileprofile");
let userpic= document.querySelector(".userpic");

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