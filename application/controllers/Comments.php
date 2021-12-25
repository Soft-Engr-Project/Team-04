<?php

	class Comments extends CI_Controller{
		private $data = array();
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->model('Comments_model');
	    }
		public function create(){
            if($this->input->is_ajax_request()){
                $this->form_validation->set_rules("comment","Comment","required");

                if($this->form_validation->run() == false){
                    $data = array("response" => "error","message" => validation_errors()); 
                  
                }
                else{
                    $id = $this->input->post("post_id");
                    $this->data["post"] = $this->post_model->get_posts($id);
                    $json_data = file_get_contents(FCPATH."reaction.json");
                    $react_id = $this->post_model->create_reaction_log($json_data);
                    $body = $this->input->post("comment");
                    $data = array(
                    "post_id" => $id,
                    "user_id" => $this->session->userdata("user_id"),
                    "react_id" => $react_id,
                    "content" => $body
                    );
                    $comment_count = $this->data["post"]["post_comment_count"] + 1;
                    $post_comment_count = array(
                        "post_comment_count" => $comment_count

                    );
                    $data = $this->security->xss_clean($data);

                    $this->comments_model->create($data);
                    $this->comments_model->comment_counts($this->data["post"]["id"],$post_comment_count);
                    $data = array("response" => "success","message" => "Comment is successfully added");
                   
                }
            }
            else{
                $data = array("response" => "error","message" => "You need to have a request in ajax"); 
        
            }
            echo json_encode($data);
		}
        // fetch or get all data
        public function fetch(){
            if($this->input->is_ajax_request()){
                $post_id = $this->input->post("post_id");
                $data = $this->comments_model->get_comments($post_id);
                echo json_encode($data);
            }else{
                echo "No direct script access allowed";
            }
        }

		public function reaction($id){
			// get all vote
			$comment_id =  $this->input->post("comment_id");
            $react_id = $this->input->post("react_id");
   	         $json_data = file_get_contents(FCPATH."reaction.json");
             $json =  json_decode($json_data,true);
             // user na nagrereact
             $get_post = $this->comments_model->get_specific_comment($comment_id);
             
             $total_upvote = $get_post["upvote"];
             $total_downvote = $get_post["downvote"];
             $user =  $this->session->userdata("user_id");
             $type_of_vote = $this->input->post("submit");

             if($type_of_vote == "up_react"){
               
                $json_data = json_decode($this->comments_model->get_reactions($react_id)["react_log"],true);
                
                $upvote_array = $json_data["up_user_id"];
                $downvote_array = $json_data["down_user_id"];

                // check kung nasa nag upvote na 
                if(in_array($user,$upvote_array)){ 
                    
                    $index = array_search($user,$json_data["up_user_id"]);
                    unset($json_data["up_user_id"][$index]);
                    $json_data = json_encode($json_data);    

                    
                    $data = array(
                        "react_log" => $json_data
                    );
                    $total_upvote -= 1;
                    $data_upvote = array(
                        "upvote" => $total_upvote,
                        "downvote" => $total_downvote
                    );
                     

                    $this->post_model->delete_reaction($react_id,$data);
                    $this->comments_model->update_upvotes($comment_id,$data_upvote);
                }
                else{
            
                    // check kung may react na siya sa downvote
                    if(in_array($user,$downvote_array)){
                        $index = array_search($user,$json_data["down_user_id"]);        
                        unset($json_data["down_user_id"][$index]);
                        $total_downvote -= 1;
                    }
                    $json_data["up_user_id"][] = $user;
                    $json_data = json_encode($json_data);    
              
                       
                    $data = array(
                        "react_log" => $json_data
                    );
                    $total_upvote += 1;
                    $data_upvote = array(
                        "upvote" => $total_upvote,
                        "downvote" => $total_downvote
                    );


                    $this->post_model->update_reaction($react_id,$data);
                    $this->comments_model->update_upvotes($comment_id,$data_upvote);

                }
             }
             else{
                
                $json_data = json_decode($this->comments_model->get_reactions($react_id)["react_log"],true);
                $upvote_array = $json_data["up_user_id"];
                $downvote_array = $json_data["down_user_id"];


                // check kung nasa nag upvote na 
                if(in_array($user,$downvote_array)){ 
                    $index = array_search($user,$json_data["down_user_id"]);
                    unset($json_data["down_user_id"][$index]);
                    $json_data = json_encode($json_data);    

                    $data = array(
                        "react_log" => $json_data
                    );
                    $total_downvote -= 1;
                    $data_downvote = array(
                        "upvote" => $total_upvote,
                        "downvote" => $total_downvote
                    );

                    $this->post_model->delete_reaction($react_id,$data);
                    $this->comments_model->update_upvotes($comment_id,$data_downvote);
                }
                else{
                    $upvote_array = $json_data["up_user_id"];
                    if(in_array($user,$upvote_array)){
                        $index = array_search($user,$json_data["up_user_id"]);
                        unset($json_data["up_user_id"][$index]);
                        $total_upvote -= 1;
                    }
                    $json_data["down_user_id"][] = $user;
                    $json_data = json_encode($json_data);

                    $data = array(
                        "react_log" => $json_data
                    );
                    $total_downvote += 1;
                    $data_downvote = array(
                        "upvote" => $total_upvote,
                        "downvote" => $total_downvote
                    );

                    $this->post_model->update_reaction($react_id,$data);
                    $this->comments_model->update_upvotes($comment_id,$data_downvote);
                }
             }
               redirect("posts/".$id);
          
		}
	
        // delete 
        public function delete(){
            if($this->input->is_ajax_request()){
                 $comment_id = $this->input->post("comment_id");
            // get all the info about comment
            $this->data["comment"] = $this->comments_model->get_specific_comment($comment_id);
            $react_id = $this->data["comment"]["react_id"];
            $post_id = $this->data["comment"]["post_id"];
            $user_id = $this->data["comment"]["user_id"];
            
            $this->data["post"] = $this->post_model->get_posts($post_id);
            // check if you are the owner

            
                if($this->session->userdata("user_id") != $user_id && $this->session->userdata("admin") != true){
                    $data = array("response" => "error");
                }else{
                    $comment_count = $this->data["post"]["post_comment_count"] - 1;
                    $post_comment_count = array(
                        "post_comment_count" => $comment_count
                    );
                    $this->comments_model->delete_posts($comment_id);
                    $this->post_model->delete_reactions($react_id);
                    $this->comments_model->comment_counts($post_id,$post_comment_count);
                    $data = array("response" => "success");
                }
            }else{
                $data = array("response" => "error");
            }
           
            echo json_encode($data);
        }

        public function edit(){
            $comment_id = $this->input->post("edit_id");
            
             // get all the info about comment
            $this->data["comment"] = $this->comments_model->get_specific_comment($comment_id);
            $post_id = $this->data["comment"]["post_id"];
            $user_id = $this->data["comment"]["user_id"];
            // // check if you are the owner
            if($this->session->userdata("user_id") != $user_id && $this->session->userdata("admin") != true){
                $data = array("response" => "error");
            }
            $data = array("response" => "success");
            echo json_encode($data);
            // $this->data["comment"] = $this->comments_model->get_specific_comment($comment_id);
            // $this->data["title"]="Edit Comment";
            // // $this->data["slug"] = $slug;
            // if(empty($this->data["comment"])){
            //     show_404();
            // }
            // $this->load->view("templates/viewPostHeader.php");
            // $this->load->view("comments/edit",$this->data);
            // $this->load->view("templates/footer.php");
        }
        public function update(){
            $comment_id = $this->input->post("comment_id");
            $content = $this->input->post("body");
            $post_id = $this->input->post("post_id");
            $this->form_validation->set_rules("body","Content","required");
            
            if($this->form_validation->run() == false){
                $this->data["title"]="Edit Comment";
                $this->data["comment"] = $this->comments_model->get_specific_comment($comment_id);
                $this->load->view("templates/viewPostHeader.php");
                $this->load->view("comments/edit",$this->data);
                $this->load->view("templates/footer.php");
            }else{
                $data = array(
                    "content" => $content
                );
                $this->comments_model->update_posts($comment_id,$data);
                redirect("posts/".$post_id);
            }
            
        }

    
    
    }

?>