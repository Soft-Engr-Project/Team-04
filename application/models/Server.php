<?php

class Server extends CI_Model{
  
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

  // UPDATE PASSWORD IN DATABASE
  public function change_pass($email) {
    // Place new password in array
    $data = array(
      'password' => $this->input->post("password_1"),
    );
    $query = $this->db->where('email', $email);
    return $this->db->update('users', $data); // Update the database
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
      return $this->db->update('users', $data);
    }
  }


  // LOGIN USER
  public function login_user() {
    // Get user input 
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    // Check the database
    $this->db->select('*');
    $this->db->where('username', $username); 
    $query = $this->db->get('users');

    if ($query->num_rows() > 0){ // Check if username is correct
      $q = $query->row_array();

      // Store values from query
      $result1= $q['username'];
      $result2 = $q['password'];
      $result3  = $q['verified'];
      
    
      if($result3=='false'){ // Check if user is verified
        echo "Sorry your not verified";
        redirect('/');
      }
      else{ // User is verified
        if ($password == $result2) { // Check if password matched
          // Set the session
          $_SESSION['username'] = $username;
          $_SESSION['success'] = "You are now logged in";
          redirect("pages/view");
        }
        else{ // Incorrect password
          echo "Username and password incorrect";
          redirect('/');
        } 
      }
    }
    else {  // Incorrect username
      echo "Username incorrect";
      redirect('/');
    }
  }
  
}

?>