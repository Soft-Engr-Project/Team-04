<body id="signup">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="myleftsignup">
                    <h4>One of Us?</h4>
                    <a href="<?php echo site_url("logins/form");?>"><input type="submit" class="button1" value="SIGN IN"></a>
                </div> 
            </div>
            <div class="col-lg-6">
                <div class="myrightsignup">
                    <form action="<?php echo site_url("signup/navigate");?>" method="POST" class="myForm text-center">
                        <header> SIGN UP</header>
                        <div class="row">
                            <div class="form-group mb-3 col-md-2 col-sm-2"></div>
                            <div class="form-group mb-3 col-md-5 col-sm-5">
                                <label>First Name</label>
                                <input type="text" class="myinput" name="fname">
                            </div>
                            <div class="form-group mb-3 col-md-5 col-sm-5">
                                <label>Last Name</label>
                                <input type="text" class="myinput" name="fname">
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label class="labelsignup">Username</label>
                            <input type="text" class="form-control" id="username" required>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label class="labelsignup">Birthday</label>
                            <input type="date" class="form-control" id="birthday" required>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label class="labelsignup">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label class="labelsignup">Password</label>
                            <input type="password" class="form-control"id="password" required>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label class="labelsignup">Confirm Passord</label>
                            <input type="password" class="form-control" id="confirmpassword" required>
                        </div>
                        
                        <p> <input type="checkbox" class="check" required>I read and agree to <a href="#">Terms & Conditions</a></p>
                        <input type="submit" class="button1" value="SIGN UP">
                    </form>

                </div>
      
            </div>
        </div>
    </div>
