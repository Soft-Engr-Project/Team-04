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

        public function isAdmin($username,$password){
            $this->db->select('*');
            $this->db->where('username', $username); 
        
            $query = $this->db->get('admins');  
            if ($query->num_rows() > 0){ // Check if username is in admins
              $q = $query->row_array();
        
              if ($password == $q['password']){ // Note: Hash this sometime
                $passcode = random_int(0,999999);  // Generate random value
                $code['2FA_code'] = str_pad($passcode, 6, 0, STR_PAD_LEFT); // Adjust and store it as key-value for the database
                
                $this->db->update('admins', $code);  // Insert the 2FA code
                
                $q['2FA_code'] = $code['2FA_code']; // Pass the array to the array of admins info
                return $q; //Return admin info
              }
              else{
                echo "Username and password incorrect"; // Note: Fix the error printing
                redirect('/');
              }
            }
        
            // Username not found in admins
            else{
              return false;
            }
        
          }

        public function getUserInfo($id){
          $this->db->where('user_id', $id);
          $query = $this->db->get('users'); 
    
          return $query->row_array();
        
       }

       public function saveBgColor($user,$color){

          $this->db->select('*');
          $this->db->where('username', $user); 

          $query = $this->db->get('users'); 
          if ($query->num_rows() > 0){
            $this->db->where('username', $user); 
            $colors['bgColor'] = $color;
            $this->db->update('users', $colors);

            $newColor = array('bgColor'=>$color);
            $this->session->set_userdata($newColor);
           
          } 
       }

       // CHECK IF EMAIL EXISTS
      public function checkEmail($email) {
        $this->db->select('*');
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
          return true;
        }
        return false; 
      }


      // CHECK PASSWORD IN DATABASE
      public function checkotp($code){
        $this->db->select('*');
        $this->db->where('code', $code);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
          return true;
        }
        return false; 
      }
    }
?>