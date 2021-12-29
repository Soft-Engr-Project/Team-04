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
                    <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                    <a href="<?php echo site_url("posts/create")?>">
                    <div class="threadbox">
                          <p>Create Thread</p>
                    </div>
                    </a>
                    <hr>
                </div>

                <div class="catfil">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="divcategor">
                                <p>Categories:</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="divfilter">
                                <span class="labelfilter">Filter: </span>
                                <select name="" id="">
                                    <option value="">Anime</option>
                                    <option value="">Technology</option>
                                    <option value="">Programming Language</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                        