<?php

class Server extends CI_Model{
  
// connect to the database
  public function __construct(){
        // load the database();
        $this->load->database();
  }

  // initializing variables
  private $username = "";
  private $email    = "";
  private $errors = array(); 

 
// REGISTER USER
  public function reg_user() {

    // receive all input values from the form
    echo 'hello';
    //$this->username = mysqli_real_escape_string($db, $this->input->post('username'));
    $data = array(
      'username'=> $this->input->post("username"),
      'firstname'=> $this->input->post("firstname"),
      'lastname'=> $this->input->post("lastname"),
      'birthdate'=> $this->input->post("birthdate"),
      'email' => $this->input->post("email"),
      'password' => $this->input->post("password_1"),
    );
    return $this->db->insert('users',$data);
  }


  function checkUserExist($username) {
    $this->db->select('*');
    $this->db->where('username', $username);
    $query = $this->db->get('users');
    if ($query->num_rows() > 0) {
      return true;
    }
    return false; 
  }


  function checkEmail($email) {
    $this->db->select('*');
    $this->db->where('email', $email);
    $query = $this->db->get('users');
    if ($query->num_rows() > 0) {
      return true;
    }
    return false; 
  }

  // LOGIN USER
  public function login_user() { 
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    
 
    $this->db->select('*');
    $this->db->where(
             array(
                'username' => $username,
                'password' => $password
             ));
    $query = $this->db->get('users');
    $result = $query->row();
    
      if ($query->num_rows() > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        redirect("pages/view");
      }
      else{
        // lagyan error
        redirect("/");
      }
  }
  
}

?>