<?php

	class Comments extends CI_Controller
    {
		public function create()
        {
            if($this->input->is_ajax_request()) {
                $this->form_validation->set_rules("comment","Comment","required");

                if($this->form_validation->run() == false) {
                    $json_data = array("response" => "error","message" => validation_errors()); 
                }
                else {
                    $id = $this->input->post("post_id");
                    $data["post"] = $this->post_model->get_posts($id);
                    $json = file_get_contents(FCPATH."reaction.json");
                    $reactID = $this->post_model->create_reaction_log($json);
                    $body = $this->input->post("comment");
                    $commentData = array(
                    "post_id" => $id,
                    "user_id" => $this->session->userdata("user_id"),
                    "react_id" => $reactID,
                    "content" => $body
                    );
                    
                    $commentCount = array(
                        "post_comment_count" => $data["post"]["post_comment_count"] + 1
                    );
                    $commentData = $this->security->xss_clean($commentData);

                    $this->comments_model->create($commentData);
                    // for notification
                    if($this->session->userdata("user_id") != $data["post"]["user_id"]) {
                        $notifData = array(
                            "action_id" => $data["post"]["id"],
                            "type_of_notif" => "comment",
                            "user_id" => $this->session->userdata("user_id"),
                            "owner_id" => $data["post"]["user_id"],
                            "post_id" => null,
                            "comment_id" => $this->Comments_model->getLastCommentInPost(),
                            "subcomment_id"=>null,
                            "read_status" => 0
                        );
                        $this->notification_model->create_notification($notifData);  
                    }
                    $this->comments_model->comment_counts($data["post"]["id"], $commentCount);
                    $json_data = array("response" => "success","message" => "Comment is successfully added");
                   
                }
            }
            else {
                $json_data = array("response" => "error","message" => "You need to have a request in ajax");
        
            }
            echo json_encode($json_data);
		}
        // fetch or get all data
        public function fetch()
        {
            if($this->input->is_ajax_request()){
                
                $postID = $this->input->post("post_id");
                
                $limit = $this->input->post("limit");
               
                
                $data = $this->comments_model->get_comments($postID,$limit);
                $numRow = $this->comments_model->checkIfHasComment($postID);
                $count = $this->comments_model-> get_comments_count($postID);
                $json_data = array("comments" => $data, "row" => $numRow, "count" => $count);
                echo json_encode($json_data);
            }
            else {
                echo "No direct script access allowed";
            }
        }
        public function fetchMore()
        {
            if($this->input->is_ajax_request()){
                
                $postID = $this->input->post("post_id");
                $commentId = $this->input->post("commentId");
                $limit = $this->input->post("limit");
               
           
                $data = $this->comments_model->getCommentfetch($commentId,$postID,$limit);
                $json_data = array("comments" => $data);
                echo json_encode($json_data);
            }
            else {
                echo "No direct script access allowed";
            }
        }
        public function realtimeCommentCount(){     
            if($this->input->is_ajax_request()){
                $postID = $this->input->post("post_id");
                $count = $this->comments_model->get_comments_count($postID);
                echo json_encode($count);
            }

        }

		public function reaction()
        {
            // get all vote
            $commentID =  $this->input->post("comment_id");
            $voteType = $this->input->post("type_of_vote");
            $data["comment"] = $this->comments_model->get_specific_comment($commentID);
            $reactID = $data["comment"]["react_id"];
            $json = file_get_contents(FCPATH."reaction.json");
            $json =  json_decode($json,true);
            
            $totalUpvote = $data["comment"]["upvote"];
            $totalDownvote = $data["comment"]["downvote"];
            $user = $this->session->userdata("user_id");

            if($voteType == "up_react") {
               
                $json = json_decode($this->comments_model->get_reactions($reactID)["react_log"],true);
                
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
                        "upvote" => $totalUpvote,
                        "downvote" => $totalDownvote
                    );
                    $this->notification_model->notification_delete(null,$commentID);
                    $this->post_model->delete_reaction($reactID,$reactData);
                    $this->comments_model->update_upvotes($commentID,$upvoteData);
                }
                else {
                    // check kung may react na siya sa downvote
                    if(in_array($user,$downvoteJson)) {
                        $index = array_search($user,$json["down_user_id"]); 
                        unset($json["down_user_id"][$index]);
                        $totalDownvote -= 1;
                        $this->notification_model->notification_delete(null,$commentID);
                    }
                    $json["up_user_id"][] = $user;
                    $json = json_encode($json);
              
                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalUpvote += 1;
                    $upvoteData = array(
                        "upvote" => $totalUpvote,
                        "downvote" => $totalDownvote
                    );

                    if($this->session->userdata("user_id") !=  $data["comment"]["user_id"]) {
                        $notifData = array(
                            "action_id" => $data["comment"]["post_id"],
                            "type_of_notif" => "react",
                            "user_id" => $this->session->userdata("user_id"),
                            "owner_id" => $data["comment"]["user_id"],
                            "post_id" => null,
                            "comment_id" => $data["comment"]["comment_id"],
                            "read_status" => 0
                        );
                        $this->notification_model->create_notification($notifData);  
                    }
                    $this->post_model->update_reaction($reactID,$reactData);
                    $this->comments_model->update_upvotes($commentID,$upvoteData);
                }
             }
             else {
                $json = json_decode($this->comments_model->get_reactions($reactID)["react_log"],true);
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
                        "upvote" => $totalUpvote,
                        "downvote" => $totalDownvote
                    );

                    $this->notification_model->notification_delete(null,$commentID);
                    $this->post_model->delete_reaction($reactID,$reactData);
                    $this->comments_model->update_upvotes($commentID,$downvoteData);
                }
                else{
                    $upvoteJson = $json["up_user_id"];
                    if(in_array($user,$upvoteJson)){
                        $index = array_search($user,$json["up_user_id"]);
                        unset($json["up_user_id"][$index]);
                        $totalUpvote -= 1;
                         $this->notification_model->notification_delete(null,$commentID);
                    }
                    $json["down_user_id"][] = $user;
                    $json = json_encode($json);

                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalDownvote += 1;
                    $downvoteData = array(
                        "upvote" => $totalUpvote,
                        "downvote" => $totalDownvote
                    );
                    if($this->session->userdata("user_id") != $data["comment"]["user_id"]) {
                    $notifData = array(
                            "action_id" =>  $data["comment"]["post_id"],
                            "type_of_notif" => "react",
                            "user_id" => $this->session->userdata("user_id"),
                            "owner_id" => $data["comment"]["user_id"],
                            "post_id" => null,
                            "comment_id" => $data["comment"]["comment_id"],
                            "read_status" => 0
                        );
                        $this->notification_model->create_notification($notifData);  
                    }
                    $this->comments_model->update_upvotes($commentID,$downvoteData);
                    $this->post_model->update_reaction($reactID,$reactData);
                }
             }
        }
	
        public function delete()
        {
            if($this->input->is_ajax_request()) {
                 $commentID = $this->input->post("comment_id");
            // get all the info about comment
            $data["comment"] = $this->comments_model->get_specific_comment($commentID);
            $reactID = $data["comment"]["react_id"];
            $postID = $data["comment"]["post_id"];
            $userID = $data["comment"]["user_id"];
            
            $data["post"] = $this->post_model->get_posts($postID);
            // check if you are the owner

                if($this->session->userdata("user_id") != $userID && $this->session->userdata("admin") != true) {
                    $json_data = array("response" => "error");
                }
                else {
                    $numComment = $data["post"]["post_comment_count"] - 1;
                    $commentCount = array(
                        "post_comment_count" => $numComment
                    );
                    $this->comments_model->delete_posts($commentID);
                    // delete also the notification
                    $this->notification_model->notification_delete(null,$commentID);
                    $this->post_model->delete_reactions($reactID);
                    $this->comments_model->comment_counts($postID,$commentCount);
                    $json_data = array("response" => "success");
                }
            }
            else {
                $json_data = array("response" => "error");
            }
            echo json_encode($json_data);
        }

        public function edit()
        {
            if($this->input->is_ajax_request()) {
                    $commentID = $this->input->post("comment_id");
                     // get all the info about comment
                    $data["comment"] = $this->comments_model->get_specific_comment($commentID);
                    $postID = $data["comment"]["post_id"];
                    $userID = $data["comment"]["user_id"];
                    // // check if you are the owner
                    if($this->session->userdata("user_id") != $userID && $this->session->userdata("admin") != true) {
                        $json_data = array("response" => "error","message"=>"Failed to access");
                    }
                    else {
                        $data["title"]="Edit Comment";
                        
                        if(empty($data["comment"])){
                            $json_data = array("response" => "error","message"=>"Failed to access");
                        }
                        else {
                            $json_data = array("response" => "success","message"=>$data["comment"]);
                        }
                    }
                }
            else {
                 $json_data = array("response" => "error","message"=>"Failed to access");
            }
             echo json_encode($json_data);
        }

        public function update()
        {
            if($this->input->is_ajax_request()) {
                $commentID = $this->input->post("edit_id");
                $content = $this->input->post("edit_comment");
            
                $this->form_validation->set_rules("edit_comment","Comment","required");
            
                 if($this->form_validation->run() == false) {
                        $json_data = array("response" => "error","message"=>validation_errors());
                 }
                 else {
                        $data = array(
                            "content" => $content
                        );
                        $this->comments_model->update_posts($commentID,$data);
                        $json_data = array("response" => "success","message"=>"Comment update successfully");
                    }
            }
            else {
                $json_data = array("response" => "error","message"=>"Failed to access");
            }
            echo json_encode($json_data);
        }

        // if you want to cancel the edit portion
        public function cancel_update() 
        {
            if($this->input->is_ajax_request()) {
                $json_data = array("response" => "success");
            }
            else {
                $json_data = array("response" => "error","message"=>"Failed to access");
            }
            echo json_encode($json_data);
        }
    }
