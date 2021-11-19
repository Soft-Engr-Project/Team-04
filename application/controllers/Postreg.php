<?php
//
    class Postreg extends CI_Controller{
        private $data = array();
           public function login(){
            $this->form_validation->set_rules('username','Username','required');
            $this->form_validation->set_rules('password','Password','required');
            if($this->form_validation->run()===false){
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/login",$this->data);
                $this->load->view("templates/footer.php");     
            }else{
                $this->server->login_user();
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/view",$this->data);
                $this->load->view("templates/footer.php");     
            }
        }

        public function logout()
        {
            $this->session->unset_userdata(array('username','id'));
            $this->session->sess_destroy();
            redirect("/");
        }

        public function register(){
            $this->form_validation->set_rules('username','Username','required|callback_checkUserName');
            $this->form_validation->set_rules('firstname','Firstname','required');
            $this->form_validation->set_rules('lastname','Lastname','required');
            $this->form_validation->set_rules('birthdate','Birthdate','required');
            $this->form_validation->set_rules('email','Email','required|callback_checkEmail');

            $this->form_validation->set_rules('password_1','Password','required');
            $this->form_validation->set_rules('password_2', 'Confirm Password', 'required|matches[password_1]');
            if($this->form_validation->run()===false){
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/signup",$this->data);
                $this->load->view("templates/footer.php");     
            }else{
                $this->server->reg_user();
                redirect("postreg/login");
            }
        }

        function checkUserName($username){
            if ($this->server->checkUserExist($username) == false) {
                 return true;
            } 
            else {
             $this->form_validation->set_message('checkUserName', 'Username already exists');
                return false;
            }
        }

        function checkEmail($email){
            if ($this->server->checkEmail($email) == false) {
                 return true;
            } 
            else {
             $this->form_validation->set_message('checkEmail', 'Email already exists');
                return false;
            }
        }       

    }

?>