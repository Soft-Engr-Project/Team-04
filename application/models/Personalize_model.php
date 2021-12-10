<?php
    class Personalize_model extends CI_Model{
        private $users_table = "users";
        public function __construct(){
            $this->load->database();
        }
        public function update_user($data) {

            // Place all input values from the form in an array
         
            $this->db->where('user_id', $this->session->userdata('user_id'));
            return $this->db->update("users",$data);
          }

        function checkUserExist($username) {
            $this->db->select('*');
            $this->db->where('username', $username);
            $query = $this->db->get('users'); // Get username in database
            if ($query->num_rows() > 0) {
              return true;
            }
            return false; 
          }

        public function getUserInfo($id){
          $this->db->where('user_id', $id);
          $query = $this->db->get('users'); 
    
          return $query->row_array();
        
       }
    }
?>