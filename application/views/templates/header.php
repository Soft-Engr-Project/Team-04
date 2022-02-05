<!DOCTYPE html>
<html lang="en">
<head>
    <title>Microblogging Site</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Profile</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js" ></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js" ></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>
    <nav>   
        <ul>
        <nav class="navbar navbar-expand-md navbar-dark bg-* ">
            <div class="container-fluid ">

                <!-- LOGO -->
                <a class="logo" href="<?php echo base_url();?>pages/view" ><strong>Thinklik</strong> </a>

                <!-- HAMBURGER BUTTON -->
                <button type="button" 
                class="navbar-toggler" 
                data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse"
                aria-expanded="false"
                >
                <span class="navbar-toggler-icon"></span>
                </button>

                <!-- HAMBURGER DROPDOWN -->
                <div class="collapse navbar-collapse" id="navbarCollapse" >

                    <!-- Search Bar -->
                    <div class="col-md-5 mx-auto">
                        
                        <?php echo form_open("Search/query_db") ;?>
                        <div class="input-group">
                            <input class="form-control border-end-0 border rounded-pill" type="text" id = "search" name="search" autocomplete = "off">
                            <div id="hidden" style="height: 0px;"></div>
                        </div>
                    </form>
                    </div>

                    <!-- Suggestions -->
                    <script>
                        $(document).on("keyup","#search",function(e){
                         e.preventDefault();
                            $("#search").autocomplete({
                                appendTo: "#hidden",
                                source: function( request, response){
                                    $.ajax({
                                        url: "<?php echo base_url()?>search/suggestions",
                                        type: "post",
                                        data: {
                                            keyword: request.term
                                        },
                                        success : function(data){
                                            keywords = e.target.value;
                                            const seen = new Set();
                                            //console.log(typeof data);
                                            let result = data.replace(/<!--  -->/g, "");
                                            data = JSON.parse(result);
                                            //get unique values
                                            const filteredArr = data.filter(el => {
                                                const duplicate = seen.has(el.label);
                                                seen.add(el.label);
                                                return !duplicate;
                                            });
                                            // sort values alphabetically
                                            filteredArr.sort((a, b) => {
                                                // Sort results by matching input with keyword position in result
                                                if(a.label.toLowerCase().indexOf(keywords.toLowerCase()) > b.label.toLowerCase().indexOf(keywords.toLowerCase())) {
                                                    return 1;
                                                } else if (a.label.toLowerCase().indexOf(keywords.toLowerCase()) < b.label.toLowerCase().indexOf(keywords.toLowerCase())) {
                                                    return -1;
                                                } else {
                                                    if(a.label > b.label)
                                                        return 1;
                                                    else
                                                        return -1;
                                                }
                                            });
                                            //console.log(filteredArr);
                                            response(filteredArr);
                                        }
                                    });
                                },
                                select: function(values, ui){
                                    $('#search').val(ui.item.label);
                                    return false;
                                },
                            });
                        });
                    </script>

                    <!-- Navigation Link Buttons -->
                    <a style="margin:10px !important;" class="nav-item nav-link text-light m-0 p-0" href="<?php echo base_url();?>pages/view">Home</a>
                    <a style="margin:10px !important;" class="nav-item nav-link text-light m-0 p-0" href="<?php echo site_url("profiles/view");?>">Profile</a>
                </div>
            </div>

            <!-- Dropdown Button Profile Photo-->
            <ul style="right:10px; top:5px; margin-bottom: 5px; margin-right: 206px;"class="navbar-nav float-right position-fixed">
                <li style="position:relative;" class="nav-item dropdown">
                    <a class="nav-link " role="button" onclick="settingsMenuToggle()">
                        <?php if(!empty($user["user_profile_photo"])){ ?>
                                <img style="border: 1px solid #000000;" src="<?php echo base_url().$user["user_profile_photo"];?>" alt="Profile Photo" class="userpic rounded-circle position-absolute">
                            <?php }
                            else{?>
                                <img src="<?php echo base_url();?>assets/image/user.png" alt="Profile Photo" class="userpic rounded-circle position-absolute">
                        <?php } ?>
                    </a>
                </li>   
            </ul>
            
            <!-- Dropdown items -->
            <div style="position: fixed; margin-top: 15px;" class="settings-menu" id="settings">
                <div class="settings-menu-inner">
                    <div class="row">
                        <div class="col-lg-4">
                            <a href="<?php echo site_url("profiles/view");?>">
                                <?php if(!empty($user["user_profile_photo"])){ ?>
                                            <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userpic" alt="Profile Photo">
                                        <?php }
                                        else{?>
                                            <img src="<?php echo base_url();?>assets/image/user.png" alt="Profile Photo" class="userpic">
                                <?php } ?>
                            </a>
                        </div>
                        <div class="col-lg-8">
                            <a href="<?php echo site_url("profiles/view");?>"><p> <?php echo $this->session->userdata("username");?> </p> </a>
                        </div>
                        <hr>
                    </div>
                    <a href="<?php echo base_url();?>pages/view/settings">Settings</a>
                    <a href="<?php echo base_url();?>customization/view">Customization</a>
                    <a href="<?php echo base_url();?>pages/view/logout">Logout</a>
                </div>
            </div>
        </nav>
        </ul>
    </nav> 