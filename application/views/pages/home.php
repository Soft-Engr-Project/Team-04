<div onclick="checkMousePointer()">
<?php if (!isset($_SESSION['username'])) {
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
                        <?php $no=1; foreach ($postsTop as $post): ?>
                        <p><a href="<?php echo base_url()."posts/view/".$post["id"];?>">
                            <?php echo $no++;?>.<?php echo word_limiter($post["title"],2)?>
                        </a></p>
                        <?php endforeach ?>
                    </div>
                    <div class="allcat">
                        <h2>All Categories</h2>
                    </div>
                    <div class="categories">
                        <?php foreach ($categories as $category): ?>
                            <p>
                                <?php echo $category["name"];?>
                            </p>
                        <?php endforeach; ?>                  
                    </div>
                </div>
            </div>

            <div class="col-lg 10">
                <div class="createthread">
                    <div class="circleimage">
                    <?php if(!empty($user["user_profile_photo"])){ ?>
                        <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" alt="Profile Photo">
                    <?php } else{?>
                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile" alt="Profile Photo">
                    <?php } ?>
                    </div>
                    <div class="threadbox">
                        <a href="<?php echo site_url("posts/create")?>">
                          <p>Create Thread</p>
                        </a>
                    </div>
                    <div class="notification_icon">
                        <em class="fas fa-bell bell_count"></em>
                    </div>
                    <div class="notifdropdown">                        
                        
                    </div>
                    <hr>
                </div>

 <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
document.querySelector('body').style.background = rgbaColor;
</script>
                

<script type="text/javascript">
    function bellCountChecker() {
            
        $.ajax({
            url: "<?php echo base_url();?>notification/bellCountChecker",
            type: "Post",
            data: {
                userID : <?php echo $this->session->userdata("user_id")?>
            },
            success: function(data){
                let result = data.replace(/<!--  -->/g, "");
               data = JSON.parse(result);
                $(".bell_count").html(data);
            }
        })
    }
    bellCountChecker();
    function getNotification(){
     $.ajax({
        url : "<?php echo base_url()?>notification/getNotification",
        type : "POST",
        data :{
            userID : <?php echo $this->session->userdata("user_id")?>
        },
        success: function(data){
             let result = data.replace(/<!--  -->/g, "");
             data = JSON.parse(result);
             notificationBody = "";
             let count = 0;
            
            
             if(data != ""){
                data.forEach(notify => {
                   
                    if(notify["type_of_notif"] == "comment"){
                     notificationBody += `
                        <div class="notify_item">
                            <a href="<?php echo base_url();?>posts/view/${notify['action_id']}">
                            <div class="notify_img">
                                 <div class="circleimage">`;
                                    if(notify["user_profile_photo"]){
                                     
                     notificationBody += `   
                                    <img src="<?php echo base_url();?>${notify['user_profile_photo']}" class="userprofile" >`;
                                    } else{
                     notificationBody += `
                                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">`;
                                    }
                     notificationBody += `
                                 </div>
                            </div>
                            <div class="notify_info">
                                <p>${notify["username"]} commented in your post</p>
                                <span class="notify_time">${notify["notif_created_at"]}</span>
                            </div>
                            </a>`;
                     notificationBody += `
                        <div class="dropdown">
                                    <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                    </button>
                                    <ul class="dropdown-menu">
                                        <label for="remove">
                                            <li class="dropdown-item"> 
                                                <input type="submit" id="remove">
                                                    Remove
                                            </li> 
                                        </label>  
                                    </ul>
                                </div>          
                            </div> 
                     `;
                    }
                    else if(notify["type_of_notif"] == 'react'){
                                    notificationBody += `
                                    <div class="notify_item">
                                        <a href="<?php echo base_url();?>posts/view/${notify['action_id']}">
                                        <div class="notify_img">
                                            <div class="circleimage">`;
                                                      if(notify["user_profile_photo"]){ 
                                                        notificationBody +=`<img src="<?php echo base_url()?>${notify['user_profile_photo']}" class="userprofile" >`
                                                      } else {
                                                        notificationBody +=`<img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">`;
                                                      } 
                                                      notificationBody +=`
                                           </div>
                                        </div>
                                        <div class="notify_info">
                                                <p>${notify["username"]}  reacted to your post</p>
                                                <span class="notify_time">${notify["notif_created_at"]}</span>
                                            </div>
                                            </a>
                                            <div class="dropdown">
                                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                                    <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <label for="remove">
                                                        <li class="dropdown-item"> 
                                                            <input type="submit" id="remove">
                                                                Remove
                                                        </li> 
                                                    </label>  
                                                </ul>
                                            </div>          
                                        </div> 
                                    `;
                                    }
                                    else if(notify["type_of_notif"] == 'reply') {
                                    notificationBody += `
                                    <div class="notify_item">
                                        <a href="<?php echo base_url();?>subcomments/view/${notify['action_id']}">
                                        <div class="notify_img">
                                            <div class="circleimage">`;
                                                if(notify["user_profile_photo"]) { 
                                                    notificationBody += `<img src="<?php echo base_url()?>${notify['user_profile_photo']}" class="userprofile" >`;
                                                } else{ 
                                                    notificationBody += `<img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">`;
                                                } 
                                        notificationBody += ` 
                                            </div>
                                        </div>
                                        <div class="notify_info">
                                            <p>${notify["username"]} reply to your comment</p>
                                            <span class="notify_time">${notify["notif_created_at"]}</span>
                                        </div>
                                        </a>
                                        <div class="dropdown">
                                            <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                                <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <label for="remove">
                                                    <li class="dropdown-item"> 
                                                        <input type="submit" id="remove">
                                                            Remove
                                                    </li> 
                                                </label>  
                                            </ul>
                                        </div>          
                                    </div> 
                                    `;
                                    }
                                    else if(notify["type_of_notif"] == 'reply_react') {
                                        notificationBody += `
                                        <div class="notify_item">
                                            <a href="<?php echo base_url();?>subcomments/view/${notify['action_id']}">
                                            <div class="notify_img">
                                                <div class="circleimage">`;
                                                    if(notify["user_profile_photo"]){ 
                                                        notificationBody += `<img src="<?php echo base_url()?>${notify['user_profile_photo']}" class="userprofile" >`;
                                                    } else{
                                                        notificationBody += `<img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">`;
                                                    }
                                        notificationBody+=`   
                                                </div>
                                            </div>
                                            <div class="notify_info">
                                                    <p>${notify["username"]} reacted to your comment</p>
                                                    <span class="notify_time">${notify["notif_created_at"]}</span>
                                                </div>
                                                </a>
                                                <div class="dropdown">
                                                    <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <label for="remove">
                                                            <li class="dropdown-item"> 
                                                                <input type="submit" id="remove">
                                                                    Remove
                                                            </li> 
                                                        </label>  
                                                    </ul>
                                                </div>          
                                            </div>             
                                        `;
                                        } 
                });
               
             }else{
                notificationBody+=`
                        <div class="notify_item">
                            <p>No Notification Found</p>
                        </div>`;
             }
             $(".notifdropdown").html(notificationBody);

        }
     })
    }

    getNotification();
    setInterval("bellCountChecker()",1000);
    setInterval("getNotification()",3000);

</script>