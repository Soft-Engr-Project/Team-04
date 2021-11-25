<!DOCTYPE html>
<html>
<body>
  <div class="header">
    <h2>Login</h2>
  </div>

  <?php echo validation_errors();?>
  <?php echo form_open("postreg/login") ;?>
  <?php 
    
    //if user attempts in login page after login, redirect to homepage
    if (isset($_SESSION['username']))
        redirect("pages/view");
 ?>
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
        Not yet a member? <a href="<?php echo site_url("postreg/register"); ?>">Sign up</a>
    </p>

    <p>
       <a href="<?php echo site_url("postreg/forgot_password"); ?>">Forgot Password</a>
    </p>


  </form>
</body>
</html>
