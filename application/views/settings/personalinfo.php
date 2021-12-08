<h1><?=$title?></h1>
<div>
    <?php echo form_open("PersonalInfo/update") ;?>
            <div class="row">
                <div class="form-group mb-3 col-md-2"></div>
                    <div class="form-group mb-3 col-md-5">
                        <label>First Name</label>
                            <input type="text" class="myinput" name="firstname" required value="<?php echo $this->session->userdata('firstname');?>">
                            </div>
                            <div class="form-group mb-3 col-md-5">
                                <label>Last Name</label>
                                    <input type="text" class="myinput" name="lastname" required value="<?php echo $this->session->userdata('lastname');?>">
                                    </div>
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Username</label>
                                    <input type="text" class="form-control" name="username" required value="<?php echo $this->session->userdata('username');?>">
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Birthday</label>
                                    <input type="date" class="form-control" name="birthdate" required value="<?php echo $this->session->userdata('birthday');?>">
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Password</label>
                                    <input type="password" class="form-control" name="password_1" required value="<?php echo $this->session->userdata('password');?>">
                                </div>
                                <div class="form-group mb-3 col-md-12">
                                    <label class="labelsignup">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_2" required>
                                </div>
                                <input type="submit" class="button1" value="Update Profile">
                            </form>
                        </div>
                        <div class="errorsignup">
                            <?php echo validation_errors();?>
                        </div>
</div>
