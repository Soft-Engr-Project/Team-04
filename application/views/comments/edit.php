<h1><?php echo $title ?></h1>
<br>
<br>
<br>
<br>
<div class="container"> 
<?php echo $comment["post_id"];?>
<?php echo validation_errors();?>
<?php echo form_open("comments/update") ;?>
 <input type="hidden" name="comment_id" value="<?php echo $comment["comment_id"]?>">
 <input type="hidden" name="post_id" value="<?php echo $comment["post_id"]?>">
  <div class="form-group">
    <label for="body">Comment :</label>
    <textarea  class="form-control" id="editor1" name="body">
      <?php echo $comment["content"];?>
    </textarea>
  </div>
  <button type="submit" class="btn btn-success">Edit</button>
</form>
</div>