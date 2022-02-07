<?php

class Registration extends CI_Model{
  
  // CONNECT TO THE DATABASE
  public function __construct(){
        // load the database();
        $this->load->database();
  }
  private $errors = array(); 
  
  // REGISTER USER
  public function insert_user($user_data) {
    $this->db->insert('users',$user_data); // Insert the data in the database
  }

  // CHECK USERNAME IN THE DATABASE
  public function checkUserExist($username) {
    $this->db->select('*');
    $this->db->where('username', $username);
    $query = $this->db->get('users'); // Get username in database
    if ($query->num_rows() > 0) {
      return true;
    }
    return false; 
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

  // UPDATE ACTIVE STATUS OF USER
  public function activate_acc($username,$code,$data){
    $this->db->select('*');
    $this->db->where('username', $username);    
    $this->db->where('code', $code);  
    $query = $this->db->get('users');
   
    if ($query->num_rows() > 0) {
      $this->db->where('username', $username);    
      $this->db->where('code', $code);    
      return $this->db->update('users', $data);
    }
  }
}

?>