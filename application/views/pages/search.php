<div onclick="checkMousePointer()">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-lg 2">
                <div class="topnamebox">
                    <div class="top">
                        <h2>Top of the Month</h2>
                    </div>
                    <div class="topname">
                        <p>1. <a href="#">Echizen</a></p>
                    </div>
                    <div class="allcat">
                        <h2>All Categories</h2>
                    </div>
                    <div class="categories">
                        <?php foreach ($categories as $category): ?>
                            <p><a href="#"><?php echo $category["name"];?></a> </p>    
                        <?php endforeach; ?>              
                    </div>
                </div>
            </div>

            <div class="col-lg 10">
                <h1 class="searchres">Search Result</h1>
                <?php foreach($results as $keys => $values):?> 
                <?php if($values):?> 
                    <div class="categoriesdiv">
                        <h3><?php echo $keys;?></h3>
                    </div>
                    <?php foreach($values as $content):?>            
                        <div class="homethread">
                            <?php if($keys == "Threads"):?>
                                <div class="toppost">
                                    <div class="circleimage">
                                        <?php if(!empty($content["user_profile_photo"])){ ?>
                                        <img style="border: 1px solid #000000;" src="<?php echo base_url().$content["user_profile_photo"];?>" class="userprofile" alt="Profile Photo">
                                        <?php }
                                        else{?>
                                            <img src="<?php echo base_url();?>assets/image/user.png" alt="Profile Photo" class="userprofile" alt="Profile Photo">
                                        <?php } ?>
                                    </div>

                                    <div>
                                        <h2><a href="<?php echo site_url("profiles/view/".$content["user_id"]);?>"><?php echo ucfirst($content["username"]);?></a></h2>
                                        <h4><a href="<?php echo site_url("posts/".$content["id"]);?>"> <?php echo $content["title"];?></a></h4>
                                        <p>Posted on: <?php echo $content["post_created_at"];?></p>
                                    </div>
                                </div>
                            <?php elseif($keys == "Comments"):?>
                                <div class="toppost">
                                    <div class="circleimage">
                                        <?php if(!empty($content["user_profile_photo"])){ ?>
                                        <img style="border: 1px solid #000000;" src="<?php echo base_url().$content["user_profile_photo"];?>" class="userprofile" alt="Profile Photo">
                                        <?php }
                                        else{?>
                                        <img src="<?php echo base_url();?>assets/image/user.png" alt="Profile Photo" class="userprofile">
                                        <?php } ?>
                                    </div>

                                    <div>
                                        <h2><a href="<?php echo site_url("profiles/view/".$content["user_id"]);?>"><?php echo ucfirst($content["username"]);?></a></h2>
                                        <h4><a href="<?php echo site_url("posts/".$content["post_id"]);?>"> <?php echo $content["content"];?></a></h4>
                                        <p>Posted on: <?php echo $content["created_at"];?></p>
                                    </div>
                                </div>       
                            <?php else:?> 
                                <div class="toppost">
                                    <div class="circleimage">
                                        <?php if(!empty($content["user_profile_photo"])){ ?>
                                            <img style="border: 1px solid #000000;" src="<?php echo base_url().$content["user_profile_photo"];?>" class="userprofile" alt="Profile Photo">
                                        <?php }
                                        else{?>
                                            <img src="<?php echo base_url();?>assets/image/user.png" alt="Profile Photo" class="userprofile">
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <h2><a href="<?php echo site_url("profiles/view/".$content["user_id"]);?>"><?php echo ucfirst($content["username"]);?></a></h2>
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
<script>
const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
document.querySelector('body').style.background = rgbaColor;
</script>