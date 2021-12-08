<?php
    class Personalize_model extends CI_Model{
        private $users_table = "users";
        public function __construct(){
            $this->load->database();
        }
        public function update_user() {

            // Place all input values from the form in an array
            $data = array(
              'username'=> $this->input->post("username"),
              'firstname'=> $this->input->post("firstname"),
              'lastname'=> $this->input->post("lastname"),
              'birthdate'=> $this->input->post("birthdate"),
              'password' => $this->input->post("password_1"),
            );
            $this->db->where('userID', $this->session->userdata('user_id'));
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
    }
?>