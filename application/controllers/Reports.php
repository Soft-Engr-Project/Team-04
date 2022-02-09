<?php

    class Reports extends CI_Controller
    {
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
                    
                    if($post =$this->subcommentmodel->getSpecificSubcomments($post_id)) {
                        $json_data = array("response" => "success","post" => $post);
                    }else {
                        $json_data = array("response" => "error","message" => "Failed"  , "type" => $type , "post_id" => $post_id);
                    }
                } 
                else {
                    $json_data = array("response" => "error","message" => "Failed"  , "type" => $type , "post_id" => $post_id);
                }
            echo json_encode($json_data);
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
                    $query = $this->post_model->get_posts($id)["reports_count"];
                    $reportsData = array(
                        'post_id'=> $id,
                        'complainant_id' => $this->session->userdata("user_id"),
                        'reason'=> $reason
                    );
                    $count = array("reports_count" => ++$query);
                    $this->reports_model->update_count($id, $count);
                }elseif ($type == "discussion") {
                    $query = $this->comments_model->get_specific_comment($id);
                    $reportsData = array(
                        'comment_id'=> $id,
                        'complainant_id' => $this->session->userdata("user_id"),
                        'reason'=> $reason
                    ); 
                }elseif ($type == "reply") {
                    // para sa reply sana
                    $query = $this->subcommentmodel->getSpecificSubcomments($id);
                    $reportsData = array(
                        'subcomment_id'=> $id,
                        'complainant_id' => $this->session->userdata("user_id"),
                        'reason'=> $reason
                    ); 
                } 

                // Insert report data
                $insert = $this->reports_model->create_report($reportsData);
               
                if($insert) {
                    $status = 1;
                    $msg .= 'Report successfully submitted.';
                    $json_data = array(
                        'response' => "success",
                        'message' => $msg,
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
                    'message' => "Failed to access",
                );
            }
        echo json_encode($json_data);
        }

        public function delete($id)
        {
            // check kung nag send ba ng request galing sa ajax
            //$id = $this->input->post('report_id');
            $this->reports_model->delete_report($id);
            redirect("admins/dashboard");
        }
            
    }

