<?php


	class Notification_model extends CI_Model{
		private $notification_table = "notification";
		private $comment_table = "discussion";
		private $users_table = "users";

		public function create_notification($data){
			$this->db->insert($this->notification_table,$data);
		}
		// get all the notification you have and display it in notification section
		public function get_notification($user_id){
			// get all the post and notif and join comment table and user_table
			$this->db->join($this->users_table,$this->users_table.".user_id = ".$this->notification_table.".user_id");
			// $this->db->join($this->comment_table,$this->comment_table.".comment_id = ".$this->notification_table.".action_id");
			

			// use the session user_id to get all the notification
			$this->db->where($this->notification_table.".owner_id",$user_id);
			$query = $this->db->get($this->notification_table);
			if($query->num_rows() > 0 ){
				return $query->result_array();

			}
			else{
				return "";
			}
		}
		// para malaman kung ilan yung mga notification na di pa nababasa
		public function get_notification_count($user_id){
			$this->db->where("owner_id",$user_id);
			$this->db->where("read_status",0);
			$query = $this->db->get($this->notification_table);
			if($query->num_rows() > 0){
				return $query->num_rows();
			}else{
				return "";
			}
		}
		// para malaman na nabasa na yung mga notif
		public function read_notification($user_id,$data){
			$this->db->where("owner_id",$user_id);
			$this->db->where("read_status",0);
			return $this->db->update($this->notification_table,$data);
		}
		public function notification_delete($action_id){
			$this->db->where("action_id",$action_id);
			return$this->db->delete($this->notification_table);

		}
	}


?>