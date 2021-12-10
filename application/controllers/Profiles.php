<?php

    class Profiles extends CI_Controller{
        
        public function view(){
            $this->data["title"]="Profile";
            $this->data['posts'] = $this->post_model->get_posts();
            $this->load->view("templates/header.php");
            $this->load->view("profiles/profile.php",$this->data);
            $this->data["title"]="Personal Information";
            $this->load->view("profiles/information.php",$this->data);
            $this->data["title"]="My Threads";
            $this->load->view("profiles/index",$this->data);
            $this->load->view("templates/footer.php");
        }
    }




?>