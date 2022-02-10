<?php
    
	class Admins extends CI_Controller
    {   
        public function __construct()
        {
            parent::__construct();
            if (!$this->session->userdata("admin")) {
                redirect("/");
            } 
        }

        public function dashboard($id = null)
        {
            // Load data to be passed
            $data["counts"] = $this->admin_model->total_counts();
            $data["reports"]  = $this->reports_model->get_reports();
            
            // Show reports]
            $this->pagetemplate->showadmin("admin/dashboard", $data);
        }
        public function fetchDashboard() {
            if($this->input->is_ajax_request()) {
                 $reports  = $this->reports_model->get_reports();
                 $json_data = $reports;
                echo json_encode($json_data);
            }
        }
        public function categories($id = null)
        {
            //Load data to be passed
            $data["counts"] = $this->admin_model->total_counts("categories");
            $data["categories"] = $this->categories_model->get_categories();

            // Show reports
            $this->pagetemplate->showadmin("admin/categories", $data);
        }

        public function posts($id=NULL)
        {
            // Load data to be passed
            $data["posts"] = $this->post_model->get_posts();
            $data["counts"] = $this->admin_model->total_counts("posts");

            // Show reports
            $this->pagetemplate->showadmin("admin/posts", $data);
        }

        public function profile($id=NULL)
        {
            $userID = $this->session->userdata("user_id");

            // Load data to be passed
            $data["admin"] = $this->admin_model->admin_info($userID);

            // Show reports
            $this->pagetemplate->showadmin("admin/profile", $data);
        }

        public function users($id=NULL)
        {
            $data["users"] = $this->user_model->get_user();
            $data["counts"] = $this->admin_model->total_counts("users");

            // Show reports
            $this->pagetemplate->showadmin("admin/users", $data);
        }

        

        public function fetchUsers(){
            $data["users"] = $this->user_model->get_user();
            echo json_encode($data);
        }

        public function fetchUserInfo(){
            $userID = $this->input->post('user_id');
            $data["user"] = $this->user_model->get_user($userID);
            echo json_encode($data);
        }

        public function suspend(){
            $userID = $this->input->post('user_id');
            $date['resumeDate'] = $this->input->post('date');

            $this->admin_model->suspend_user($userID, $date);
            $jsonData = array("response" => "success", "message" => "User is suspended");
            echo json_encode($jsonData);
        }

    }