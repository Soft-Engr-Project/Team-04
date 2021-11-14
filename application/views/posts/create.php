<?php form_open("pages/home") ?>
<div class="form-group">
    <label for="title">Title : </label>
    <input type="text" class="form-control" name="title">
  </div>
  <div class="form-group">
    <label for="category">Category : </label>
    <input type="text" class="form-control" name="category">
  </div>
  <div class="form-group">
    <label for="body">Body :</label>
    <textarea  class="form-control" name="body"></textarea>
  </div>
 
  <button type="submit" class="btn btn-success">Post</button>
</form>