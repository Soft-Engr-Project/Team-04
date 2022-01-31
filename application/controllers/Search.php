<?php

    class Search extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Comments_model');
            $this->load->model('Post_model');
            $this->load->model('Profile_model');
            $this->load->model('User_model');
        }

        public function view($results)
        {
            $userID = $this->session->userdata("user_id");
            $data["results"] = $results;
            
            $data["user"] = $this->user_model->get_user($userID);
            $data["categories"] = $this->categories_model->get_categories();
            
            // Show results
            $this->load->view("templates/header.php", $data);
            $this->load->view("pages/search");
            $this->load->view("templates/footer");
        }

        public function query_db()
        {
            $results = array();
            $comments = array();
            $keyword = $this->input->post('search');
            $results = $this->user_model->search_all($keyword);
           
            $this->view($results);
        }

        public function suggestions() {
            if($this->input->is_ajax_request()) {
                $keyword = $this->input->post();
                $data = $this->user_model->get_suggestions($keyword);
                echo json_encode($data);
            }
        
        }

        public function fetch()
        {
        $this->load->model('autocomplete_model');
        echo $this->user_model->fetch_data($this->uri->segment(3));
        }
    }
