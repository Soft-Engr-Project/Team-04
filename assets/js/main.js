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
var el = document.getElementById('settings');

function settingsMenuToggle(){
   //fix onclick
   settingsmenu.classList.remove("settings-menu-height");

   //if profile dropdown is opened, close Navigation bar dropdown
    if ($('.navbar .navbar-toggler').attr('aria-expanded') == 'true'){
        $('button[aria-expanded="true"]').click();
    }
   // open/close profile dropdown
   settingsmenu.classList.toggle("settings-menu-height"); 
   
    //block element to display, else turn off profile dropdown
    el.style.display = (el.style.display === "block") ? "none" : "block";
}

// close profile dropdown if user click outside div
function checkMousePointer(){
    if(el.style.display === "none"){
        el.style.display = "block";
    }
     el.style.display = (el.style.display === "block") ? "none" : "none";
}

// JQuery Close Navbar when clicked outside
$(window).on('click', function(event){
    // store value over which click was made
    var clickOver = $(event.target)
    //if user click outside div, close navbar
    if ($('.navbar .navbar-toggler').attr('aria-expanded') == 'true' && clickOver.closest('.navbar').length === 0) {
        $('button[aria-expanded="true"]').click();
    }
    else if ($('.navbar .navbar-toggler').attr('aria-expanded') == 'true'  && clickOver.closest('.navbar').length === 1) {
        //initialize value if navbar is opened first then profile is opened next
        if(el.style.display !== "block" && el.style.display !== "none"){
            el.style.display = "none";
        }
        else if(el.style.display === "block"){
            el.style.display = "none";
        }
    }
    //if dropdown hamburger is closed, enable profile dropdown
    if(settingsmenu.classList.contains("settings-menu-height") == false){
        if(el.style.display === "none"){
            el.style.display = "block";
        }
       el.style.display = (el.style.display === "block") ? "none" : "block";
    }
    //if both dropdown hamburger and profile is opened at the same time
    else if ($('.navbar .navbar-toggler').attr('aria-expanded') == 'true'  && clickOver.closest('.navbar').length === 1 && settingsmenu.classList.contains("settings-menu-height")) {
        if(el.style.display === "block")
            el.style.display = "none";
        settingsmenu.classList.remove("settings-menu-height");
    }
});

// Simple example, see optional options for more configuration.
const pickr = Pickr.create({
    el: '.color-picker',
    theme: 'classic', // or 'monolith', or 'nano'
    default: '#000',
    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 0.95)',
        'rgba(156, 39, 176, 0.9)',
        'rgba(103, 58, 183, 0.85)',
        'rgba(63, 81, 181, 0.8)',
        'rgba(33, 150, 243, 0.75)',
        'rgba(3, 169, 244, 0.7)',
        'rgba(0, 188, 212, 0.7)',
        'rgba(0, 150, 136, 0.75)',
        'rgba(76, 175, 80, 0.8)',
        'rgba(139, 195, 74, 0.85)',
        'rgba(205, 220, 57, 0.9)',
        'rgba(255, 235, 59, 0.95)',
        'rgba(255, 193, 7, 1)'
    ],

    components: {

        // Main components
        preview: true,
        opacity: true,
        hue: true,

        // Input / output Options
        interaction: {
            hex: true,
            rgba: true,
            input: true,
            save: true
        }
    }
});

// pickr.on('init', instance => {
//     console.log('Event: "init"', instance);
// }).on('hide', instance => {
//     console.log('Event: "hide"', instance);
// }).on('show', (color, instance) => {
//     console.log('Event: "show"', color, instance);
// }).on('save', (color, instance) => {
//     console.log('Event: "save"', color, instance);
// }).on('clear', instance => {
//     console.log('Event: "clear"', instance);
// }).on('change', (color, source, instance) => {
//     console.log('Event: "change"', color, source, instance);
// }).on('changestop', (source, instance) => {
//     console.log('Event: "changestop"', source, instance);
// }).on('cancel', instance => {
//     console.log('Event: "cancel"', instance);
// }).on('swatchselect', (color, instance) => {
//     console.log('Event: "swatchselect"', color, instance);
// });

// // Function to create the cookie
// function createCookie(name, value, days) {
//     var expires;
      
//     if (days) {
//         var date = new Date();
//         date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
//         expires = "; expires=" + date.toGMTString();
//     }
//     else {
//         expires = "";
//     }
      
//     document.cookie = escape(name) + "=" + 
//         escape(value) + expires + "; path=/";
// }



// pickr.on('change', (color, source, instance) => {
//     const rgbaColor = color.toRGBA().toString();
//     console.log(rgbaColor);
//     document.querySelector('body').style.background = rgbaColor;
// }).on('save', (color, instance) => {
//     const rgbaSave = color.toRGBA().toString();
//      // save to db
//     createCookie("colorSave", rgbaSave, "10");

//     var colors = {
//         color : rgbaSave,
//         submit : true
//     };

//     $.ajax({
//      url: '<?php echo base_url();?>Customization/uploadColor',
//      type: 'POST',
//      data: colors,
//      success: function(result){
//         console.log(result);
//      }
//    });



// }).on('clear', instance => {
//      rgbaClear = "rgba(255, 255, 255, 1)";
//      document.querySelector('body').style.background = rgbaClear;
// })

    // Review Cover Photo
let coverphoto = document.querySelector("#smallcover");
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

let profilephoto = document.querySelector("#smallprofile");
let fileprofile = document.querySelector("#filepro");
fileprofile.addEventListener('change', function(){
    let choosedFile = this.files[0];
    if (choosedFile) {
        const reader = new FileReader(); //FileReader is a predefined function of JS
        reader.addEventListener('load', function(){
            profilephoto.setAttribute('src', reader.result);
        });
        reader.readAsDataURL(choosedFile);
    }

});
