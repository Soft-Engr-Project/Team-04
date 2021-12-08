<?php

	class Comments extends CI_Controller{
		private $data = array();
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->model('Comments_model');
	    }
		public function create($id){
			// $slug = $this->input->post("slug");
			$this->form_validation->set_rules("comment","Comment","required");
			$this->data["post"] = $this->post_model->get_posts($id);
			if($this->form_validation->run() == false){
				$this->load->view("templates/header.php");
				$this->load->view("posts/view",$this->data);
				$this->load->view("templates/footer.php");
			}
			else{
				$body = $this->input->post("comment");
				$data = array(
					"post_id" => $id,
					"user_id"=> $this->session->userdata("user_id"),
					"content" => $body
				);
				$data = $this->security->xss_clean($data);
				$this->Comments_model->create($data);
				redirect("posts/".$id);
			}
		}

		public function reaction($id){
			// get all vote
			$type_of_vote = $this->input->post("submit");
			$comment_id = $this->input->post("id");
			$vote = 1 ;
			$get_vote = $this->Comments_model->get_vote($id,$comment_id);
			$upvote = (int)$get_vote["upvote"];
			$downvote = (int)$get_vote["downvote"];
			if($type_of_vote == "upvote"){
				$upvote += $vote;
			}else{
				$downvote += $vote;
			}
			$data = array(
				"upvote" => $upvote,
				"downvote" => $downvote
			);
			
			$this->Comments_model->update_vote($id,$comment_id,$data);
			redirect("posts/".$id);
		}
	}



?>