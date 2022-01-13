<div onclick="checkMousePointer()">
<br>
<br>
<br>
<br>
<div class="container"> 
<?php echo validation_errors();?>
<?php echo form_open_multipart("posts/create") ;?>
  <div class="form-group">
    <label for="title">Title : </label>
    <input type="text" class="form-control" name="title">
  </div>
  <div class="form-group">
    <label for="body">Body :</label>
    <textarea  class="form-control" id="editor1" name="body"></textarea>
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
</div>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor 4
  // instance, using default configuration.
  CKEDITOR.replace( 'editor1' );
</script>
