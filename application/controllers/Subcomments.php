<?php

	
	class Subcomments extends CI_Controller{
		
		// CRUD
		// Create 
		// take note : php palang muna baka kase magulo pag nirekta ajax ko
        public function fetch()
        {
            if($this->input->is_ajax_request()){
                $subcommentID = $this->input->post("comments");
                $data = $this->subcommentmodel->getSpecificComments($subcommentID);
                echo json_encode($data);
            }
            else {
                echo "No direct script access allowed";
            }
        }
		public function create() {
            if($this->input->is_ajax_request()){
                
            $commentId = $this->input->post("commentId");
			$this->form_validation->set_rules("reply","Reply","required");
            
            $data["subcomment"] = $this->comments_model->get_specific_comment($commentId);
            $data["user"] = $this->user_model->get_user($this->session->userdata("user_id"));
            $data["comment"] = $this->comments_model->getSubcommentsCount($commentId);
            
			if($this->form_validation->run() == false) {
				// feel ko kaya di to gumagana kase naka ajax nako 
                $json_data = array("response" => "error","message" => validation_errors()); 
				 
			}
            if($this->form_validation->run()) { 
		
                    // $data["post"] = $this->post_model->get_posts($postId);
                    $jsonData = file_get_contents(FCPATH."reaction.json");
                    $reactId = $this->post_model->create_reaction_log($jsonData);
                    $body = $this->input->post("reply");
                    // gusto ko lang iistore yung data sa subcomment
                    $dataSubcomment = array(
                    	"comment_id" => $commentId,
                    	"user_id" => $this->session->userdata("user_id"),
                    	"react_id" => $reactId,
                    	"reply" => $body,
                    );
                    // $data = array(
                    // "post_id" => $id,
                    // "user_id" => $this->session->userdata("user_id"),
                    // "react_id" => $react_id,
                    // "content" => $body
                    // );
                   
                    $commentCount = $data["comment"]["subcomment_count"] + 1;
                    $subcommentCount = array(
                        "subcomment_count" => $commentCount

                    );
                    $dataSubcomment = $this->security->xss_clean($dataSubcomment);
                    $this->subcommentmodel->create($dataSubcomment);
                    // $this->comments_model->create($data);
                    // // for notification
                    if($this->session->userdata("user_id") !=  $data["comment"]["user_id"]){
                        $dataNotif = array(
                            "action_id" => $data["comment"]["comment_id"],
                            "type_of_notif" => "reply",
                            "user_id" => $this->session->userdata("user_id"),
                            "owner_id" => $data["comment"]["user_id"],
                            "post_id" => null,
                            "comment_id" => null,
                            "subcomment_id" =>$this->subcommentmodel->getLastComment(),
                            "read_status" => 0
                        );
                        $this->notification_model->create_notification($dataNotif);  
                    }
                    $this->comments_model->subcomment_counts($data["comment"]["comment_id"],$subcommentCount);
                    $json_data = array("response" => "success","message" => "Create comment successfully");          
                }
            }
            else {
                $json_data = array("response" => "error","message" => "Invalid to Access"); 
            }
            echo json_encode($json_data);
            
		}
        public function fetchSpecificComment() {
            if($this->input->is_ajax_request()){
                $commentId = $this->input->post("comments");
                $data = $this->comments_model->get_specific_comment($commentId);
                echo json_encode($data);
            }
            else {
                echo "No direct script access allowed";
            }
        }

        public function view($commentId = Null) {
            if($commentId == Null){
                show_404();
            }
            $userID = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($userID);

            $data["comments"] = $this->comments_model->get_specific_comment($commentId);
            $data["post"] = $this->post_model->get_posts($data["comments"]["post_id"]);
        
            $data["reported_id"] = $commentId;
            $data["commentId"] = $commentId;
            $data["subcomment"] = $this->subcommentmodel->getSpecificComments($commentId);
            $this->pagetemplate->show("subcomments/view", $data);

        }

        public function delete() {
           
            // get all the info about comment
            if($this->input->is_ajax_request()){
                $subcommentId = $this->input->post("subcomment_id");
                $data["subcomment"] = $this->subcommentmodel->getSpecificSubcomments($subcommentId);
                $reactID = $data["subcomment"]["react_id"];
                
                // $postID = $data["subcomment"]["post_id"];
                $userID = $data["subcomment"]["user_id"];
                $commentID = $data["subcomment"]["comment_id"];
                // $data["post"] = $this->post_model->get_posts($postID);
                // check if you are the owner

                    if($this->session->userdata("user_id") != $userID && $this->session->userdata("admin") != true) {
                        $json_data = array("response" => "error", "message" => validation_errors()); 
                    }
                    else {
                        $this->subcommentmodel->deleteSubcomment($subcommentId);
                        // delete also the notification
                        $this->notification_model->notification_delete(null,null,$subcommentId);
                        $this->post_model->delete_reactions($reactID);
                        $data["comment"] = $this->comments_model->getSubcommentsCount($commentID);
                        $commentCount = $data["comment"]["subcomment_count"] - 1;
                        $subcommentCount = array(
                            "subcomment_count" => $commentCount

                        );
                        $this->comments_model->subcomment_counts($data["comment"]["comment_id"],$subcommentCount);
                        // $this->comments_model->comment_counts($postID,$commentCount);
                        // $data = array("response" => "success");
                        $json_data = array("response" => "success", "message" => "Comment is deleted successfully"); 
                    }
                }
                else {
                    $json_data = array("response" => "error", "message" => "Invalid to Access"); 
                }
                echo json_encode($json_data);
        }

        public function edit() {
                    if($this->input->is_ajax_request()) {
                        $subcommentId = $this->input->post("subcomment_id");

                        // get all the info about comment
                        $data["subcomment"] = $this->subcommentmodel->getSpecificSubcomments($subcommentId);
                        // $commentID = $data["subcomment"]["comment_id"];
                        $userID = $data["subcomment"]["user_id"];
                        // // check if you are the owner
                        if($this->session->userdata("user_id") != $userID && $this->session->userdata("admin") != true) {
                            $json_data = array("response" => "error", "message"=>"Failed to access");
                        }
                        elseif(empty($data["subcomment"])){
                            $json_data = array("response" => "error", "message"=>"Failed to access");
                        }
                        else{
                            $json_data = array("response" => "success", "message"=> $data["subcomment"]);
                        }
                    } else {
                        $json_data = array("response" => "error", "message"=>"Failed to access");
                    }
                    echo json_encode($json_data);
        }

        public function update(){
                if($this->input->is_ajax_request()) {
                    $subcommentID = $this->input->post("editSubcommentId");
                    $content = $this->input->post("editSubcommentReply");
                    $this->form_validation->set_rules("editSubcommentReply","Reply","required");

                    if($this->form_validation->run() === False){
                        $json_data = array("response" => "error", "message" => validation_errors());
                    }
                    else {
                    $data = array(
                        "reply" => $content
                      );
                    $this->subcommentmodel->updateSubcomment($subcommentID,$data);
                    $json_data = array("response" => "success", "message"=>"Comment update successfully");
                    }
                
                }
                else {
                    $json_data = array("response" => "error", "message" => "Failed to access");
                }
                echo json_encode($json_data);
                
        }
        
        public function reaction()
        {
            // get all vote
            $subcommentID =  $this->input->post("subcommentId");
            $voteType = $this->input->post("type_of_vote");
            $data["subcomment"] = $this->subcommentmodel->getSpecificSubcomments($subcommentID);
            $data["comment"] = $this->comments_model->get_specific_comment($data["subcomment"]["comment_id"]);
            $reactID = $data["subcomment"]["react_id"];
            $json = file_get_contents(FCPATH."reaction.json");
            $json =  json_decode($json,true);
           
            $totalUpvote = $data["subcomment"]["sub_upvote"];
            $totalDownvote = $data["subcomment"]["sub_downvote"];
            $user = $this->session->userdata("user_id");
            $json = json_decode($this->subcommentmodel->getReactions($reactID)["react_log"],true);

            if($voteType == "up_react") {
               
                // pangcheck kung nagreact na sa upvote or downvote
                $upvoteJson = $json["up_user_id"];
                $downvoteJson = $json["down_user_id"];
                
                // check kung nag upvote na     
                if(in_array($user,$upvoteJson)) { 
                    $index = array_search($user,$json["up_user_id"]);
                    unset($json["up_user_id"][$index]);
                    $json = json_encode($json);

                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalUpvote -= 1;
                    $upvoteData = array(
                        "sub_upvote" => $totalUpvote,
                        "sub_downvote" => $totalDownvote
                    );
                    
                    $this->notification_model->notification_delete(null,null,$subcommentID);
                    $this->post_model->delete_reaction($reactID,$reactData);
                    $this->subcommentmodel->updateUpvotes($subcommentID,$upvoteData);
                }
                else {
                    // check kung may react na siya sa downvote
                    if(in_array($user,$downvoteJson)) {
                        $index = array_search($user,$json["down_user_id"]); 
                        unset($json["down_user_id"][$index]);
                        $totalDownvote -= 1;
                        
                        $this->notification_model->notification_delete(null,null,$subcommentID);
                    }
                    $json["up_user_id"][] = $user;
                    $json = json_encode($json);
              
                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalUpvote += 1;
                    $upvoteData = array(
                        "sub_upvote" => $totalUpvote,
                        "sub_downvote" => $totalDownvote
                    );
                    
                    if($this->session->userdata("user_id") !=  $data["subcomment"]["user_id"]){
                        $data = array(
                            "action_id" => $data["subcomment"]["comment_id"],
                            "type_of_notif" => "reply_react",
                            "user_id" => $this->session->userdata("user_id"),
                            "owner_id" => $data["comment"]["user_id"],
                            "post_id" => null,
                            "comment_id" => null,
                            "subcomment_id" =>$data["subcomment"]["subcomment_id"],
                            "read_status" => 0
                        );
                        $this->notification_model->create_notification($data);  
                    }
                    $this->post_model->update_reaction($reactID,$reactData);
                    $this->subcommentmodel->updateUpvotes($subcommentID,$upvoteData);
                }
             }
             else {
               
                $upvoteJson = $json["up_user_id"];
                $downvoteJson = $json["down_user_id"];

                // check kung nasa nag upvote na 
                if(in_array($user,$downvoteJson)) {
                    $index = array_search($user,$json["down_user_id"]);
                    unset($json["down_user_id"][$index]);
                    $json = json_encode($json);

                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalDownvote -= 1;
                    $downvoteData = array(
                        "sub_upvote" => $totalUpvote,
                        "sub_downvote" => $totalDownvote
                    );
                   
                    $this->notification_model->notification_delete(null,null,$subcommentID);
                   
                    $this->post_model->delete_reaction($reactID,$reactData);
                    $this->subcommentmodel->updateUpvotes($subcommentID,$downvoteData);
                }
                else{
                    $upvoteJson = $json["up_user_id"];
                    if(in_array($user,$upvoteJson)){
                        $index = array_search($user,$json["up_user_id"]);
                        unset($json["up_user_id"][$index]);
                        $totalUpvote -= 1;
            
                         $this->notification_model->notification_delete(null,null,$subcommentID);
                    }
                    $json["down_user_id"][] = $user;
                    $json = json_encode($json);

                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalDownvote += 1;
                    $downvoteData = array(
                        "sub_upvote" => $totalUpvote,
                        "sub_downvote" => $totalDownvote
                    );
                    if($this->session->userdata("user_id") !=  $data["subcomment"]["user_id"]){
                        $data = array(
                            "action_id" => $data["subcomment"]["comment_id"],
                            "type_of_notif" => "reply_react",
                            "user_id" => $this->session->userdata("user_id"),
                            "owner_id" => $data["comment"]["user_id"],
                            "post_id" => $data["comment"]["post_id"],
                            "read_status" => 0
                        );
                        $this->notification_model->create_notification($data);  
                    }
                    $this->post_model->update_reaction($reactID,$reactData);
                    $this->subcommentmodel->updateUpvotes($subcommentID,$downvoteData);
                }
             }
        }
        
	}


