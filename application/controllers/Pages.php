<?php

    class Pages extends CI_Controller
    {
        private $data = array();
        public function view($page ='home')
        {
            // APPPATH - ROOT FOLDER
            //THIS IF CHECK IF WE HAVE FOLDER PAGES IN THE VIEW AND IF IT HAS PAGES FOLDER THEN FIND A SPECIFIC
            // PHP FILE

            //for header pic
            $userIdIn = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($userIdIn);
            $this->load->view("templates/header",$this->data);

            if(!file_exists(APPPATH."views/pages/".$page."")) {
               show_404();
            }
            
            if($page == "home") {
               $this->data["title"]=ucfirst($page);
               $this->data["categories"] = $this->categories_model->get_categories();
               $this->data["posts"] = $this->post_model->get_posts_high_react();
               $this->data["notification_count"] = $this->notification_model->get_notification_count($userIdIn);
               $this->data["notification"] = $this->notification_model->get_notification($userIdIn);
               $this->load->view("pages/".$page,$this->data);
               $this->data["title"] = " Latest Post";
               $this->data["posts"] = $this->post_model->get_posts();
               $this->load->view("posts/index",$this->data);
            }
            else {
                $this->data["title"]=ucfirst($page);
                $this->load->view("pages/".$page,$this->data);
            }
            $this->load->view("templates/footer");
        }
    }





?>