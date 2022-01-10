<div onclick="checkMousePointer()">
<?php 
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	redirect("/");
  }
?>
<div class="container-fluid">
        <div class="row">
            <div class="col-lg 2">
                <div class="topnamebox">
                    <div class="top">
                        <h2 class="m-3 p-3">Top of the Month</h2>
                    </div>
                    <div class="topname">
                        <?php $no=1; foreach ($posts as $post): ?>
                            <p><?php echo $no++;?> <a class="toppost" href="<?php echo base_url()."posts/view/".$post["id"];?>"><?php echo word_limiter($post["title"],2)?></a></p>
                        <?php endforeach ?>?>
                        
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
                    <div class="circleimage">
                    <?php if(!empty($user["user_profile_photo"])){ ?>
                        <img src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" >
                    <?php } else{?>
                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                    <?php } ?>
                    </div>
                    <a href="<?php echo site_url("posts/create")?>">
                    <div class="threadbox">
                          <p>Create Thread</p>
                    </div>
                    </a>
                    <hr>
                </div>

                
                        