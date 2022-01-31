<?php 
  if (isset($_SESSION['username'])) {
    $_SESSION['msg'] = "Please Logout First";
    redirect("/pages/view");
  }
?>


<body id="resetpassword">
    <div class="squareyellow">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <div class="myleftforgot">
                        <h1>Thinklik</h1>
                        <div class="form-group mb-3 col-md-12">
                            <a href="<?php echo base_url();?>"><input type="submit" class="button1" value="Sign In"></a>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <a href="<?php echo site_url("Signup/register"); ?>"><input type="submit" class="button1" value="Sign Up"></a>
                        </div>
                    </div>  
                </div>
                <div class="col-lg-6">
                    <div class="myrightreset">
                        <div class="myForm text-center">
                            <?php echo form_open("ForgotPassword/change_pass") ;?>
                                <header> Reset Password</header>
                                <p>Your password must contain a Mix Letters, Numbers and atleast 8 characters long</p>
                                <label>New Password</label>
                                <div class="sign_icon">
                                    <input type="password" class="myinput" id="password" name="password_1" required>
                                    <em class="fa fa-lock  fa-2xl"></em>
                                </div>
                                <div class="visiblepassword">
                                    <em class="fa fa-eye fa-xl" id="eye" onclick="show()"></em>
                                </div>  
                                <div class="sign_icon">
                                <label>Confirm Password</label>
                                    <input type="password" class="myinput" id="confirmpassword" name="password_2" required>
                                    <em class="fa fa-lock  fa-2xl"></em>
                                </div>
                                <div class="visiblepassword">
                                    <em class="fa fa-eye fa-xl" id="eye1" onclick="showconfirm()"></em>
                                </div>  
                                <h6 class="error"><?php echo validation_errors();?></h6>
                                <input type="submit" class="button1" value="Reset Password">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        var state = false;
    </script>
</body>