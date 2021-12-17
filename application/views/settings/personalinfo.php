<div class="container">
<br>
<br>
<br>
<br>
<h1><?=$title?></h1>
<div>
    <?php echo form_open("PersonalInfo/update") ;?>
            <div class="row">
                <div class="form-group mb-3 col-md-2"></div>
                    <div class="form-group mb-3 col-md-5">
                        <label>First Name</label>
                            <input type="text" class="myinput" name="firstname" required value="<?php echo $firstname;?>">
                            </div>
                            <div class="form-group mb-3 col-md-5">
                                <label>Last Name</label>
                                    <input type="text" class="myinput" name="lastname" required value="<?php echo $lastname;?>">
                                    </div>
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Username</label>
                                    <input type="text" class="form-control" name="username" required value="<?php echo $username;?>">
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Birthday</label>
                                    <input type="date" class="form-control" name="birthdate" required value="<?php echo $birthdate;?>">
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Email</label>
                                    <input type="email" class="form-control" name="email" required value="<?php echo $email;?>">
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Current Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">New Password</label>
                                    <input type="password" class="form-control" name="password_1">
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_2" >
                                </div>
                                <input type="submit" class="button1" value="Update Profile">
                            </form>
                        </div>
                        <div class="errorsignup">
                            <?php echo validation_errors();?>
                        </div>
</div>
</div>