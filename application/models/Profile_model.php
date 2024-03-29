<?php

	class Profile_model extends CI_Model{
		private $post_table = "posts";
	    private $categories_table = "categories"; 
	    private $users_table = "users";
	    private $reactions_table = "reactions";
	    private $comment_table = "discussion";
    
		public function get_user_posts($user_id){
			$this->db->order_by($this->post_table.".id","DESC");
             $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
             $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->post_table.".user_id");
             $this->db->where($this->post_table.".user_id",$user_id);
			$query = $this->db->get($this->post_table);
			return $query->result_array();
		}

		public function get_all_reaction($user_id){
			$this->db->select("SUM(upvote)+SUM(downvote)");
			$this->db->where("user_id",$user_id);
			$post_query = $this->db->get($this->post_table);
			return $post_query->result_array()[0]["SUM(upvote)+SUM(downvote)"];
		}

		public function get_all_comment($post_id){
			$this->db->where("post_id",$post_id);
			$comment_query = $this->db->get($this->comment_table);
			return $comment_query->result_array();
		}

		public function update_db_user_info($id, $data) {
	       $this->db->where('user_id', $id);
	       return $this->db->update($this->users_table,$data);
   		} 

   		public function delete_image($id,$cover_photo = ""){
            $this->db->where('user_id', $id);
	        return $this->db->update($this->users_table,array("user_cover_photo" => $cover_photo));
   		} 

   		public function delete_profile($id,$profile_photo = ""){
            $this->db->where('user_id', $id);
	        return $this->db->update($this->users_table,array("user_profile_photo" => $profile_photo));
   		}
		
		public function get_usernames(){
			$this->db->select('user_id,username,user_profile_photo');
			$query = $this->db->get('users');
			return $query->result_array();
		}

	}



?>