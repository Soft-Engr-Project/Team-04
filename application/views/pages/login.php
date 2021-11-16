<body id="signin">
<div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="myLeftCtn">
                        <form action="<?php echo base_url();?>pages/view" method="POST" class="myForm text-center">
                            <header> SIGN IN</header>
                            <div class="form-group">
                                    <img src="<?php echo base_url();?>assets/image/user.png" width="20" height="20">
                                <input type="text" class="myinput" id="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <img src="<?php echo base_url();?>assets/image/lock.png"  width="20" height="20" >
                                <input type="password" class="myinput" id="password" placeholder="Password" required>
                            </div>
                            <a href="#"> <p>Forgot password?</p>  </a>
                            <a href="#"><input type="submit" class="button1" value="SIGN IN"></a>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="myRightCtn">
                        <h4>Not yet a member?</h4>
                        <a href="<?php echo site_url("signup/form/index")?>"><input type="submit" class="button1" value="Create new account"></a>          
                    </div>
                </div>
            </div>
         </div>
