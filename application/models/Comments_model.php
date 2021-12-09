<?php

	class Comments_model extends CI_Model{
		private $comment_table = "comments";
		private $post_table = "posts";
		public function create($data){
			return $this->db->insert($this->comment_table,$data);
		}
		public function get_comments($post_id){
			$query = $this->db->get_where($this->comment_table,array("post_id" => $post_id));
			return $query->result_array();
		}
		public function get_vote($id,$comment_id){
			$this->db->where("id",$comment_id);
			$query = $this->db->get_where($this->comment_table,array("post_id" => $id));
			return $query->row_array();
		}
		public function update_vote($id,$comment_id,$data){
		
			$this->db->where("post_id",$id);
			$this->db->where("id",$comment_id);
			return $this->db->update($this->comment_table,$data);
			
		}
	}

?>