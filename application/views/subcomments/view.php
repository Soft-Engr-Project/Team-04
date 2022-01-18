<br>
<br>
<br>
<br>
<br>
                    <?php foreach($subcomment as $reply) : ?>
                    <div class="comments">
                    <div class="circleimage">
                            <img src="<?php echo base_url();?>assets/image/user.png" class="userprofile">                                
                            </div>
                            <div class="row"> 
                            <div class="col-lg-3">    
                                <a href=""><h2><?php echo $reply["username"]?></h2></a>
                            </div>  
                            <div class="col-lg-9">    
                                <div class="commentdropdown">
                              
                                <?php if($this->session->userdata("user_id") == $reply["user_id"] || $this->session->userdata("admin") == true){?>
                                <div class="dropdown" name="delete_edit">
                                        <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                                <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-item">
                                                <!-- <input type="submit" id="edit" >
                                                <label for="edit" id="edit" name="delete_edit" value="<?php echo $reply['subcomment_id']?>">Edit</label> -->
                                                <a href="<?php echo site_url("subcomments/edit/".$reply['subcomment_id'])?>">Edit</a>
                                            </li>
                                            <li class="dropdown-item"> 
                                                <!-- <input type="submit" id="remove">
                                                    <label for="remove"  id = "del" name="delete_edit" value="<?php echo $reply['subcomment_id']?>">Remove</label>   -->
                                                    <a href="<?php echo site_url("subcomments/delete/".$reply['subcomment_id'])?>">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php }
                                elseif($this->session->userdata("user_id") != $reply["user_id"]) { ?>
                                <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                            <a href="#" id="report_button" name="discussion"  value="${element['comment_id']}">Report</a>
                                    </li>
                                </ul>
                            </div>
                            <?php } ?>
                            </div>                              
                            </div>  
                        </div> 
                        <div id='containeredit<?php echo $reply["comment_id"]?>'>
                          <div class="comment_edit" style="display:none;" id="textarea_container">
                            <form action="" method="POST" id="edit_form">
                            <input type="hidden" id="edit_id" value="">
                                    <textarea  class="text" id="edit_textarea<?php echo $reply['comment_id']?>" name="edit_comment"></textarea>
                                    <button class="button1" id="update_comment">Update</button>
                                    <button id="back_comment">Cancel</button>
                            </form>
                          </div> 
                       </div>
                       <div class="commentuser" id='edit_container${element["comment_id"]}'>
                         <p id="comment_owner"><?php echo $reply["reply"]?></p>                     
                       </div>
                       <div id='edit_container1${element["comment_id"]}'>
                       <div class="threadmore" id="comment_reaction">
                            <div class="reaction">
                                    <!-- <button id="upvote_comment" name="upvote_downvote" value="<?php echo $reply["comment_id"]?>">
                                        <i class="fa fa-thumbs-up fa-lg"></i>                               
                                        <input type="numberlike" id="input1" value="<?php echo $reply["sub_upvote"]?>" name="">
                                    </button> -->
                                    <form action="<?php echo base_url();?>subcomments/reaction" method="POST">
                                      <input type="hidden" name="subcomment_id" value="<?php echo $reply["subcomment_id"]?>">
                                      <button type="submit" id="upvote_comment" name="type_of_vote" value="up_react">
                                          <i class="fa fa-thumbs-up fa-lg"></i>                               
                                          <input type="numberlike" id="input1" value="<?php echo $reply["sub_upvote"]?>" name="">
                                      </button>
                                    </form>
                                    <form action="<?php echo base_url();?>subcomments/reaction" method="POST">
                                      <input type="hidden" name="subcomment_id" value="<?php echo $reply["subcomment_id"]?>">
                                      <button type="submit" id="downvote_comment" name="type_of_vote" value="down_react" >
                                          <i class="fa fa-thumbs-down fa-lg" ></i>
                                          <input type="numberlike" id="input1" value="<?php echo $reply["sub_downvote"]?>" name="">
                                      </button>
                                    </form>
                            </div> 
                            <div class="whatcategory">
                                <h4>Commented on: <?php echo $reply["sub_create_at"]?></h4>
                            </div>
                        </div>
                    </div>
                    </div>  


                    </div>
                    <?php endforeach;?>
                    <div class="comments">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="circleimage">
                                <?php if(!empty($user["user_profile_photo"])){ ?>
                                    <img  class="userprofile" src="<?php echo base_url().$user["user_profile_photo"];?>" alt="Profile Pic">
                                <?php }
                                else{?>
                                    <img class="userprofile" src="<?php echo base_url();?>assets/image/user.png" alt="Profile Pic">
                                <?php } ?>    
                                </div>         
                            </div>
                            <div class="col-lg-9">
                                <div class="commentuser">
                                <?php echo validation_errors();?>
                                    <form action="<?php echo base_url()?>subcomments/create" method="POST" id="create_form"> 
                                        <input type="hidden" id="create_post_id"   name="comment_id" value="<?php echo $commentId;?>" >
                                        <textarea class="text" type="comment" id="create_comment" name="reply" placeholder="Repy to this Comment"></textarea>
                                        <button type="submit" id="create">reply</button>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div>
                    