<?php

    class PersonalInfo extends CI_Controller{
        public function __construct()
    {
        parent::__construct();
        $this->load->model('Personalize_model');

    }
        private $data = array();
        public function view(){
            $this->data["title"] = "My Information";
            $this->load->view("templates/header.php");
            $this->load->view("settings/personalinfo.php",$this->data);
            $this->load->view("templates/footer.php");
        }
        public function update(){
                // Rules for forms
                $this->form_validation->set_rules('username','Username','required|callback_checkUsername');
                $this->form_validation->set_rules('firstname','Firstname','required');
                $this->form_validation->set_rules('lastname','Lastname','required');
                $this->form_validation->set_rules('birthdate','Birthdate','required');
                $this->form_validation->set_rules('email','Email','required');
                $this->form_validation->set_rules('password','Current Password','required|callback_checkPassword');
                $this->form_validation->set_rules('password_1','New Password');
                $this->form_validation->set_rules('password_2', 'Confirm Password', 'callback_checkNewPassword');

                $this->data = $this->Personalize_model->getUserInfo($this->session->userdata('user_id'));
                
                if($this->form_validation->run()===false){
                    $this->data["title"] = "My Information";
                    $this->load->view("templates/header.php");
                    $this->load->view("settings/personalinfo.php",$this->data);
                    $this->load->view("templates/footer.php");     
                }else{
                    $data = array(
                        'username'=> $this->input->post("username"),
                        'firstname'=> $this->input->post("firstname"),
                        'lastname'=> $this->input->post("lastname"),
                        'birthdate'=> $this->input->post("birthdate"),
                      );
                    // For password not to be updated every change
                    $newPass = $this->input->post('password_1');
                    if ($newPass){
                        $data ['password'] = password_hash($newPass,PASSWORD_DEFAULT);
                    }
                    $this->Personalize_model->update_user($data); // Update database

                    $header['title'] = 'Settings';
                    $this->load->view("templates/header.php");
                    $this->load->view("pages/setting.php",$header);
                    $this->load->view("templates/footer.php");  
                }
            }
        
     
        function checkUsername($username){
            $this->form_validation->set_message('checkUsername', 'Username already exists');
            if($this->input->post('username') == $this->data['username']){ // Check if username is unchanged
                return true;
            }
            elseif ($this->Personalize_model->checkUserExist($username) == false) { 
                return true;
            } 
            else {
                return false;
            }
        }

        function checkPassword(){
            $this->form_validation->set_message('checkPassword', 'Incorrect Current Password');
            if (password_verify($this->input->post('password'), $this->data['password'])){
                return true;
            }
            else{
                return false;
            }
        }
        function checkNewPassword(){
            $this->form_validation->set_message('checkNewPassword', 'New password and confirm password does not match');
            $newPass = $this->input->post('password_1'); 
            $confirmPass = $this->input->post('password_2');

            // Conditions for making it an optional field
            if ($newPass){ // If new pass field has a value
                if ($newPass == $confirmPass){ // check if matches with confirm password
                    if ($newPass != $this->input->post('password')){ // then check if it is the same with old password
                        return true;
                    }
                    else{
                        // Print error here sayin "Cannot input old password"
                        return false;
                    }  
                }
                else{
                    return false;
                }
            }
            elseif(empty($newPass) && !empty($confirmPass)){ // If only confirm password has a value
                return false;
            }
            
            else{   // If both field has no value
                return true;    // Return true since it is optional
            }
        }
    }
?>