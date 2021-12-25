
					<?php foreach($posts as $post):?>
						<div class="homethread">
                            <div class="row">
                                <div class="col-lg-1">
                                    <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="profilepost">
                                </div>
                                <div class="col-lg-6">
                                    <a href="<?php echo site_url("profiles/view");?>"><h2><?php echo ucfirst($post["username"]);?></h2> </a>
                                    <a href="<?php echo site_url("posts/".$post["id"]);?>"><h4><?php echo $post["title"];?></h4></a> 
                                </div>
                                <div class="col-lg-4">
                                    <p class="post-date">Posted on: <?php echo $post["created_at"];?></p>

                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>





<!-- index.php para sa post nasa discord yung original -->



