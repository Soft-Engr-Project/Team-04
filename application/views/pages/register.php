

  <div class="header">
  	<h2>Register</h2>
  </div>
  <?php echo validation_errors();?>
  <?php echo form_open("posts/register");?>
  <div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" >
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" >
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="text" name="password_1">
  	</div>
  	<!-- <div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div> -->
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="<?php echo base_url();?>login">Sign in</a>
  	</p>
  </form>
