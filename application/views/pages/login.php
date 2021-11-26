<!DOCTYPE html>
<html>
<body id="signin">
        <div class="squareyellow">
            <div class="card">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="myleftsignin">
                             <?php 
    
                                //if user attempts in login page after login, redirect to homepage
                                if (isset($_SESSION['username']))redirect("pages/view");
                            ?>
                            <div class="myForm text-center">
                                <?php echo form_open("postreg/login") ;?>
                                    <header> Sign In</header>
                                    <div class="form-group">
                                            <img src="assets/image/user.png" width="20" height="20">
                                        <input type="text" class="myinput" name="username" placeholder="USERNAME" required>
                                    </div>
                                    <div class="form-group">
                                        <img src="assets/image/lock.png"  width="20" height="20" >
                                        <input type="password" class="myinput" name="password" placeholder="PASSWORD" required>
                                    </div>
                                    <a href="<?php echo site_url("postreg/forgot_password"); ?>"> 
                                    <p>Forgot password?</p>  </a>
                                    <?php echo validation_errors();?>
                                    <a href="#"><input type="submit" class="button1" name="login_user" value="Sign In"></a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="myrightsignin">
                            <h1>Thinklik</h1>
                            <h4>Not yet a member?</h4>
                            <a href="<?php echo site_url("postreg/register"); ?>">
                            <input type="submit" class="button1" value="Create new account"></a>          
                        </div>
                    </div>
                </div>
            </div>
         </div>

        
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
</body>
</html>