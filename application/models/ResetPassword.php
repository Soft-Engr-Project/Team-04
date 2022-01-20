<?php

class ResetPassword extends CI_Model{
  
  // CONNECT TO THE DATABASE
  public function __construct(){
        // load the database();
        $this->load->database();
  }
  private $errors = array(); 

  // UPDATE PASSCODE IN DATABASE
  public function passcode($email, $passcode) {
    $data = array(
      'passcode' => $passcode
    );
    $query = $this->db->where('email', $email);
    return $this->db->update('users', $data);
  }

  // GET USERNAME
  public function get_user($email){
      $query = $this->db->get_where("users",array("email"=>$email));
      
      return $query->row_array()['username'];
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

  // CHECK PASSWORD IN DATABASE
  public function check_passcode($email, $passcode){
    $this->db->select('*');
    $this->db->where('email', $email);
    $this->db->where('passcode', $passcode);
    $query = $this->db->get('users');
    if ($query->num_rows() > 0) {
      return true;
    }
    return false; 
  }

  // get the code for checking 
  public function get_code($code){
    $query = $this->db->get_where("users",array("passcode" => $code));
     return $query->row();
  }

  // UPDATE PASSWORD IN DATABASE
  public function change_pass($email,$data) {
    // Place new password in array
    // $data = array(
    //   'password' => $this->input->post("password_1"),
    // );
    $query = $this->db->where('email', $email);
    return $this->db->update('users', $data); // Update the database
  }

  public function get_old_password($email)
  {
    $query = $this->db->get_where("users", array("email"=>$email));
    return $query->row_array()['password'];
  }
}

?>