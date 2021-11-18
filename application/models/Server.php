<?php
session_start();
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
      'email' => $this->input->post("email"),
      'password' => $this->input->post("password_1"),
    );
    return $this->db->insert('users',$data);

  
  }

  // LOGIN USER
  public function login_user() { 
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    
    $db = mysqli_connect('localhost', 'root', '', 'registration');

      
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    echo "<pre>";
    var_dump($query);
    echo "</pre>";
    $results = mysqli_query($db, $query);
      if (mysqli_num_rows($results) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: home');
      }
 
  }
}

?>