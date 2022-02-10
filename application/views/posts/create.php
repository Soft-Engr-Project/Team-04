<div onclick="checkMousePointer()">
  <div style="width: 100vw; height: 100vh;" class="container"> 
    <div class="createpost">
      <?php echo form_open_multipart("posts/create");?>
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
            <option value="<?php echo $category['category_id'];?>">
              <?php echo $category['name'];?>
            </option>
          <?php endforeach;?>
          </select>
        </div>
        <div class="form-group mt-3">
          <label for="file" class="uploadlabel">Upload Image</label>
          <div class="mt-3 mb-3">
            <input class="uploadpic" type="file" name="userfile" size="20"> 
          </div>
        </div>
        <button type="submit">Post</button>
      </form>
      <h3 style="margin-left:5px;"> 
      <?php if(!empty(validation_errors())) {?>
      Error : 
      <?php } echo validation_errors();?></h3>
      <a href="<?php echo base_url();?>pages/view"><button type="submit" class="cancelbutton">Cancel</button></a>
     
    </div>
  </div>
</div>


<script>
  // Replace the <textarea id="editor1"> with a CKEditor 4
  // instance, using default configuration.
  CKEDITOR.replace( 'editor1' );
</script>

<script>
const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
document.querySelector('body').style.background = rgbaColor;
</script>