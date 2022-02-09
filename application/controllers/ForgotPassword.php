<?php
//
    class ForgotPassword extends CI_Controller
    {
        public function forgot_password()
        {
            $this->form_validation->set_rules('email','Email','required|callback_checkEmailVerify');
            if($this->form_validation->run()===false) {
                $this->pagetemplate->showlogin("pages/forgot_password");
            }else {
                // Code Generation
                $passcode = random_int(100000,999999);  // Generate 6 digit value
                
                // get user info and generate 6 digit code to be sent on email
                $email = $this->input->post('email'); //Get user email input
                $this->resetpassword->passcode($email, $passcode); //pass the code and update the database
                $user = $this->resetpassword->get_user($email);
                $emailData = array(
                'header' => 'Account Password Reset:',
                'user' => $user,
                'passcode' => $passcode,
                'body' => 'Please Enter the 6 digit pin given above to proceed on changing password.'
                 );
                $this->send($email, 'templates/ChangePass_Email.php', $emailData); // Call email setup function

                //logout user if user attempts to change pass when currently logged in and same input to change pass
                //if(($this->session->userdata('lock_id') != 1) && ($this->session->userdata('email') == $email)) {

                // logout all sessions
                if(($this->session->userdata('lock_id') != 1)) { //if user force to visit from login
                    $this->session->unset_userdata(array('username', 'user_id', 'email', 'success', 'logged_in'));
                }

                $lockID = 0; // to lock out user attempt to access other pages
                $newdata = array('email'=>$email, 'lock_id'=>$lockID);
                $this->session->set_userdata($newdata);

                $this->pagetemplate->showlogin("pages/passcode");

            }
        }

        // EMAIL MESSAGE SETUP
        public function send($email,$template,$emailData)
        {
            $to =  $email;
            $subject = 'Change Password';
            $from = 'thinklikblog@gmail.com';
            $password = env('PASSWORD'); //get password from env file

            // Config setup
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => '465',
                'smtp_timeout' => '60',
                'smtp_user' => 'thinklikblog@gmail.com',
                'smtp_pass' => $password,
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'mailtype' => 'html'
            );

            // Setup email from autoload['helper']
            $this->email->initialize($config);
            $this->email->set_mailtype("html");
            $this->email->from($from);
            $this->email->to($to);
            $this->email->subject($subject);

            // Load the format and content of email
            $message=$this->email->message($this->load->view($template, $emailData, true));
  
            $status=$this->email->send(); // Send the email  
        }


        public function checkEmailVerify($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('checkEmailVerify', 'Invalid email format');
                return false;
            }
            if ($this->resetpassword->checkEmail($email) == false) {
                 $this->form_validation->set_message('checkEmailVerify', 'Email does not exist');
                 return false;
            } 
            else {
             $this->form_validation->set_message('checkEmailVerify', 'Change password link sent to your email');
                return true;
            }
        }  

        public function passverify()
        {
            $email = $this->session->userdata('email');
            if($this->session->userdata('email') == NULL) { //if user forces to visit
                redirect("/");
            }
            else {
                $passcode = $this->input->post('passcode');
                //check if same passcode
                $query= $this->resetpassword->check_passcode($email, $passcode);
                // If true, direct to change password
                if ($query) {
                    $this->session->set_userdata(array('lock_id'=>1));
                    $this->pagetemplate->showlogin("pages/change_password");
               
                }
                else {
                    $this->form_validation->set_rules("passcode","Code","callback_checkCode");
                    if($this->form_validation->run() == false) {
                        $this->pagetemplate->showlogin("pages/passcode");
                    }
                    else {
                        redirect("ForgotPassword/passverify");
                    }
                }
            }
        }

        // check the code if it has an error
        public function checkCode($code){
            if(is_null($this->resetpassword->get_code($code))) {
                $this->form_validation->set_message('checkCode', 'Wrong passcode');
                return false;
            }
            else {
                return true;
            }
        }
        

        public function change_pass()
        {
            $email = $this->session->userdata('email');
            if(($this->session->userdata('lock_id') != 1) && ($this->session->userdata('email') != NULL)) { //if user force to visit from login
                redirect("/");
            }
            else {
                //if user attempts to directly visit change pass, destroy session
                if($this->session->userdata('lock_id') != 1) {
                    $this->session->sess_destroy();
                    redirect("/");
                }
                $this->form_validation->set_rules('password_1', 'Password', 'required');
                $this->form_validation->set_rules('password_2', 'Confirm Password', 'required|callback_checkNewPassword');
                if($this->form_validation->run()===false) { 
                    $this->pagetemplate->showlogin("pages/change_password");
                }
                else {
                    $hashedPass = password_hash($this->input->post("password_1"), PASSWORD_DEFAULT);
                    $dataPass = array(
                              'password' => $hashedPass,
                            );
                    $query = $this->resetpassword->change_pass($email, $dataPass);
                        if ($query) {
                        $this->pagetemplate->showlogin("pages/passwordverify");
                        
                        $this->session->sess_destroy();
                    }
                }
            }
        }
        
        public function checkNewPassword($password)
        {
            $this->form_validation->set_message('checkNewPassword', 'New password and confirm password does not match');
            $email = $this->session->userdata('email');
            $newPass = $this->input->post('password_1'); 
            $confirmPass = $password;
            $oldPass = $this->resetpassword->get_old_password($email);
            
            // Conditions for making it an optional field
            if ($newPass) { // If new pass field has a value
                if ($newPass == $confirmPass) { // check if matches with confirm password
                    if (!password_verify($newPass, $oldPass)) { // then check if it is the same with old password
                        if (preg_match('#[0-9]#', $newPass) && preg_match('#[a-z]#', $newPass)  && preg_match('#[A-Z]#', $newPass)) {
                            return true;
                        }
                        else {
                            $this->form_validation->set_message('checkNewPassword', 'The password field must be contains at least one digit, one capital and small letter.');
                            return false;
                        }
                    }
                    else {
                        $this->form_validation->set_message('checkNewPassword', 'Cannot input old password');
                        return false;
                    }  
                }
                else{
                    return false;
                }
            }
            elseif(empty($newPass) && !empty($confirmPass)) { // If only confirm password has a value
                return false;
            }
            
            else {   // If both field has no value
                return true;    // Return true since it is optional
            }
        }
    }

