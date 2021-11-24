<div class="header">
  	<h2>Forgot Password</h2>
  </div>

 <?php echo validation_errors();?>
  <?php echo form_open("postreg/forgot_password") ;?>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" >
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="passcode">Reset Password</button>
  	</div>
  	<p>
  		Already a member? <a href="<?php echo base_url();?>">Sign in</a>
  	</p>
  </form>
</body>



