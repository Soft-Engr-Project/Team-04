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
                                <label>New Password</label>
                                <div class="form-group">
                                    <input type="password" class="myinput" name="password_1" required>
                                </div>
                                <label>Confirm Password</label>
                                <div class="form-group">
                                    <input type="password" class="myinput" name="password_2" required>
                                </div>
                                <input type="submit" class="button1" value="Reset Password">
                            </form>
                        </div>
                        <div class="error">
                        <?php echo validation_errors();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
</body>