<?php

	class Admins extends CI_Controller
	{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Reports_model');
            $this->load->model('SubcommentModel');
            $this->load->model('Admin_model');
            $this->load->model('User_model');
            $this->load->model('Categories_model');
            $this->load->model('Post_model');
        }

        public function dashboard($id=NULL)
        {
            // Load data to be passed
            $data["counts"] = $this->Admin_model->total_counts();
            $data["reports"]  = $this->Reports_model->get_reports();
            
            // Show reports
            $this->load->view("templates/adminheader");
            $this->load->view("admin/dashboard", $data);
            $this->load->view("templates/adminfooter");
        }

        public function categories($id=NULL)
        {
            //Load data to be passed
            $data["counts"] = $this->Admin_model->total_counts("categories");
            $data["categories"] = $this->Categories_model->get_categories();

            // Show reports
            $this->load->view("templates/adminheader");
            $this->load->view("admin/categories", $data);
            $this->load->view("templates/adminfooter");
        }

        public function posts($id=NULL)
        {
            // Load data to be passed
            $data["posts"] = $this->post_model->get_posts();
            $data["counts"] = $this->Admin_model->total_counts("posts");

            // Show reports
            $this->load->view("templates/adminheader");
            $this->load->view("admin/posts", $data);
            $this->load->view("templates/adminfooter");
        }

        public function profile($id=NULL)
        {
            $userID = $this->session->userdata("user_id");

            // Load data to be passed
            $data["admin"] = $this->Admin_model->admin_info($userID);

            // Show reports
            $this->load->view("templates/adminheader");
            $this->load->view("admin/profile", $data);
            $this->load->view("templates/adminfooter");
        }

        public function users($id=NULL)
        {
            $data["users"] = $this->User_model->get_user();
            $data["counts"] = $this->Admin_model->total_counts("users");

            // Show reports
            $this->load->view("templates/adminheader");
            $this->load->view("admin/users", $data);
            $this->load->view("templates/adminfooter");
        }

        public function fetchUser(){
            $data["users"] = $this->User_model->get_user();
            echo json_encode($data);
        }
    }