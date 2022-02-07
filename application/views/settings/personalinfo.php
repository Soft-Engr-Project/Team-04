<div onclick="checkMousePointer()">
<div style="height: 100vh">
    <div class="wrapper">
       <h1><?=$title?></h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col-3 col-m-3 col-sm-3">
                    <h6>Username:</h6>
                </div>
                <div class="col-8 col-m-8 col-sm-8">
                    <p><?php echo $username;?></p>
                </div>
           </div>
        
            <div class="row">
                <div class="col-3 col-m-3 col-sm-3">
                    <h6>Name:</h6>
                </div>
                <div class="col-7 col-m-7 col-sm-7">
                    <p><?php echo $firstname;?> <?php echo $lastname;?></p>
                </div>

                <div class="col-1 col-m-1 col-sm-1">
                    <a href="#changename" class="buttonchange">Change</a>
                </div>  
                
                <div class="changeinfo" id="changename">
                    <div class="row">
                        <h5>Change Name</h5>
                            <form action="">
                            <div class="form-group mb-3 col-md-12">
                                <label>First Name:</label>
                                <input type="text" name="firstname" required value="<?php echo $firstname;?>">
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label>&nbsp;Last Name:</label>
                                <input type="text" name="lastname" required value="<?php echo $lastname;?>">
                            </div>
                            <p>Please enter your password to save changes</p>
                            <div class="form-group mb-3 col-md-12">
                                <label>&nbsp;&nbsp;Password:</label>
                                <input type="password" name="password" required>
                            </div>
                            <button class="smallbutton1" value="Update Profile">Save Changes</button>
                        </form>
                        <h2><?php echo validation_errors();?></h2>
                        <a href="#"><button class="smallbutton2" id="close" >Cancel</button></a>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-3 col-m-3 col-sm-3">
                    <h6>Email:</h6>
                </div>
                <div class="col-7 col-m-7 col-sm-7">
                    <p><?php echo $email;?></p>
                </div>

                <div class="col-1 col-m-1 col-sm-1">
                    <a href="#changeemail" class="buttonchange">Change</a>
                </div>

                <div class="changeinfo" id="changeemail">
                    <div class="row">
                        <h5>Change Email</h5>
                            <form action="">
                            <div class="form-group mb-3 col-md-12">
                                <label>New Email:</label>
                                <input type="email" id="email" required>
                            </div>
                           
                            <p>Please enter your password to save changes</p>
                            <div class="form-group mb-3 col-md-12">
                                <label>&nbsp;&nbsp;Password:</label>
                                <input type="password" name="password"required>
                            </div>
                            <p class="reminder">Reminder: Please check your email to verify. Thank you</p>
                            <button class="smallbutton1">Save Changes</button>
                        </form>
                        <h2><?php echo validation_errors();?></h2>
                        <a href="#"><button class="smallbutton2" id="close" >Cancel</button></a>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-3 col-m-3 col-sm-3">
                    <h6>Birthdate:</h6>
                </div>
                <div class="col-7 col-m-7 col-sm-7">
                    <p><?php echo $birthdate;?></p>
                </div>
            </div>
        
            <div class="row">
                <div class="col-3 col-m-3 col-sm-3">
                    <h6>Password:</h6>
                </div>
                <div class="col-7 col-m-7 col-sm-7">
                    <p>***************</p>
                </div>

                <div class="col-1 col-m-1 col-sm-1">
                    <a href="#changepass" class="buttonchange">Change</a>
                </div>

                <div class="changeinfo" id="changepass">
                    <div class="row">
                        <h5>Change Password</h5>
                            <form action="">
                            <div class="form-group mb-3 col-md-12">
                                <label>Current Password:</label>
                                <input type="password" name="password" required>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label>&nbsp;&nbsp;&nbsp;&nbsp;New Password:</label>
                                <input type="password" name="password_1" required>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label>Confirm Password:</label>
                                <input type="password" name="password_2" required>
                            </div>
                            <button class="smallbutton1">Save Changes</button>
                        </form>
                        <h2><?php echo validation_errors();?></h2>
                        <a href="#"><button class="smallbutton2" id="close" >Cancel</button></a>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
</div>
<script>
    const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
    console.log(rgbaColor);
    document.querySelector('body').style.background = rgbaColor;
</script>
