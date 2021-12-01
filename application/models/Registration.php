<?php

class Registration extends CI_Model{
  
  // CONNECT TO THE DATABASE
  public function __construct(){
        // load the database();
        $this->load->database();
  }
  private $errors = array(); 
  // REGISTER USER
  public function reg_user($code) {

    // Place all input values from the form in an array
    $data = array(
      'username'=> $this->input->post("username"),
      'firstname'=> $this->input->post("firstname"),
      'lastname'=> $this->input->post("lastname"),
      'birthdate'=> $this->input->post("birthdate"),
      'email' => $this->input->post("email"),
      'password' => $this->input->post("password_1"),
      'code' => $code,
      'verified' => 0
    );
    return $this->db->insert('users',$data); // Insert the data
  }

  // CHECK USERNAME IN THE DATABASE
  function checkUserExist($username) {
    $this->db->select('*');
    $this->db->where('username', $username);
    $query = $this->db->get('users'); // Get username in database
    if ($query->num_rows() > 0) {
      return true;
    }
    return false; 
  }

  // CHECK IF EMAIL EXISTS
  function checkEmail($email) {
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