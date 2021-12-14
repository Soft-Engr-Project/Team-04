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
                                <img src="<?php echo base_url();?>assets/image/user.png" class="userprofile" >
                            </div>
                            <div class="col-lg-9">
                                <a href="<?php echo site_url("profiles/view");?>"><h2>Username</h2> </a>
                                <a href="<?php echo site_url("/profileposts/".$post["slug"]);?>"> <h4> <?php echo $post["title"];?></h4></a> 
                                <h6> <?php echo character_limiter($post["body"],300);?></h6> 
    
                                <p>Posted on <?php echo $post["created_at"];?></p>
                                
                                <div class="threadscol">
                                    <div class="row">

                                        <div class="col-lg-3">
                                            <a href="#">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <img src="<?php echo base_url();?>assets/image/reactions.png" alt="reaction">
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <h3>0</h3>
                                                    </div>  
                                                </div>
                                            </a>

                                        </div>

                                        <div class="col-lg-3">
                                            <a href="#">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <img src="<?php echo base_url();?>assets/image/comment.png" alt="comment">
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <h3>0</h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                  
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <h4>Categories: </h4>
                                                </div>
                                                <div class="col-lg-8 col-md-8">
                                                    <a href="#"><h6>Movies</h6></a>
                                                </div>
                                            </div>
                                        </div>                             

                                    </div>
                                </div>
                            </div>                            
                            <div class="col-lg-1">
                                 <div class="menuthreads">
                                    <div class="dropdown">
                                        <button type="button" id="buttonmenu" data-bs-toggle="dropdown"> 
                                             <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-item"> <?php echo form_open('/posts/edit/'.$post['slug']);?>
                                                <input type="submit" id="edit">
                                                
                                                <label for="edit">Edit</label>
                                            
                                                </form></li>
                                            <li class="dropdown-item"> 
                                                     <?php echo form_open('/profileposts/delete/'.$post['id']);?>
                                                <input type="submit" id="remove">
                                                <label for="remove">Remove</label>  
                                                 </form>
                                            </li>
                                        </ul>
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
