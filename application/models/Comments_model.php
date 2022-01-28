<?php

	class Comments_model extends CI_Model{
		private $comment_table = "discussion";
		private $users_table = "users";
		private $post_table = "posts";
		private $reactions_table = "reactions";
		
		public function create($data){
			return $this->db->insert($this->comment_table,$data);
		}
		public function get_comments($post_id,$limit = Null,$offset=Null){
			if(is_null($limit)){
				$this->db->order_by($this->comment_table.".comment_id ASC");
				$this->db->join($this->users_table,$this->users_table.".user_id = ".$this->comment_table.".user_id");
				$query = $this->db->get_where($this->comment_table,array("post_id" => $post_id));
				return $query->result_array();
			}
			else{
				$this->db->order_by($this->comment_table.".comment_created_at ASC");
				$this->db->limit($limit);
				$this->db->join($this->users_table,$this->users_table.".user_id = ".$this->comment_table.".user_id");
				$query = $this->db->get_where($this->comment_table,array("post_id" => $post_id));
				return $query->result_array();
			}
		}
		public function getCommentfetch($commentID,$postId,$limit = 3) {
			$this->db->order_by($this->comment_table.".comment_id ASC");
			$this->db->limit($limit);
			$this->db->join($this->users_table,$this->users_table.".user_id = ".$this->comment_table.".user_id");
			$this->db->where($this->comment_table.".post_id" ,$postId);
			$this->db->where("comment_id > ", $commentID);
			$query = $this->db->get($this->comment_table);
			return $query->result_array();	
		}
		public function checkIfHasComment($postId){
			$this->db->where("post_id" ,$postId);
			$query = $this->db->get($this->comment_table);
			
			return $query->num_rows();
		
		}
		public function get_specific_comment($comment_id){
			$this->db->join($this->users_table,$this->users_table.".user_id = ".$this->comment_table.".user_id");
				// connect to reaction table
			$this->db->join($this->reactions_table,$this->reactions_table.".react_id = ".$this->comment_table.".react_id");
				// connect to post table
			$query = $this->db->get_where($this->comment_table,array($this->comment_table.".comment_id" => $comment_id));
			return $query->row_array();
		}
		public function get_reactions($comment_id){
				
				$this->db->join($this->reactions_table,$this->reactions_table.".react_id = ".$this->comment_table.".react_id");
		        $this->db->where($this->comment_table.".react_id",$comment_id);
		        $query = $this->db->get($this->comment_table);
		        return $query->row_array();

		}
		// get the last comment 
		public function get_last_comment(){
			return $this->db->insert_id($this->post_table);
		}


		public function update_upvotes($id,$data){
		        $this->db->where("comment_id",$id);
        		return $this->db->update($this->comment_table,$data);
		}

		public function delete_posts($comment_id){
			$this->db->where("comment_id",$comment_id);
			return $this->db->delete($this->comment_table);
		}

		public function update_posts($comment_id,$data){
			$this->db->where("comment_id",$comment_id);
			return $this->db->update($this->comment_table,$data);
		}

		public function get_comments_count($postID){
			$this->db->where("id",$postID);
			$query = $this->db->get($this->post_table);
			return $query->row_array()["post_comment_count"];
		}
		public function getSubcommentsCount($commentID){
			
			$this->db->where("comment_id",$commentID);
			$query = $this->db->get($this->comment_table);
			return $query->row_array();
		}

		public function comment_counts($id,$data){
			$this->db->where("id",$id);
			return $this->db->update($this->post_table,$data);
		}
		public function subcomment_counts($commentId,$data){
			$this->db->where("comment_id",$commentId);
			return $this->db->update($this->comment_table,$data);
		}

		public function get_comments_content($post_id){
			$this->db->select('comment_id,post_id,content,discussion.created_at,users.user_id,users.username,users.user_profile_photo');
			$this->db->join($this->users_table,$this->users_table.".user_id = ".$this->comment_table.".user_id");
			$query = $this->db->get_where($this->comment_table,array("post_id" => $post_id));
			return $query->result_array();
		}


	}

?>