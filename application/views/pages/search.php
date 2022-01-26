<div onclick="checkMousePointer()">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg 2">
            <div class="topnamebox">
                <div class="top">
                    <h2>Top of the Week</h2>
                </div>
                <div class="topname">
                    <p>1. Echizen</p>
                    <p>2. Echizen</p>
                    <p>3. Echizen</p>
                    <p>4. Echizen</p>
                    <p>5. Echizen</p>
                    <p>6. Echizen</p>
                    <p>7. Echizen</p>
                    <p>8. Echizen</p>
                    <p>9. Echizen</p>
                    <p>10. Echizen</p>
                </div>
                <div class="allcat">
                    <h2>All Categories</h2>
                </div>
                <div class="categories">
                    <?php foreach ($categories as $category): ?>
                        <a href="#"><p><?php echo $category["name"];?> </p></a>
                    <?php endforeach; ?>      
                </div>
            </div>
        </div>
        
        <div class="col-lg 10">
            <div class="createthread">
                <h1>Search Result</h1>
                <hr>
        </div>
        
            <!-- Loop through the results array -->
            <?php foreach($results as $keys => $values):?> 
                <!-- Check if it has contents-->
                <?php if($values):?> 
                    <div class="homecatpost">
                        <div class="categoriesdiv">
                            <h3><?php echo $keys;?></h3>
                        </div>
                    </div>   
                
                    
                    <!-- Loop through the values of the key-->
                    <?php foreach($values as $content):?>
                        <div class="homethread">
                        
                            <!-- UI FOR THREADS-->
                            <?php if($keys == "Threads"):?>
                                
                                <div class="row">
                                    <div class="col-lg-1">
                                            <div class="circleimage">
                                            <?php if(!empty($content["user_profile_photo"])){ ?>
                                                <img style="border: 1px solid #000000;" src="<?php echo base_url().$content["user_profile_photo"];?>" class="userprofile">
                                            <?php }
                                            else{?>
                                                <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                            <?php } ?>
                                            </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="<?php echo site_url("profiles/view/".$content["user_id"]);?>"><h2><?php echo ucfirst($content["username"]);?></h2> </a>
                                        <a href="<?php echo site_url("posts/".$content["id"]);?>"><h4><?php echo $content["title"];?></h4></a> 
                                    </div>
                                    <div class="col-lg-4">
                                        <p class="post-date">Posted on: <?php echo $content["post_created_at"];?></p>
                                    </div>
                                </div>
                                
                            <!-- UI FOR COMMENTS-->
                            <?php elseif($keys == "Comments"):?>
                                <div class="row">
                                    <div class="col-lg-1">
                                            <div class="circleimage">
                                            <?php if(!empty($content["user_profile_photo"])){ ?>
                                                <img style="border: 1px solid #000000;" src="<?php echo base_url().$content["user_profile_photo"];?>" class="userprofile">
                                            <?php }
                                            else{?>
                                                <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                            <?php } ?>
                                            </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="<?php echo site_url("profiles/view/".$content["user_id"]);?>"><h2><?php echo ucfirst($content["username"]);?></h2> </a>
                                        <a href="<?php echo site_url("posts/".$content["post_id"]);?>"><h4><?php echo $content["content"];?></h4></a> 
                                    </div>
                                    <div class="col-lg-4">
                                        <p class="post-date">Posted on: <?php echo $content["created_at"];?></p>
                                    </div>
                                </div>

                            <!-- UI FOR PROFILES-->
                            <?php else:?> 
                                <div class="row">
                                    <div class="col-lg-1">
                                            <div class="circleimage">
                                            <?php if(!empty($content["user_profile_photo"])){ ?>
                                                <img style="border: 1px solid #000000;" src="<?php echo base_url().$content["user_profile_photo"];?>" class="userprofile">
                                            <?php }
                                            else{?>
                                                <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                            <?php } ?>
                                            </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <a href="<?php echo site_url("profiles/view/".$content["user_id"]);?>"><h2><?php echo ucfirst($content["username"]);?></h2> </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                    <?php endforeach;?>
                        
                <?php endif; ?>
            <?php endforeach;?>  
            </div>
        </div>
    </div>
</div>