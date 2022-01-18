<?php

    class Customization extends CI_Controller
    {
        private $data;
        public function view()
        {
        	//for header pic
            $user_idIn = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($user_idIn);
            $this->load->view("templates/header.php",$this->data);
        	
            $this->data["title"] = "Customization";
            $this->load->view("templates/header.php");
            $this->load->view("settings/customization.php",$this->data);
            $this->load->view("templates/footer.php");
        }
    }

?>