<h1><?=$title?></h1>
<?php echo validation_errors();?>
<?php echo form_open("posts/update") ;?>
	<input type="hidden" name="id" value="<?php echo $post['id']?>">
	<input type="hidden" name="slug" value="<?php echo $slug;?>">
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
  <button type="submit" class="btn btn-success">Post</button>
</form>