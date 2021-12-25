<div class="container">
<br>
<br>
<br>
<br>
<h3><?php echo $post["title"];?></h3>
	<!-- image -->
	<?php if(isset($post["post_image"])):?>
			<img src="<?php echo base_url();?>assets/images/posts/<?php echo $post["post_image"];?>" alt="" width="300">
	<?php endif;?>
	<!-- who post and when  and what category-->
	<small class="post-date">Posted on : <?php echo $post["created_at"];?> in <?php echo $post["name"];?></small>
	<small>Created by : <?php echo ucfirst($post["username"]);?></small>
	<!-- body -->
	<h4><?php echo $post["body"];?></h4>
	<?php if($this->session->userdata("user_id") == $post["user_id"]) :?>
			<?php echo form_open("posts/delete/".$post["id"]);?>
				<button class="btn btn-primary">Delete</button>
			</form>
			<?php echo form_open("posts/edit/".$post["id"]);?>
				<button class="btn btn-secondary" type="submit">Edit</button>
			</form>
	<?php endif;?>
	<?php echo form_open("posts/reaction/".$post["id"]);?>
		<input type="hidden" name="vote" value="1">
		<input type="hidden" name="react_id" value="<?php echo $post["react_id"];?>">
		<button class="btn btn-outline-primary bg-light text-primary" name="submit" type="submit" value="up_react">Upvote</button>
    </form>
	<p><?php echo $post["upvote"] ;?></p>
		<?php echo form_open("posts/reaction/".$post["id"]);?>
		    <input type="hidden" name="vote" value="1">
		    <input type="hidden" name="react_id" value="<?php echo $post["react_id"];?>">
			<button class="btn btn-outline-primary bg-light text-primary" name="submit" type="submit" value="down_react">Downvote</button>
		</form>
	<p><?php echo $post["downvote"];?></p>
	<!-- button delete -->
	<hr>
	<h3>Comments : </h3>
		
	<div id="comments">
		   
	</div>  

 	<?php echo validation_errors();?>
 	<form action="" method="POST" id="create_form"> 
		<input type="hidden" id="create_post_id" value="<?php echo $post["id"];?>">
		<div class="form-group">
			  <label>Comment :</label>
			  <textarea  class="form-control" id="create_comment"></textarea>
		</div>
		<button type="submit" class="btn btn-primary" id="create">Comment</button>
	</form>
	</div>
	<br>
	
</div>
	