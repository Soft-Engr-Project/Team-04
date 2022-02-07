<div onclick="checkMousePointer()">
<div style="height: 100vh;"class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="viewthreadpic">
                    <?php if(!empty($post["user_profile_photo"])){ ?>
                        <img  src="<?php echo base_url().$post["user_profile_photo"];?>" alt="Profile Pic">
                    <?php }
                    else{?>
                        <img src="<?php echo base_url();?>assets/image/user.png" alt="Profile Pic">
                    <?php } ?>

                </div>
                <div class="threadcreatorname">
                    <h3><a href="<?php echo base_url()."profiles/view/".$post["user_id"];?>"><?php echo ucfirst($post["username"]);?></a></h3>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="threadspost">
                    <div class="row">
                        <div class="col-lg-10">
                            <h1><?php echo $post["title"];?></h1>
                            <?php if(isset($post["post_image"]) && !empty($post["post_image"])):?>
                            <img src="<?php echo base_url().$post["post_image"];?>" alt="" width="300"> 
                            <?php endif;?>
                        </div>
                        <div class="col-lg-1">
                          <?php if($this->session->userdata("user_id") == $post["user_id"] || $this->session->userdata("admin") == true ) :?>
                            <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <label for="editpost">
                                    <li class="dropdown-item">
                                      <?php echo form_open("posts/edit/".$post["id"]);?>
                                        <input type="submit" id="editpost">
                                            Edit
                                      </form>
                                    </li>
                                    </label>  

                                    <label for="remove">
                                    <li class="dropdown-item"> 
                                      <?php echo form_open("posts/delete/".$post["id"]);?>
                                        <input type="submit" id="remove">
                                            Remove 
                                      </form>
                                    </li>
                                    </label> 
                                </ul>
                            </div>

                          <?php elseif($this->session->userdata("user_id") != $post["user_id"]) :?>
                            <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                     <a href="#" id="report_button" name="thread" value= "<?php echo $post["id"]?>">
                                    <li class="dropdown-item">
                                           Report
                                    </li>
                                    </a>
                                    
                                </ul>
                            </div>
                          <?php endif;?>

                            <!-- Modal for report action -->
                            <div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" >
                                <div class="modal-content">

                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Report</h5>
                                  </div>

                                  <!-- Modal Body -->
                                  <div class="modal-body">
                                    <div class="statusMsg"></div>
                                    <form role="form" id="report_form">
                                      <div class="form-group">
                                      <input type="hidden" id="content_id" name="id" value="">
                                        <input type="hidden" id="report_type" name="report_type" value="">
                                        <label for="message-text" class="col-form-label">Reason:</label>
                                        <textarea name = "reason" class="form-control" id="message-text"></textarea>
                                      </div>
                                    </form>
                                  </div>

                                  <!-- Modal Footer -->
                                  <div class="modal-footer">
                                  <!--  <button type="button" id="report_close" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                    <a href="#" class="btn btn-secondary" id="report_close">Close</a>
                                    <a href="#" class="btn btn-primary" id="userSubmit" value="<?php echo $post["id"];?>">Submit</a>
                                    </form>
                                  </div>
                                  
                                </div>
                              </div>
                            </div>


                        </div>
                    </div>
                    <div>
                        <img src="" alt="">
                        <h3><?php echo $post["body"];?></h3>
                    </div>
                    <h6>Posted on: <?php echo $post["post_created_at"];?></h6>    
                    
                    <div class="threadmore" id="posting">
                        <div class="reaction">
                            <div class="upbutton">
                              

                              <button name="submit" id="upvote_post" value="<?php echo $post["id"]?>">
                                <em class="fa fa-thumbs-up fa-lg"></em>
                            
                                <input type="numberlike" value="<?php echo $post["upvote"] ;?>">
                              </button>
                            
                            </div>

                            <div class="downbutton">
                              
                                <button name="submit" id="downvote_post" value="<?php echo $post["id"]?>">
                                    <em class="fa fa-thumbs-down fa-lg"></em>
                                    
                                    <input type="numberlike" value="<?php echo $post["downvote"];?>">
                                </button>
                              </form>
                            </div>
                        </div> 
                        <div class="totalcomments commentCount">
                            <img src="<?php echo base_url();?>assets/image/comment.png" alt="">
                            <input type="numberlike" id="input1" value="<?php echo $post["post_comment_count"]?>" name="totalcommentCount">

                        </div>
                        <div class="whatcategory">
                            <h4>Categories: </h4>
                            <a href=""><?php echo $post["name"];?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="between">

        <div class="row">
            <div class="col-lg-3">
                <div class="randomthreadtitle">
                    <div class="top">
                        <h2>Random Threads</h2>
                    </div>
                    <div class="categories">
                        <p><a href="#">Anime</a> </p>
                    </div>
                </div>
        
            </div>
            <div class="col-lg-9">
                <div class="discussion">
                    <h3>Discussion</h3>
                    
                   
                    <div id="comments"></div>      
                    <div class="d-flex justify-content-center" id="removeSeeMore">
                        <button id="seeMore" value="" class="btn btn-info" style="display:none;">See More</button>
                    </div>
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
                                    <form action="" method="POST" id="create_form"> 
                                        <input type="hidden" id="create_post_id" value="<?php echo $post["id"];?>" >
                                        <textarea class="text" type="comment" id="create_comment" placeholder="Write a Comment"></textarea>
                                        <button type="submit" id="create">Comment</button>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div>
                             
                </div>
            </div>
        </div>
    </div>
  </div>


<script type="text/javascript">
const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
document.querySelector('body').style.background = rgbaColor;
</script>