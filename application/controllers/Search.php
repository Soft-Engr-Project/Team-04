<?php

    class Search extends CI_Controller
    {

        private $data = array();

        public function __construct()
        {
            parent::__construct();
            $this->load->model('Comments_model');
            $this->load->model('Post_model');
            $this->load->model('Profile_model');
        }

        public function view($results)
        {
            $userID = $this->session->userdata("user_id");
            $this->data["results"] = $results;
            $userID = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($userID);
            $this->data["categories"] = $this->categories_model->get_categories();
       
            // Show results
            $this->load->view("templates/header.php");
            $this->load->view("pages/search",$this->data);
            $this->load->view("templates/footer",$this->data);
        }

        public function query_db()
        {
            $results = array();
            $comments = array();
            $keyword = $this->input->post('search');
            $profiles = $this->profile_model->get_usernames();
            $posts = $this->Post_model->get_posts_content();
            foreach ($posts as $post) {
                $comments += $this->comments_model->get_comments_content($post['id']);
            }
            
            // Search in users
            $results["Profiles"] = array();
            foreach ($profiles as $user) {
                foreach ($user as $key => $value) { 
                    if (str_contains($value,$keyword)) { // Search keyword in title and body
                        array_push($results['Profiles'],$user);
                    }
                }
            }

            // Search in posts
            $results["Threads"] = array();
            foreach ($posts as $post) {
                foreach ($post as $key => $value) { 
                    if (str_contains($value,$keyword)) { // Search keyword in title and body
                        array_push($results["Threads"] ,$post);
                       
                    }
                }
            }

            // Search in comments
            $results["Comments"] = array();
            foreach ($comments as $comment) {
                foreach ($comment as $key => $value) {
                    if (str_contains($value,$keyword)) { // Search keyword in title and body
                        array_push($results['Comments'],$comment);
                    }
                }
            }
            $this->view($results);
        }
    }
?>