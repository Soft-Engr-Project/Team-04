<?php

    class PersonalInfo extends CI_Controller
    {
        public function update()
        {
            //for header pic
            $userID = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($userID);

            // Personal Info
            $data = $this->personalize_model->getUserInfo($userID);
            $data["pageSection"] = '';
            $data["title"] = "My Information";

            $this->pagetemplate->show("templates/sidebar", $data, "settings/personalinfo");
        }
        
        public function changename()
        {
            //for header pic
            $userID = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($userID);
            // Rules for forms
            $this->form_validation->set_rules('firstname','Firstname','required');
            $this->form_validation->set_rules('lastname','Lastname','required');
            $this->form_validation->set_rules('password','Current Password','required|callback_checkPassword');
            $data = $this->personalize_model->getUserInfo($userID);
            if($this->form_validation->run()===false) {
                $data["title"] = "My Information";
                $data["errorname"] = validation_errors();
                $data["pageSection"] = 'changename';

                $this->pagetemplate->show("templates/sidebar", $data, "settings/personalinfo");
            }
            else {
                $userData = array(
                    'firstname'=> $this->input->post("firstname"),
                    'lastname'=> $this->input->post("lastname"),
                    );
                $this->personalize_model->update_user($userData); // Update database
                $data['title'] = 'Settings';
                $data["user"] = $this->user_model->get_user($userID);

                $this->pagetemplate->show("templates/sidebar", $data, "templates/header");
                redirect("Personalinfo/update");    
            }
        }

        public function changeemail()
        {
            //for header pic

            $userID = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($userID);
            // Rules for forms
            $this->form_validation->set_rules('email','Email','required|callback_checkEmail');
            $this->form_validation->set_rules('confemail', 'Confirm Email', 'required|matches[email]');
            $this->form_validation->set_rules('password','Current Password','required|callback_checkPassword');
            $this->form_validation->set_rules('otp','Code','required|callback_checkOTP');
            $data = $this->personalize_model->getUserInfo($userID);

            $this->form_validation->set_error_delimiters('','');
            if($this->form_validation->run()===false) {
                $data["title"] = "My Information";
                $data["errormail"] = validation_errors();
                 $data["pageSection"] = 'changeemail';
                 $this->pagetemplate->show("templates/sidebar", $data, "settings/personalinfo");
            }
            else {
                $userData = array(
                    'email' => $this->input->post("email"),
                );
                $this->personalize_model->update_user($userData); // Update database

                $newEmail = array('email'=>$this->input->post("email"));
                $this->session->set_userdata($newEmail);

                $data['title'] = 'Settings';
                $data["user"] = $this->user_model->get_user($userID);
                $this->pagetemplate->show("templates/sidebar", $data, "templates/header");
                redirect("Personalinfo/update"); 
            }
        }

        public function changepass()
        {
            //for header pic
            $userID = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($userID);

            // Rules for forms
            $this->form_validation->set_rules('password','Current Password','required|callback_checkPassword');
            $this->form_validation->set_rules('password_1','New Password');
            $this->form_validation->set_rules('password_2', 'Confirm Password', 'callback_checkNewPassword');
            $data = $this->personalize_model->getUserInfo($userID);
            if($this->form_validation->run()===false) {
                $data["title"] = "My Information";
                $data["errorpass"] = validation_errors();
                $data["pageSection"] = 'changepass';
                $this->pagetemplate->show("templates/sidebar", $data, "settings/personalinfo");
            }
            else {
                $userData = array();
                // For password not to be updated every change
                $newPass = $this->input->post('password_1');
                if ($newPass) {
                    $userData ['password'] = password_hash($newPass,PASSWORD_DEFAULT);
                }
                $this->personalize_model->update_user($userData); // Update database

                $data['title'] = 'Settings';
                $data["user"] = $this->user_model->get_user($userID);
                $this->pagetemplate->show("templates/sidebar", $data, "templates/header");
                redirect("Personalinfo/update");
            }
        }

        public function checkEmail($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('checkEmail', 'Invalid email format');
                return false;
            } 
           
            if ($this->personalize_model->checkEmail($email) == false) {
                 return true;
            }else {
             $this->form_validation->set_message('checkEmail', 'Email already exists');
                return false;
            }
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

        public function sendOTP(){
            // Code Generation
            $code = random_int(0,999999);  // Generate hash value
            $code = str_pad($code, 6, 0, STR_PAD_LEFT);
            $email = $this->session->userdata("email");
            $userData = array(
                'code' => $code,
                );
            $this->personalize_model->update_user($userData); // Update passcode

            // send code to current email
            $emailData = array(
                'header' => 'Account Change Email:',
                'user' => $this->session->userdata("username"),
                'passcode' => $code,
                'body' => 'Please Enter the 6 digit pin given above to proceed on changing Email.'
            );
            $this->send($email, 'templates/ChangePass_Email.php', $emailData); // Call email setup function

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

        public function checkOTP($otp)
        {
            if ($this->personalize_model->checkotp($otp) == false) {
                 $this->form_validation->set_message('checkOTP', 'invalid Code');
                 return false;
            } 
            else {
                return true;
            }
        }

        public function checkUsername($username)
        {
            $this->form_validation->set_message('checkUsername', 'Username already exists');
            if($this->input->post('username') == $username) { // Check if username is unchanged
                return true;
            }elseif ($this->personalize_model->checkUserExist($username) == false) {
                return true;
            }else {
                return false;
            }
        }

        public function checkPassword($password)
        {
            $this->form_validation->set_message('checkPassword', 'Incorrect Current Password');
            $data = $this->personalize_model->getUserInfo($this->session->userdata("user_id"));
            if (password_verify($password, $data['password'])) {
                return true;
            }
            return false;
        }

        public function checkBirthdate($birthdate)
        {
            $this->form_validation->set_message('checkBirthdate', 'User must be 13 and above to create an account');
            $dob = new DateTime($birthdate);
            $now = new DateTime();
            $difference = $now->diff($dob);
            $age = $difference->y;
            if($age<13) {
                return false;
            }
            return true;
        }

        public function checkNewPassword($password2)
        {
            $this->form_validation->set_message('checkNewPassword', 'New password and confirm password does not match');
            $newPass = $this->input->post('password_1');
            $oldPass = $this->personalize_model->getUserInfo($this->session->userdata("user_id"))['password'];
            $confirmPass = $password2;

            // Conditions for making it an optional field
            if ($newPass) { // If new pass field has a value
                if ($newPass == $confirmPass) { // check if matches with confirm password
                    if (!password_verify($newPass, $oldPass)) { // then check if it is the same with old password
                        if (preg_match('#[0-9]#', $newPass) && preg_match('#[a-z]#', $newPass)  && preg_match('#[A-Z]#', $newPass)) {
                            return true;
                        }else {
                            $this->form_validation->set_message('checkNewPassword', 'The password field must be contains at least one digit, one capital and small letter.');
                            return false;
                        }
                    }else {
                        $this->form_validation->set_message('checkNewPassword', 'Cannot input old password');
                        return false;
                    }  
                }else{ 
                    return false;
                }
            }elseif(empty($newPass) && !empty($confirmPass)) { // If only confirm password has a value
                return false;
            }else {   // If both field has no value
                return true;    // Return true since it is optional
            }
        }



    }




    
