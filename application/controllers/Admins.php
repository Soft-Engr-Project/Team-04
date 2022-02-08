<?php
    
	class Admins extends CI_Controller
    {
        
        public function __construct()
        {
         
            parent::__construct();
            if (!$this->session->userdata("admin")) {
                show_404();
            }else {
                $this->load->model('Reports_model');
                $this->load->model('SubcommentModel');
                $this->load->model('Admin_model');
                $this->load->model('User_model');
                $this->load->model('Categories_model');
                $this->load->model('Post_model');
            }
            
            
        }

        public function dashboard($id = null)
        {
            // Load data to be passed
            $data["counts"] = $this->Admin_model->total_counts();
            $data["reports"]  = $this->Reports_model->get_reports();
            
            // Show reports
            $this->showView("admin/dashboard", $data)
        }

        public function categories($id = null)
        {
            //Load data to be passed
            $data["counts"] = $this->Admin_model->total_counts("categories");
            $data["categories"] = $this->Categories_model->get_categories();

            // Show reports
            $this->showView("admin/categories", $data);
        }

        public function posts($id=NULL)
        {
            // Load data to be passed
            $data["posts"] = $this->post_model->get_posts();
            $data["counts"] = $this->Admin_model->total_counts("posts");

            // Show reports
            $this->load->showView("admin/posts", $data);
        }

        public function profile($id=NULL)
        {
            $userID = $this->session->userdata("user_id");

            // Load data to be passed
            $data["admin"] = $this->Admin_model->admin_info($userID);

            // Show reports
            $this->showView("admin/profile", $data);
        }

        public function users($id=NULL)
        {
            $data["users"] = $this->User_model->get_user();
            $data["counts"] = $this->Admin_model->total_counts("users");

            // Show reports
            $this->showView("admin/users", $data);
        }

        // For showing the html
        private function showView($views, $data)
        {
            $this->load->view("templates/adminheader");
            $this->load->view($views, $data);
            $this->load->view("templates/adminfooter");
        }

        public function fetchUsers(){
            $data["users"] = $this->User_model->get_user();
            echo json_encode($data);
        }

        public function fetchUserInfo(){
            $userID = $this->input->post('user_id');
            $data["user"] = $this->User_model->get_user($userID);
            echo json_encode($data);
        }

        public function suspend(){
            $userID = $this->input->post('user_id');
            $date['resumeDate'] = $this->input->post('date');

            $this->Admin_model->suspend_user($userID, $date);
            $jsonData = array("response" => "success", "message" => "User is suspended");
            echo json_encode($jsonData);
        }

    }