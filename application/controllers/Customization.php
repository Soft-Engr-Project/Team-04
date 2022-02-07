<?php

    class Customization extends CI_Controller
    {


        public function __construct()
        {
            parent::__construct();
            $this->load->model('Personalize_model');
        }
        

        public function view()
        {
        	//for header pic
            $user_idIn = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($user_idIn);
            
            $data["title"] = "Customization";
            $this->load->view("templates/header", $data);
            $this->load->view("templates/sidebar", $data);
            $this->load->view("settings/customization");
            $this->load->view("templates/footer");
        }
        public function uploadColor(){
            if ($this->input->is_ajax_request()) { // just additional, to make sure request is from ajax
                if ($this->input->post('submit')) {
                    $user = $_SESSION["username"];
                    $color = $this->input->post('color');

                    // to model
                    $this->Personalize_model->saveBgColor($user,$color);

                    
                }
            }
        }
    }

