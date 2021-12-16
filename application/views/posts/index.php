
					<?php foreach($posts as $post):?>
						<div class="homethread">
                            <div class="row">
                                <div class="col-lg-1">
                                    <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="profilepost">
                                </div>
                                <div class="col-lg-7">
                                    <a href="#"><h2><?php echo ucfirst($post["username"]);?></h2> </a>
                                    <a href="#"><h4><?php echo $post["title"];?></h4></a> 
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





<?php foreach($posts as $post):?>
	<!-- title -->
	<div class="mt-5">
		<h3><?php echo $post["title"];?></h3>
		<!-- image -->
		<?php if(isset($post["post_image"])):?>
			<img src="<?php echo base_url();?>assets/images/posts/<?php echo $post["post_image"];?>" alt="" width="300">
		<?php endif;?>

		<!-- who post and when -->
		<small class="post-date">Posted on : <?php echo $post["created_at"];?> in <?php echo $post["name"];?></small>
		<small>Created by : <?php echo ucfirst($post["username"]);?></small>
		<!-- body -->
		<h4><?php echo character_limiter($post["body"],300);?></h4>
		<!-- button see more  -->
		<?php echo form_open("posts/".$post["id"])?>
			<button class="btn btn-primary" type="submit">See More</button>
		</form>
		<?php if($this->session->userdata("user_id") == $post["user_id"] || $this->session->userdata("admin") == true) :?>
			<?php echo form_open("posts/delete/".$post["id"]);?>
			<input type="hidden" name="react_id" value="<?php echo $post["react_id"];?>">
				<button class="btn btn-primary">Delete</button>
			</form>
			<?php echo form_open("posts/edit/".$post["id"]);?>
				<button class="btn btn-secondary" type="submit">Edit</button>
			</form>
		<?php endif;?>
	</div>
<?php endforeach;?>
</div>



