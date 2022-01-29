<?php

    class Reports extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('Reports_model');
            $this->load->model('SubcommentModel');
        }

        public function view($id=NULL)
        {
            $userID = $this->session->userdata("user_id");

            // Load data to be passed
            $data["user"] = $this->user_model->get_user($userID);
            $data["categories"] = $this->categories_model->get_categories();
            $data["report"]  = $this->Reports_model->get_reports();

            // Show reports
            $this->load->view("templates/header",$this->data);
            $this->load->view("settings/report_logs",$this->data);
            $this->load->view("templates/footer",$this->data);
        }

        // CHECKS IF THE REPORTED CONTENT EXISTS
        public function check_post()
        {
            if($this->input->is_ajax_request()) {
                $post_id = $this->input->post("content_id"); // kukunin yung post id na nireport 
                $type = $this->input->post("type");
                
                if($type == "thread") {
                    if($post = $this->post_model->get_posts($post_id)) {
                        $json_data = array("response" => "success","post" => $post);
                    }else {
                        $json_data = array("response" => "error","message" => "Failed" );
                    }
                    
                }
                elseif ($type == "discussion") {
                    if($post =$this->comments_model->get_specific_comment($post_id)) {
                        $json_data = array("response" => "success","post" => $post);
                    }else {
                        $json_data = array("response" => "error","message" => "Failed"  , "type" => $type , "post_id" => $post_id);
                    }
                    
                }
                elseif ($type == "reply") {
                    // para sa reply sana
                    
                    if($post =$this->SubcommentModel->getSpecificSubcomments($post_id)) {
                        $json_data = array("response" => "success","post" => $post);
                    }else {
                        $json_data = array("response" => "error","message" => "Failed"  , "type" => $type , "post_id" => $post_id);
                    }
                } 
                else {
                    $json_data = array("response" => "error","message" => "Failed"  , "type" => $type , "post_id" => $post_id);
                }
            echo json_encode($data);
            }   
        }

        public function submit_reports()
        {
            // check kung nag send ba ng request galing sa ajax
            if($this->input->is_ajax_request()) {
                $msg = '';
                // Get user's input
                $id = $this->input->post('content_id');
                $type = $this->input->post('report_type');
                $reason = $this->input->post('reason');


                if ($type == 'thread') {
                    $query = $this->post_model->get_posts($id);
                }else {
                    $query = $this->comments_model->get_specific_comment($id);
                  
                }
            
                // Prepare report status
                $data = array(
                    'content_id'=> $id,
                    'type'    => $type,
                    'complainant_id'        => $this->session->userdata("user_id"),
                    'reason'    => $reason
                );
                
                // Insert report data
                $insert = $this->Reports_model->create_report($data);
       
                if($insert) {
                    $status = 1;
                    $msg .= 'Report successfully submitted.';
                    $json_data = array(
                        'response' => "success",
                        'message' => $msg 
                    );  
                }else {
                    $msg .= 'Some problem occurred, please try again.';
                    $json_data = array(
                        'response' => "error",
                        'message' => $msg 
                    );
                }              
            }else {
                $json_data = array(
                    'response' => "error",
                    'message' => "Failed to access" 
                );
            }
        echo json_encode($json_data);
        }
            
    }

?>