<?php

    class Customization extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata("admin") || !$this->session->userdata("logged_in")) {
                redirect("/");
            } 
        }
        public function view()
        {
        	//for header pic
            $user_idIn = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($user_idIn);
            
            if(!$data["user"]) {
                show_404();
            }
            
            $data["title"] = "Customization";
            $this->pagetemplate->show("templates/sidebar", $data, "settings/customization");
        }
        public function uploadColor(){
            if ($this->input->is_ajax_request()) { // just additional, to make sure request is from ajax
                if ($this->input->post('submit')) {
                    $user = $_SESSION["username"];
                    $color = $this->input->post('color');

                    // to model
                    $this->personalize_model->saveBgColor($user,$color);

                    
                }
            }
        }
    }

