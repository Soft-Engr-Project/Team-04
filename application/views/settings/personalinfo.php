<script>
 $(document).ready(function(){
    window.location.href='#<?php echo $pageSection;?>';
});
</script>

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
                    <p><?php echo $user["username"];?></p>
                </div>
           </div>
        
            <div class="row">
                <div class="col-3 col-m-3 col-sm-3">
                    <h6>Name:</h6>
                </div>
                <div class="col-7 col-m-7 col-sm-7">
                    <p><?php echo $user["firstname"];?> <?php echo $user["lastname"];?></p>
                </div>

                <div class="col-1 col-m-1 col-sm-1">
                    <a href="#changename" class="buttonchange">Change</a>
                </div>  
                
                <div class="changeinfo" id="changename">
                    <div class="row">
                        <h5>Change Name</h5>
                            <?php echo form_open("PersonalInfo/changename") ;?>
                            <div class="form-group mb-3 col-md-12">
                                <label>First Name:</label>
                                <input type="text" name="firstname" required value="<?php echo $user["firstname"];?>">
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label>&nbsp;Last Name:</label>
                                <input type="text" name="lastname" required value="<?php echo $user["lastname"];?>">
                            </div>
                            <p>Please enter your password to save changes</p>
                            <div class="form-group mb-3 col-md-12">
                                <label>&nbsp;&nbsp;Password:</label>
                                <input type="password" name="password" required>
                            </div>
                            <button class="smallbutton1" value="Update Profile">Save Changes</button>
                        </form>
                        <h2 class="error"><?php echo isset($errorname)? $errorname : "";?></h2>
                        <a href="#"><button class="smallbutton2" id="close" >Cancel</button></a>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-3 col-m-3 col-sm-3">
                    <h6>Email:</h6>
                </div>
                <div class="col-7 col-m-7 col-sm-7">
                    <p><?php echo $user["email"];?></p>
                </div>

                <div class="col-1 col-m-1 col-sm-1">
                    <a href="#changeemail" class="buttonchange">Change</a>
                </div>

                <div class="changeinfo" id="changeemail">
                    <div class="row">
                        <h5>Change Email</h5>
                            <?php echo form_open("PersonalInfo/changeemail") ;?>
                            <div class="form-group mb-3 col-md-12">
                                <label>New Email:</label>
                                <input type="email" name="email" id="email" required>
                            </div>
                            <div style="padding-right: 38px;" class="form-group mb-3 col-md-12">
                                <label>Confirm Email:</label>
                                <input type="email" name="confemail" id="email" required>
                            </div>
                            <div style="padding-left: 50px;" class="form-group mb-3 col-md-12">
                                <label>Code:</label>
                                <input type="text" name="otp" placeholer="Enter your otp"/>
                                <button id="regenerateOTP" class="btn btn-warning btn_shadow" style="border-radius: 0; padding:0; top:537px; right:0px; margin-right: 380px; position:absolute" ><span id="timer">Code</span></button> 
                                <script>
                                    $('#regenerateOTP').on('click', function () {
                                      disableResend();
                                      timer(60);
                                            $.ajax({
                                                url: "<?php echo base_url()?>PersonalInfo/sendOTP",
                                            });

                                        });

                                    function disableResend()
                                    {
                                         $("#regenerateOTP").attr("disabled", true);
                                         timer(60);
                                          //$('.regenerateOTP').prop('disabled', true);
                                          setTimeout(function() {
                                            // enable click after 1 second
                                         $('#regenerateOTP').removeAttr("disabled");
                                            // $('.disable-btn').prop('disabled', false);
                                          }, 60000); // 1 second delay
                                    }

                                    let timerOn = true;

                                    function timer(remaining) {
                                      var m = Math.floor(remaining / 60);
                                      var s = remaining % 60;
                                      
                                      m = m < 10 ? '0' + m : m;
                                      s = s < 10 ? '0' + s : s;
                                      resend = "Resend";
                                      document.getElementById('timer').textContent = m + ':' + s;
                                      remaining -= 1;
                                      
                                      if(remaining >= 0 && timerOn) {
                                        setTimeout(function() {
                                            timer(remaining);
                                        }, 1000);
                                        return;
                                      }

                                      if(!timerOn) {
                                        return;
                                      }
                                      document.getElementById('timer').textContent = resend;
                                      return;
                                    }
                                </script>
                            </div>
                            <div style="padding-right: 6px;" class="form-group mb-3 col-md-12">
                                <label>&nbsp;&nbsp;Password:</label>
                                <input type="password" name="password"required>
                            </div>
                            <p class="reminder">Reminder: Please check your code to your CURRENT Email to verify. Thank you</p>
                            <button class="smallbutton1">Save Changes</button>
                        </form>
                        <h2 class="error" ><?php echo isset($errormail)? $errormail : "";?></h2>
                        <a href="#"><button class="smallbutton2" id="close" >Cancel</button></a>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-3 col-m-3 col-sm-3">
                    <h6>Birthdate:</h6>
                </div>
                <div class="col-7 col-m-7 col-sm-7">
                    <p><?php echo $user["birthdate"];?></p>
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
                            <?php echo form_open("PersonalInfo/changepass") ;?>
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
                        <h2 class="error"><?php echo isset($errorpass)? $errorpass : "";?></h2>
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
