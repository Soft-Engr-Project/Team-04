<?php 
  if (isset($_SESSION['username'])) {
    $_SESSION['msg'] = "Please Logout First";
    redirect("/pages/view");
  }
?>

<div class="header">
  	<h2>Forgot Password</h2>
  </div>

 <?php echo validation_errors();?>
  <?php echo form_open("postreg/passverify") ;?>
  	<div class="input-group">
  	  <label>Enter 6 Digit Code</label>
  	  <input type="number" maxlength="6" pattern="[0-9]{6,}" name="passcode" >
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="change_pass">Reset Password</button>
  	</div>
  	<p>
  		Already a member? <a href="<?php echo base_url();?>">Sign in</a>
  	</p>
  </form>
</body>



