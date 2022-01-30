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
            
                <h1>Report Logs</h1>
             
                <hr>
            </div>

            <div class="catfil">
                <div class="homethread">
                    <?php foreach($report as $post):?>
                        <?php if($post["post_id"]):?>
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
                                <p class="post-date">Reported by: <?php echo $post["complainant"];?></p>

                            </div>
                        </div>

                        <!-- FIX VIEW ON COMMENT IN REPORT LOGS -->
                        <?php else:?>
                        <div class="row">
                            <div class="col-lg-1">
                                <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="profilepost">
                            </div>
                            <div class="col-lg-6">
                                <a href="<?php echo site_url("profiles/view/".$post["user_id"]);?>"><h2><?php echo ucfirst($post["username"]);?></h2> </a>
                                <a href="<?php echo site_url("posts/view_comment/".$post["comment_id"]);?>"><h4><?php echo $post["content"];?></h4></a> 
                            </div>
                            <div class="col-lg-4">
                                <p class="post-date">Posted on: <?php echo $post["created_at"];?></p>
                                <p class="post-date">Reported by: <?php echo $post["complainant"];?></p>
                            </div>
                            
                           
                        </div>   

                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>