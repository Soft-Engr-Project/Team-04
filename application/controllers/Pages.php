<?php

    class Pages extends CI_Controller
    {
        
        public function view($page ='home')
        {   
            
            // APPPATH - ROOT FOLDER
            //THIS IF CHECK IF WE HAVE FOLDER PAGES IN THE VIEW AND IF IT HAS PAGES FOLDER THEN FIND A SPECIFIC
            // PHP FILE

            //for header pic
            $userIdIn = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($userIdIn);
            if ($this->session->userdata("admin") || !$this->session->userdata("logged_in")) {
                redirect("/");
            }else {
                if(!file_exists(APPPATH."views/pages/".$page.".php")) {
                    show_404();
                }
                if($page == "home") {
                    $data["categories"] = $this->categories_model->get_categories();
                    $data["postsTop"] = $this->post_model->get_posts_high_react();
                    $data["notification_count"] = $this->notification_model->get_notification_count($userIdIn);
                    $data["notification"] = $this->notification_model->get_notification($userIdIn);
                    $data["title"] = " Latest Post";
                    $data["posts"] = $this->post_model->get_posts();
                    
                    // Load Body
                    $this->pagetemplate->show("pages/".$page, $data, "posts/index");
                }
                else {
                    $data["title"]=ucfirst($page);
                    $this->pagetemplate->show("pages/".$page, $data);
                }
            }
        }
    }





