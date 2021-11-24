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
  public function reg_user($code) {

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
      'code' => $code,
      'verified' => "false"
    );
    return $this->db->insert('users',$data);
  }

  //update passcode to database
  public function passcode($email, $passcode) {
    $data = array(
      'passcode' => $passcode
    );
    $query = $this->db->where('email', $email);
    return $this->db->update('users', $data);
  }

  //get username
  public function get_user($email){
      $query = $this->db->get_where("users",array("email"=>$email));
      
      return $query->row_array()['username'];
    }



   //check if passcode matched
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

  public function change_pass($email) {
    $data = array(
      'password' => $this->input->post("password_1"),
    );
    $query = $this->db->where('email', $email);
    return $this->db->update('users', $data);
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

  //Update database to activate the account
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
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    
    $this->db->select('*');
    $this->db->where(
             array(
                'username' => $username,
                'password' => $password,
                'verified' => 'true'
             ));
    $query = $this->db->get('users');
    $result = $query->row();
    
      if ($query->num_rows() > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        redirect("pages/view");
      }
      else{
        redirect("/");
      }
  }
  
}

?>