<h1><a href="<?php echo site_url("posts/create")?>">Create Post</a></h1>
<h2><?=$title?></h2>

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
		<?php if($this->session->userdata("user_id") == $post["user_id"]) :?>
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



