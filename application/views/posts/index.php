
					<?php foreach($categories as $category):?>
						<div class="homethread">
                            <?php if($category["name"])?>
                            <div class="homecatpost">
                                <div class="categoriesdiv">
                                    <h3><?php echo $category["name"];?></h3>
                                </div>
                              </div>
                              <?php if($category["category_post_count"] != 0) {?>
                              <?php foreach($posts as $post):?>
                                <?php if($post["name"] == $category["name"]):?>
                                
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="profilepost">
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="<?php echo site_url("profiles/view");?>"><h2><?php echo ucfirst($post["username"]);?></h2> </a>
                                        <a href="<?php echo site_url("posts/".$post["id"]);?>"><h4><?php echo $post["title"];?></h4></a> 
                                    </div>
                                    <div class="col-lg-4">
                                        <p class="post-date">Posted on: <?php echo $post["post_created_at"];?></p>
                                    </div>
                                </div>
                             <?php endif;?>
                         <?php endforeach;?>
                         <?php  }else {?>
                                 <div class="row">
                                    <div class="mt-5">
                                         <h3 class="col-lg-12">No post in this section</h3>
                                    </div>
                                   
                                 </div>
                             <?php } ?>    
                        </div>
                    <?php endforeach;?>
                    
                </div>
            </div>
        </div>
    </div>





<!-- index.php para sa post nasa discord yung original -->



