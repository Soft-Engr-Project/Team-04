<div onclick="checkMousePointer()">
<?php 
  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    redirect("/");
  }
?>
    <div style="height: 100vh;"class="container-fluid">
        <div class="row">
            <div class="col-lg 2">
                <div class="topnamebox">
                    <div class="top">
                        <h2>Top of the Month</h2>
                    </div>
                    <div class="topname">
                        <?php $no=1; foreach ($posts as $post): ?>
                        <p><?php echo $no++;?>.  <a href="<?php echo base_url()."posts/view/".$post["id"];?>"><?php echo word_limiter($post["title"],2)?></a></p>
                        <?php endforeach ?>
                    </div>
                    <div class="allcat">
                        <h2>All Categories</h2>
                    </div>
                    <div class="categories">
                        <?php foreach ($categories as $category): ?>
                            <p><a href="#"><?php echo $category["name"];?> </a></p>
                        <?php endforeach; ?>                  
                    </div>
                </div>
            </div>

            <div class="col-lg 10">
                <div class="createthread">
                    <div class="circleimage">
                    <?php if(!empty($user["user_profile_photo"])){ ?>
                        <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" >
                    <?php } else{?>
                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                    <?php } ?>
                    </div>
                    <div class="threadbox">
                        <a href="<?php echo site_url("posts/create")?>">
                          <p>Create Thread</p>
                        </a>
                    </div>
                    <div class="notification_icon">
                        <i class="fas fa-bell"><?php  echo (!empty($notification_count)) ? $notification_count : ""?></i>
                    </div>
                    <div class="notifdropdown">                        
                        <a href="<?php echo base_url()?>notification/index/<?php echo $this->session->userdata("user_id")?>"><i class="fas fa-bell"><?php  echo (!empty($notification_count)) ? $notification_count : ""?></i></a>
                        <?php if(!empty($notification)){?>
                        <?php foreach ($notification as $notify): ?>
                        <?php if($notify["type_of_notif"] == "comment"){?>
                        <div class="notify_item">
                            <a href="<?php echo site_url("posts/view/".$notify["post_id"]);?>">
                            <div class="notify_img">
                                 <div class="circleimage">
                                    <?php if(!empty($user["user_profile_photo"])){ ?>
                                        <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" >
                                    <?php } else{?>
                                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="notify_info">
                                <p><?php echo $notify["username"]?> commented in your post</p>
                                <span class="notify_time">10 minutes ago</span>
                            </div>
                            </a>
                            <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                     <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <label for="edit">
                                        <li class="dropdown-item">
                                            <input type="submit" id="edit">
                                            Edit
                                        </li> 
                                    </label>
                                    <label for="remove">
                                        <li class="dropdown-item"> 
                                            <input type="submit" id="remove">
                                                Remove
                                        </li> 
                                    </label>  
                                </ul>
                            </div>          
                        </div> 

                        <?php }elseif($notify["type_of_notif"] == 'react'){?>


                        <div class="notify_item">
                            <a href="<?php echo site_url("posts/view/".$notify["post_id"]);?>">
                            <div class="notify_img">
                                 <div class="circleimage">
                                    <?php if(!empty($user["user_profile_photo"])){ ?>
                                        <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" >
                                    <?php } else{?>
                                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="notify_info">
                                <p><?php echo $notify["username"]?>  reacted to your post</p>
                                <span class="notify_time">10 minutes ago</span>
                            </div>
                            </a>
                            <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                     <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <label for="edit">
                                        <li class="dropdown-item">
                                            <input type="submit" id="edit">
                                            Edit
                                        </li> 
                                    </label>
                                    <label for="remove">
                                        <li class="dropdown-item"> 
                                            <input type="submit" id="remove">
                                                Remove
                                        </li> 
                                    </label>  
                                </ul>
                            </div>          
                        </div> 

                        <?php } elseif($notify["type_of_notif"] == 'reply') { ?>

                         <div class="notify_item">
                            <a href="<?php echo site_url("subcomments/view/".$notify["post_id"]);?>">
                            <div class="notify_img">
                                 <div class="circleimage">
                                    <?php if(!empty($user["user_profile_photo"])){ ?>
                                        <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" >
                                    <?php } else{?>
                                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="notify_info">
                                <p><?php echo $notify["username"]?> reply to your comment</p>
                                <span class="notify_time">10 minutes ago</span>
                            </div>
                            </a>
                            <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                     <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <label for="edit">
                                        <li class="dropdown-item">
                                            <input type="submit" id="edit">
                                            Edit
                                        </li> 
                                    </label>
                                    <label for="remove">
                                        <li class="dropdown-item"> 
                                            <input type="submit" id="remove">
                                                Remove
                                        </li> 
                                    </label>  
                                </ul>
                            </div>          
                        </div> 

                        <?php } elseif($notify["type_of_notif"] == 'reply_react') { ?>

                        <div class="notify_item">
                            <a href="<?php echo site_url("subcomments/view/".$notify["post_id"]);?>">
                            <div class="notify_img">
                                 <div class="circleimage">
                                    <?php if(!empty($user["user_profile_photo"])){ ?>
                                        <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" >
                                    <?php } else{?>
                                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="notify_info">
                                <p><?php echo $notify["username"]?> reacted to your comment</p>
                                <span class="notify_time">10 minutes ago</span>
                            </div>
                            </a>
                            <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                     <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <label for="edit">
                                        <li class="dropdown-item">
                                            <input type="submit" id="edit">
                                            Edit
                                        </li> 
                                    </label>
                                    <label for="remove">
                                        <li class="dropdown-item"> 
                                            <input type="submit" id="remove">
                                                Remove
                                        </li> 
                                    </label>  
                                </ul>
                            </div>          
                        </div> 
                        <?php } ?>

                        <?php endforeach ?>
                        <?php }else{?>
                        <div class="notify_item">
                            <p>No Notification Found</p>
                        </div>

                        <?php }?>
                    </div>
                    <hr>
                </div>
