<!DOCTYPE html>
<html lang="en">
<head>
    <title>Microblogging Site</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Profile</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- style -->
    <style type="text/css">
        .logo a{
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <nav>   
        <ul>
            <li class="logo"> <a href="<?php echo base_url();?>pages/view">Thinklik</a> </li>
            <label class="icon">
                <img src="<?php echo base_url();?>assets/image/magnifier.png" alt="magnifier" width="35px" height="35px">
            </label>
            <li class="search-icon">
                <input type="search" placeholder="Search here">
            </li>
            <div class="items">
                <li><a href="<?php echo base_url();?>pages/view">Home</a></a></li>
                <li><a href="<?php echo site_url("profiles/view");?>">Profile</a></li>
            </div>
            <li>
                <div class="menuimage">
                    <div class="iconmenu" onclick="settingsMenuToggle()"> 
                        <img src="<?php echo base_url();?>assets/image/menu.png" alt="menu" width="40px" height="40px">
                    </div>
                </div>
            </li>
            <div class="settings-menu" >
                <div class="settings-menu-inner">
                    <div class="row">
                        <div class="col-lg-4">
                            <img src="<?php echo base_url();?>assets/image/user.png" class="userpic" >
                        </div>
                        <div class="col-lg-8">
                            <a href="<?php echo site_url("profiles/view");?>"><p> <?php echo $this->session->userdata("username");?> </p> </a>
                        </div>
                        <hr>
                    </div>
                    <a href="<?php echo base_url();?>pages/view/setting">Settings</a>
                    <a href="#">Customization</a>
                    <a href="<?php echo base_url();?>pages/view/logout">Logout</a>
                </div>
            </div>
        </ul>
    </nav>

    



    
