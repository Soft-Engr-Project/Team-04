                <div class="col-lg-8">
                    <div class="row">
                        <div class="threads">
                            <h1><?=$title?></h1>
                            <hr>
                        </div>
                        <?php foreach($posts as $post):?>
                        <div class="threadscontent">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="circleimage">
                                         <?php if(!empty($user["user_profile_photo"])){ ?>
                                            <img style="border: 1px solid #000000;" src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" alt="Profile Photo">
                                        <?php }
                                        else{?>
                                            <img style="border: 1px solid #000000;" src="<?php echo base_url();?>assets/image/user.png" alt="Profile Photo" class="userprofile">
                                         <?php } ?>
                                        </div>
                                        <?php if($user["user_id"] == $this->session->userdata("user_id")):?>
                                        <div class="dropdown">
                                            <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                                <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <label for="edit">
                                                    <li class="dropdown-item">
                                                         <?php echo form_open("posts/edit/".$post["id"]);?>
                                                            <input type="submit" id="edit">
                                                             Edit
                                                        </form> 
                                                    </li> 
                                                </label>
                                                <label for="remove">
                                                    <li class="dropdown-item"> 
                                                         <?php echo form_open("profileposts/delete/".$post["id"]);?>
                                                    <input type="hidden" name="react_id" value="<?php echo $post["react_id"];?>">
                                                    <input type="submit" id="remove">
                                                        Remove
                                                    </form>
                                                    </li> 
                                                </label>  
                                            </ul>
                                        </div>
                                        <?php endif;?> 
                                    </div>
                                    <div class="col-lg-10">
                                        <h2><a href="<?php echo site_url("profiles/view/".$post["user_id"]);?>"><?php echo $user["username"]?> </a></h2>
                                        <h4><a href="<?php echo site_url("/posts/view/".$post["id"]);?>"> <?php echo $post["title"];?></a></h4>
                                        <h6> <?php if(!empty($post["post_image"])):?>
                                            <img src="<?php echo base_url().$post["post_image"];?>" alt=""> </h6>
                                        <?php endif;?>
                                        <h6><?php echo character_limiter($post["body"],300);?></h6>
                                        <h5>Posted on: <?php echo $post["created_at"];?></h5>
            
                                        <div class="threadmore">
                                            <div class="profilereaction">
                                                <div class="upbutton" id="like">
                                                    <button id="likebtn">
                                                        <em class="fa fa-thumbs-up" style="font-size:24px"></em>                              
                                                        <input type="numberlike" id="input1" value="<?php echo $post["upvote"];?>" name="">
                                                    </button>
                                                </div>
                    
                                                <div class="downbutton" id="dislike" >
                                                    <button id="likebtn">
                                                        <em class="fa fa-thumbs-down" style="font-size:24px"></em>
                                                        <input type="numberlike" value="0" name="">
                                                    </button>
                                                </div>
                                            </div> 
                                            <div class="totalcomments">
                                                <img src="<?php echo base_url();?>assets/image/comment.png" alt="comment">
                                                <input type="numberlike" value="<?php echo $post["post_comment_count"];?>" name="">
                    
                                            </div>
                                            <div class="whatcategory">
                                                <h4>Categories: </h4>
                                                <a href=""><?php echo $post["name"];?></a>
                                            </div>
                                        </div>
                                    </div>                         
                                </div>
                            <hr>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
