<?php

	
	class Subcomments extends CI_Controller{
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('SubcommentModel');
            $this->load->model('User_model');
            $this->load->model("Post_model");
            $this->load->model('Comments_model');
        }

		// CRUD
		// Create 
		// take note : php palang muna baka kase magulo pag nirekta ajax ko
		function create() {
			$commentId = $this->input->post("comment_id");
			$this->form_validation->set_rules("reply","Reply","required");
            
            $this->data["subcomment"] = $this->SubcommentModel->getSpecificComments($commentId);
            $this->data["user"] = $this->User_model->get_user($this->session->userdata("user_id"));
            $this->data["comment"] = $this->Comments_model->getSubcommentsCount($commentId);
         
			if($this->form_validation->run() == false) {
				// feel ko kaya di to gumagana kase naka ajax nako 
                $this->data["commentId"] = $commentId;
                $this->load->view("templates/header.php");
                $this->load->view("subcomments/view.php",$this->data);
                $this->load->view("templates/footer.php");
				 
			}
            if($this->form_validation->run()) { 
		
                    // $this->data["post"] = $this->Post_model->get_posts($postId);
                    $jsonData = file_get_contents(FCPATH."reaction.json");
                    $reactId = $this->Post_model->create_reaction_log($jsonData);
                    $body = $this->input->post("reply");
                    // gusto ko lang iistore yung data sa subcomment
                    $data = array(
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
                   
                    $commentCount = $this->data["comment"]["subcomment_count"] + 1;
                    $subcommentCount = array(
                        "subcomment_count" => $commentCount

                    );
                    $data = $this->security->xss_clean($data);
                    $this->SubcommentModel->create($data);
                    // $this->comments_model->create($data);
                    // // for notification
                    // if($this->session->userdata("user_id") !=  $this->data["post"]["user_id"]){
                    //     $data = array(
                    //         "action_id" => $this->comments_model->get_last_comment(),
                    //         "type_of_notif" => "comment",
                    //         "user_id" => $this->session->userdata("user_id"),
                    //         "owner_id" => $this->data["post"]["user_id"],
                    //         "post_id" => $this->data["post"]["id"],
                    //         "read_status" => 0
                    //     );
                    //     $this->notification_model->create_notification($data);  
                    // }
                    $this->Comments_model->subcomment_counts($this->data["comment"]["comment_id"],$subcommentCount);
                    redirect("subcomments/view/".$commentId);            
            }

		}
        function view($commentId = Null) {
            if($commentId == Null){
                show_404();
            }
            $this->data["commentId"] = $commentId;
            $this->data["subcomment"] = $this->SubcommentModel->getSpecificComments($commentId);
            $this->data["user"] = $this->User_model->get_user($this->session->userdata("user_id"));

            $this->load->view("templates/header.php");
            $this->load->view("subcomments/view",$this->data);
            $this->load->view("templates/footer.php");

        }

        function delete($subcommentId) {
           
            // get all the info about comment
            
            $this->data["subcomment"] = $this->SubcommentModel->getSpecificSubcomments($subcommentId);
            $reactID = $this->data["subcomment"]["react_id"];
            
            // $postID = $this->data["subcomment"]["post_id"];
            $userID = $this->data["subcomment"]["user_id"];
            $commentID = $this->data["subcomment"]["comment_id"];
            // $this->data["post"] = $this->Post_model->get_posts($postID);
            // check if you are the owner

                if($this->session->userdata("user_id") != $userID && $this->session->userdata("admin") != true) {
                    redirect("subcomments/view/".$commentID);
                }
                else {
                    // $numComment = $this->data["post"]["post_comment_count"] - 1;
                    // $commentCount = array(
                    //     "post_comment_count" => $numComment
                    // );
                    $this->SubcommentModel->deleteSubcomment($subcommentId);
                    // delete also the notification
                    // $this->notification_model->notification_delete($commentID);
                    $this->Post_model->delete_reactions($reactID);
                    $this->data["comment"] = $this->Comments_model->getSubcommentsCount($commentID);
                    $commentCount = $this->data["comment"]["subcomment_count"] - 1;
                    $subcommentCount = array(
                        "subcomment_count" => $commentCount

                    );
                    $this->Comments_model->subcomment_counts($this->data["comment"]["comment_id"],$subcommentCount);
                    // $this->comments_model->comment_counts($postID,$commentCount);
                    // $data = array("response" => "success");
                    redirect("subcomments/view/".$commentID);
                }
        }

        function edit($subcommentId) {
                    $commentID = $this->input->post("comment_id");
                     // get all the info about comment
                    $this->data["subcomment"] = $this->SubcommentModel->getSpecificSubcomments($subcommentId);
                    $commentID = $this->data["subcomment"]["comment_id"];
                    $userID = $this->data["subcomment"]["user_id"];
                    // // check if you are the owner
                    if($this->session->userdata("user_id") != $userID && $this->session->userdata("admin") != true) {
                        // $data = array("response" => "error","message"=>"Failed to access");
                        redirect("subcomments/view/".$commentID);
                    }
                    if(empty($this->data["subcomment"])){
                        show_404();
                    }

                    $this->data["title"] = "Edit Post";
                    $this->load->view("templates/header.php");
                    $this->load->view("subcomments/edit",$this->data);
                    $this->load->view("templates/footer.php");
                
                    // else {
                    //     $this->data["title"]="Edit Comment";
                        
                    //     if(empty($this->data["comment"])){
                    //         $data = array("response" => "error","message"=>"Failed to access");
                    //     }
                    //     else {
                    //         $data = array("response" => "success","message"=>$this->data["comment"]);
                    //     }
                    // }
        }

        function update(){
                $subcommentId = $this->input->post("subcomment");
                $commentID = $this->input->post("comment_id");
                $content = $this->input->post("body");
            
                $this->form_validation->set_rules("body","Reply","required");
            
                 if($this->form_validation->run() == false) {
                        // $data = array("response" => "error","message"=>validation_errors());
                        $this->data["title"] = "Edit Post";
                        $this->data["subcomment"] = $this->SubcommentModel->getSpecificSubcomments($subcommentId);
                        $this->load->view("templates/header.php");
                        $this->load->view("subcomments/edit.php",$this->data);
                        $this->load->view("templates/footer.php");
                        
                 }
                 else {
                        $data = array(
                            "reply" => $content
                        );
                        $this->SubcommentModel->updateSubcomment($subcommentId,$data);
                        // $data = array("response" => "success","message"=>"Comment update successfully");
                        redirect("subcomments/view/".$commentID);
                }
        }
        public function reaction()
        {
            // get all vote
            $subcommentID =  $this->input->post("subcomment_id");
            $voteType = $this->input->post("type_of_vote");
            $this->data["subcomment"] = $this->SubcommentModel->getSpecificSubcomments($subcommentID);
            $reactID = $this->data["subcomment"]["react_id"];
            $json = file_get_contents(FCPATH."reaction.json");
            $json =  json_decode($json,true);
           
            $totalUpvote = $this->data["subcomment"]["sub_upvote"];
            $totalDownvote = $this->data["subcomment"]["sub_downvote"];
            $user = $this->session->userdata("user_id");
            $json = json_decode($this->SubcommentModel->getReactions($reactID)["react_log"],true);

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
                    // wag muna to wala pang ajax 
                    // $this->notification_model->notification_delete($commentID);
                    $this->post_model->delete_reaction($reactID,$reactData);
                    $this->SubcommentModel->updateUpvotes($subcommentID,$upvoteData);
                }
                else {
                    // check kung may react na siya sa downvote
                    if(in_array($user,$downvoteJson)) {
                        $index = array_search($user,$json["down_user_id"]); 
                        unset($json["down_user_id"][$index]);
                        $totalDownvote -= 1;
                        // wag muna to kase wala pang ajax
                        // $this->notification_model->notification_delete($commentID);
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
                    // wag muna to kase wala pang ajax

                    // if($this->session->userdata("user_id") !=  $this->data["comment"]["user_id"]) {
                    //     $notifData = array(
                    //         "action_id" =>  $commentID,
                    //         "type_of_notif" => "comment",
                    //         "user_id" => $this->session->userdata("user_id"),
                    //         "owner_id" => $this->data["comment"]["user_id"],
                    //         "post_id" => $this->data["comment"]["post_id"],
                    //         "read_status" => 0
                    //     );
                    //     $this->notification_model->create_notification($notifData);  
                    // }
                    $this->post_model->update_reaction($reactID,$reactData);
                    $this->SubcommentModel->updateUpvotes($subcommentID,$upvoteData);
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
                    // wag muna to kase wala pa tayong ajax
                    // $this->notification_model->notification_delete($commentID);
                   
                    $this->post_model->delete_reaction($reactID,$reactData);
                    $this->SubcommentModel->updateUpvotes($subcommentID,$downvoteData);
                }
                else{
                    $upvoteJson = $json["up_user_id"];
                    if(in_array($user,$upvoteJson)){
                        $index = array_search($user,$json["up_user_id"]);
                        unset($json["up_user_id"][$index]);
                        $totalUpvote -= 1;
                         // wag muna to kase wala pa tayong ajax
                        //  $this->notification_model->notification_delete($commentID);
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
                     // wag muna to kase wala pa tayong ajax
                    // if($this->session->userdata("user_id") != $this->data["comment"]["user_id"]) {
                    // $notifData = array(
                    //         "action_id" =>  $commentID,
                    //         "type_of_notif" => "comment",
                    //         "user_id" => $this->session->userdata("user_id"),
                    //         "owner_id" => $this->data["comment"]["user_id"],
                    //         "post_id" => $this->data["comment"]["post_id"],
                    //         "read_status" => 0
                    //     );
                    //     $this->notification_model->create_notification($notifData);  
                    // }
                    $this->post_model->update_reaction($reactID,$reactData);
                    $this->SubcommentModel->updateUpvotes($subcommentID,$downvoteData);
                }
             }
             redirect("subcomments/view/".$this->data["subcomment"]["comment_id"]);
        }
	}


?>