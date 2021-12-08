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
                $this->form_validation->set_rules('username','Username','required');
                $this->form_validation->set_rules('firstname','Firstname','required');
                $this->form_validation->set_rules('lastname','Lastname','required');
                $this->form_validation->set_rules('birthdate','Birthdate','required');
                $this->form_validation->set_rules('email','Email');
                $this->form_validation->set_rules('password_1','Password','required');
                $this->form_validation->set_rules('password_2', 'Confirm Password', 'required|matches[password_1]');

                if($this->form_validation->run()===false){
                    $this->data["title"] = "My Information";
                    $this->load->view("templates/loginheader.php");
                    $this->load->view("settings/personalinfo.php",$this->data);
                    $this->load->view("templates/footer.php");     
                }else{
                    var_dump($this->session->userdata('user_id'));
                    $this->Personalize_model->update_user();
                }
            }
            function checkUserName($username){
                if ($this->Personalize_model->checkUserExist($username) == false) {
                     return true;
                } 
                else {
                 $this->form_validation->set_message('checkUserName', 'Username already exists');
                    return false;
                }
            }
    }
?>