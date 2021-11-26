<body id="signup">
    <div class="squareyellow">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <div class="myleftsignup">
                        <h1>Thinklik</h1>
                        <h4>Already a member?</h4>
                        <a href="<?php echo base_url();?>"><input type="submit" class="button1" value="Sign In"></a>
                    </div> 
                </div>

                <div class="col-lg-6">
                    <div class="myrightsignup">
                        <form class="myForm text-center" action="http://localhost/Team4/postreg/register" method="post" accept-charset="utf-8">
                            <header> Sign Up</header>
                            <div class="row">
                                <div class="form-group mb-3 col-md-2"></div>
                                <div class="form-group mb-3 col-md-5">
                                    <label>First Name</label>
                                    <input type="text" class="myinput" name="firstname" required>
                                </div>
                                <div class="form-group mb-3 col-md-5">
                                    <label>Last Name</label>
                                    <input type="text" class="myinput" name="lastname" required>
                                </div>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label class="labelsignup">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label class="labelsignup">Birthday</label>
                                <input type="date" class="form-control" name="birthdate" required>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label class="labelsignup">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label class="labelsignup">Password</label>
                                <input type="password" class="form-control" name="password_1" required>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label class="labelsignup">Confirm Password</label>
                                <input type="password" class="form-control" name="password_2" required>
                            </div>
                            <p> <input type="checkbox" class="check" required>I read and agree to <a href="#">Terms & Conditions</a></p>
                            <input type="submit" class="button1" value="Sign Up">
                        </form>
                        <div class="errorsignup">
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
