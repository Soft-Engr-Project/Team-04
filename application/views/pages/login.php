

  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <?php echo validation_errors();?>
  <?php echo form_open("posts/login") ;?>

  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="<?php echo site_url("posts/register"); ?>">Sign up</a>
  	</p>
  </form>
