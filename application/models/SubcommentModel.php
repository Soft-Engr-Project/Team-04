<?php


	class SubcommentModel extends CI_Model{
		// CRUD
		// Create
		private $subcommentTable = "subcomment";
		private $commentTable = "discussion";
		private $usersTable = "users";
		private $reactionTable = "reactions";

		public function create($data){
			return $this->db->insert($this->subcommentTable,$data);
		}
		// eto para sa lahat ng subcomment na meron sa Comment
		public function getSpecificComments($commentId){
			// join comment table
			$this->db->join($this->commentTable,$this->commentTable.".comment_id = ".$this->subcommentTable.".comment_id");
			$this->db->join($this->usersTable,$this->usersTable.".user_id = ".$this->subcommentTable.".user_id");
			$this->db->where($this->subcommentTable.".comment_id",$commentId);
			$query = $this->db->get($this->subcommentTable);
			return $query->result_array();
		}
		// eto naman para sa specific comment
		public function getSpecificSubcomments($subcommentId) {
			$this->db->where("subcomment_id",$subcommentId);
			$query = $this->db->get($this->subcommentTable);
			return $query->row_array();
		}
		// delete subcommment
		public function deleteSubcomment($subcommentId) {
			$this->db->where("subcomment_id",$subcommentId);
			return $this->db->delete($this->subcommentTable);
		}
		// update subcomment
		public function updateSubcomment($subcommentId,$data){
			$this->db->where("subcomment_id",$subcommentId);
			return $this->db->update($this->subcommentTable,$data);
		}

		// pangkuha ng reaction log
		public function getReactions($subcommentId){
				
			$this->db->join($this->reactionTable,$this->reactionTable.".react_id = ".$this->subcommentTable.".react_id");
			$this->db->where($this->subcommentTable.".react_id",$subcommentId);
			$query = $this->db->get($this->subcommentTable);
			return $query->row_array();

		}
		
		public function updateUpvotes($subcommentId,$data){
			$this->db->where("subcomment_id",$subcommentId);
			return $this->db->update($this->subcommentTable,$data);
		}


	}



?>