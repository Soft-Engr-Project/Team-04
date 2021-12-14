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
		<?php if(!empty($comments)): ?>
		   <div id="comments">
		   		 <?php foreach ($comments as $comment): ?>
		        <div class="card bg-primary">
		            <div class="card-body text-white">
		                 <h5><?php echo $comment["content"];?> [by <strong><?php echo $comment["username"];?></strong>]</h5>
		            	 <?php echo form_open("comments/reaction/".$post["id"]);?>
		            	 	<input type="hidden" name="vote" value="1">
		            	 	<input type="hidden" name="react_id" value="<?php echo $comment["react_id"];?>">
		            	 	<input type="hidden" name="comment_id" value="<?php echo $comment["comment_id"];?>">
		            	 	<button class="btn btn-outline-primary bg-light text-primary" name="submit" type="submit" value="up_react">Upvote</button>
		            	 </form>
		            	 <p><?php echo $comment["upvote"] ;?></p>
		            	 <?php echo form_open("comments/reaction/".$post["id"]);?>
		            	 	<input type="hidden" name="vote" value="1">
		            	 	<input type="hidden" name="react_id" value="<?php echo $comment["react_id"];?>">
		            	 	<input type="hidden" name="comment_id" value="<?php echo $comment["comment_id"];?>">
		            	 	<button class="btn btn-outline-primary bg-light text-primary" name="submit" type="submit" value="down_react">Downvote</button>
		            	 </form>
		            	 <p><?php echo $comment["downvote"];?></p>
						 <?php if($this->session->userdata("user_id") == $comment["user_id"]) :?>
							<?php echo form_open("comments/delete/".$comment["comment_id"])?>
							<input type="hidden" name="post_id" value="<?php echo $post["id"];?>">
							<input type="hidden" name="user_id" value="<?php echo $post["user_id"];?>">
							<input type="hidden" name="react_id" value="<?php echo $comment["react_id"];?>">
							<input type="hidden" name="comment_id" value="<?php echo $comment["comment_id"];?>">
								<button class="btn btn-outline-primary bg-light text-primary" name="submit" type="submit">Delete</button>
							</form>
							<?php echo validation_errors();?>
							<?php echo form_open("comments/edit/".$comment["comment_id"])?>
							<input type="hidden" name="user_id" value="<?php echo $post["user_id"];?>">
							<input type="hidden" name="post_id" value="<?php echo $post["id"];?>">
								<button class="btn btn-outline-primary bg-light text-primary" name="submit" type="submit">Edit</button>
							</form>
						<?php endif;?>
		            </div>
		        </div>
		        <br>
		  <?php endforeach ?>
		   
		   </div>  
		 
		<?php else :?>
		    <p><?php echo "No comments to Display" ;?></p>
		<?php endif ?>
 	<?php echo validation_errors();?>
	<?php echo form_open("comments/create/".$post["id"])?>
		<div class="form-group">
			  <label for="body">Comment :</label>
			  <textarea  class="form-control" name="comment"></textarea>
		</div>
		<button type="submit" class="btn btn-primary">Comment</button>
		
	</div>
	<br>
	<hr>
	<?php if($this->session->userdata("user_id") == $post["user_id"]) :?>
			<?php echo form_open("posts/delete/".$post["id"]);?>
				<button class="btn btn-primary">Delete</button>
			</form>
			<?php echo form_open("posts/edit/".$post["id"]);?>
				<button class="btn btn-secondary" type="submit">Edit</button>
			</form>
	<?php endif;?>
</div>

<script src="<?php echo base_url()?>script/jquery-3.6.0"></script>
<script>

</script>