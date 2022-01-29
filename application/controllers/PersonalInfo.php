<?php

    class PersonalInfo extends CI_Controller
    {
        private $data = array();

        public function __construct()
        {
            parent::__construct();
            $this->load->model('Personalize_model');
        }

        public function view()
        {
            //for header pic
            $userID = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($userID);
            $this->load->view("templates/header",$this->data);

            $this->data["title"] = "My Information";
            $this->load->view("templates/header",$this->data);
            $this->load->view("settings/personalinfo",$this->data);
            $this->load->view("templates/footer");
        }

        public function update()
        {
            //for header pic
            $userID = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($userID);
            $this->load->view("templates/header",$this->data);

            // Rules for forms
            $this->form_validation->set_rules('username','Username','required|callback_checkUsername');
            $this->form_validation->set_rules('firstname','Firstname','required');
            $this->form_validation->set_rules('lastname','Lastname','required');
            $this->form_validation->set_rules('birthdate','Birthdate','required|callback_checkBirthdate');
            $this->form_validation->set_rules('email','Email','required');
            $this->form_validation->set_rules('password','Current Password','required|callback_checkPassword');
            $this->form_validation->set_rules('password_1','New Password');
            $this->form_validation->set_rules('password_2', 'Confirm Password', 'callback_checkNewPassword');

            $this->data = $this->Personalize_model->getUserInfo($userID);
            
            if($this->form_validation->run()===false) {
                $this->data["title"] = "My Information";
                $this->load->view("settings/personalinfo",$this->data);
                $this->load->view("templates/footer");     
            }
            else {
                $userData = array(
                    'username'=> $this->input->post("username"),
                    'firstname'=> $this->input->post("firstname"),
                    'lastname'=> $this->input->post("lastname"),
                    'birthdate'=> $this->input->post("birthdate"),
                    );
                // For password not to be updated every change
                $newPass = $this->input->post('password_1');
                if ($newPass) {
                    $userData ['password'] = password_hash($newPass,PASSWORD_DEFAULT);
                }
                $this->Personalize_model->update_user($userData); // Update database

                $header['title'] = 'Settings';
                $this->load->view("pages/settings",$header);
                $this->load->view("templates/footer");
            }
        }
        
        
        private function checkUsername($username)
        {
            $this->form_validation->set_message('checkUsername', 'Username already exists');
            if($this->input->post('username') == $this->data['username']) { // Check if username is unchanged
                return true;
            }
            elseif ($this->Personalize_model->checkUserExist($username) == false) {
                return true;
            } 
            else {
                return false;
            }
        }

        private function checkPassword($password)
        {
            $this->form_validation->set_message('checkPassword', 'Incorrect Current Password');
            if (password_verify($password, $this->data['password'])) {
                return true;
            }
            return false;
        }

        private function checkBirthdate($birthdate)
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

        private function is_password_strong($password) {
            $this->form_validation->set_message('check_strong_password', 'The password field must be contains at least one letter and one digit.');
            if (preg_match('#[0-9]#', $password) && preg_match('#[a-z]#', $password)  && preg_match('#[A-Z]#', $password)) {
                return TRUE;
            }
            return FALSE;
        }

        private function checkNewPassword($password2){
            $this->form_validation->set_message('checkNewPassword', 'New password and confirm password does not match');
            $newPass = $this->input->post('password_1'); 
            $confirmPass = $password2;

            // Conditions for making it an optional field
            if ($newPass) { // If new pass field has a value
                if ($newPass == $confirmPass) { // check if matches with confirm password
                    if ($newPass != $this->input->post('password')) { // then check if it is the same with old password
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
?>