<h3><?php echo $post["title"];?></h3>
	<!-- who post and when  and what category-->
	<small class="post-date">Posted on : <?php echo $post["created_at"];?> in <?php echo $post["name"];?></small>
	<small>Created by : <?php echo ucfirst($post["username"]);?></small>
	<!-- body -->
	<h4><?php echo $post["body"];?></h4>
	<!-- button delete -->
	
	<?php if($this->session->userdata("user_id") == $post["user_id"]) :?>
			<?php echo form_open("posts/delete/".$post["id"]);?>
			<!--  -->
				<input type="hidden" name="id" value="<?php echo $post["id"];?>">
				<input type="hidden" name="slug" value="<?php echo $post["slug"];?>">
				<button class="btn btn-primary">Delete</button>
			</form>
			<?php echo form_open("posts/edit/".$post["slug"]);?>
				<input type="hidden" name="id" value="<?php echo $post["id"];?>">
				<button class="btn btn-secondary" type="submit">Edit</button>
			</form>
	<?php endif;?>