<?php

    class Profiles extends CI_Controller{
        
        public function view(){
            $user_id = $this->session->userdata("user_id");
            $this->data["title"]="Profile";
            $this->data['posts'] = $this->profile_model->get_user_posts($user_id);
            $this->data["react_count"] = $this->profile_model->get_all_reaction($user_id);
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