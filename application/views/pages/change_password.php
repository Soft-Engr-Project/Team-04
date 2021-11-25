<?php 
  if (isset($_SESSION['username'])) {
    $_SESSION['msg'] = "Please Logout First";
    redirect("/pages/view");
  }
?>

<div class="header">
  	<h2>Change Password</h2>
  </div>

 <?php echo validation_errors();?>
  <?php echo form_open("postreg/change_pass") ;?>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="change_pass">Reset Password</button>
  	</div>
  </form>
</body>