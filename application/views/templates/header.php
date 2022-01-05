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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
</head>
<body>
    <nav>   
        <ul>
        <nav class="navbar navbar-expand-md navbar-dark bg-* ">
            <div class="container-fluid ">
                <a class="logo" href="<?php echo base_url();?>pages/view" ><strong>Thinklik</strong>
                

                </a>
                <button type="button" 
                class="navbar-toggler" 
                data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse"
                aria-expanded="false"
                >
                <span class="navbar-toggler-icon"></span>

                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse" >
                    <div class="col-md-5 mx-auto">
                        <div class="input-group">
                            <input class="form-control border-end-0 border rounded-pill" type="search" placeholder="search">
                            <span class="input-group-append">
                                <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
      
                    <a class="nav-item nav-link text-light" href="<?php echo base_url();?>pages/view">Home</a>
                    <a class="nav-item nav-link text-light" href="<?php echo site_url("profiles/view");?>">Profile</a>
                    
                
                    
                        
                </div>
                 


            </div>
            <ul style="right:10px; top:5px; margin-bottom: 5px; margin-right: 227px;"class="navbar-nav float-right position-fixed  ">
                            <li style="position:relative;" class="nav-item dropdown">
                                <a class="nav-link " role="button" onclick="settingsMenuToggle()">
                                    <?php if(!empty($user["user_profile_photo"])){ ?>
                                            <img style="border: 1px solid #000000;" src="<?php echo base_url().$user["user_profile_photo"];?>" class="userpic rounded-circle position-absolute">
                                        <?php }
                                        else{?>
                                            <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userpic rounded-circle position-absolute">
                                    <?php } ?>
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?php echo base_url();?>pages/view/setting">Settings</a>
                                    <a href="#">Customization</a>
                                    <a href="<?php echo base_url();?>pages/view/logout">Logout</a>
                                </div>
                            </li>   
            </ul>
                     <!--   -->
                     <div style="position: fixed; margin-top: 15px;"class="settings-menu" >
                <div class="settings-menu-inner">
                    <div class="row">
                        <div class="col">
                            <a href="<?php echo site_url("profiles/view");?>">
                                <?php if(!empty($user["user_profile_photo"])){ ?>
                                            <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userpic" >
                                        <?php }
                                        else{?>
                                            <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userpic">
                                <?php } ?>
                            </a>
                        </div>
                        <div style="margin-right: 22px;" class="col">
                        <a href="<?php echo site_url("profiles/view");?>"><p> <?php echo $this->session->userdata("username");?> </p> </a>
                        </div>
                        <hr>
                    </div>
                    <a href="<?php echo base_url();?>pages/view/settings">Settings</a>
                    <a href="#">Customization</a>
                    <a href="<?php echo base_url();?>pages/view/logout">Logout</a>
                </div>
            </div>
        </nav>
        </ul>
    </nav>


    



    
