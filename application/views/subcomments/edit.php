<h1><?php echo $title ?></h1>
<br>
<br>
<br>
<br>
<div class="container"> 

<?php echo validation_errors();?>
<?php echo form_open("Subcomments/update") ;?>
 <input type="hidden" name="comment_id" value="<?php echo $subcomment["comment_id"]?>">
 <input type="hidden" name="subcomment" value="<?php echo $subcomment["subcomment_id"]?>">
  <div class="form-group">
    <label for="body">Comment :</label>
    <textarea  class="form-control" id="editor1" name="body"><?php echo $subcomment["reply"];?></textarea>
  </div>
  <button type="submit" class="btn btn-success">Edit</button>
</form>
</div>