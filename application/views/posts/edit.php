<h1><?=$title?></h1>
<?php echo validation_errors();?>
<?php echo form_open_multipart("posts/update") ;?>
	<input type="hidden" name="id" value="<?php echo $post['id']?>">
  <input type="hidden" name="post_image" value="<?php echo $post['post_image']?>">
	<!-- <input type="hidden" name="slug" value="<?php echo $slug;?>"> -->
  <div class="form-group">
  <?php if(isset($post["post_image"])):?>
			<img src="<?php echo base_url();?>assets/images/posts/<?php echo $post["post_image"];?>" alt="" width="300">
		<?php endif;?>
  </div>
  <div class="form-group">
    <label for="title">Title : </label>
    <input type="text" class="form-control" name="title" value="<?php echo $post['title'];?>">
  </div>
  <div class="form-group">
    <label for="body">Body :</label>
    <textarea  class="form-control" id="editor1" name="body"><?php echo $post['body'];?></textarea>
  </div>
  <div class="form-group">
    <label for="">Categories:</label>
    <select name="category_id" class="form-control ">
    <?php foreach($categories as $category):?>
      <option value="<?php echo $category['category_id'];?>"><?php echo $category['name'];?></option>
    <?php endforeach;?>
    </select>
  </div>
  <div class="form-group mt-3">
    <label for="file">Upload Image</label>
    <div class="mt-3 mb-3">
      <input type="file" name="userfile" size="20"> 
    </div>
  </div>
  <button type="submit" class="btn btn-success">Post</button>
</form>