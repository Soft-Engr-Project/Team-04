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
    $this->username = mysqli_real_escape_string($db, $this->input->post('username'));
    $this->email = mysqli_real_escape_string($db, $this->input->post('email'));
    $password_1 = mysqli_real_escape_string($db, $this->input->post('password_1'));
    $password_2 = mysqli_real_escape_string($db, $this->input->post('password_2'));

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($this->username)) { array_push($errors, "Username is required"); }
    if (empty($this->email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure 
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$this->username' OR email='$this->email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    


    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
      $password = md5($password_1);//encrypt the password before saving in the database

      $query = "INSERT INTO users (username, email, password) 
            VALUES('$username', '$email', '$password')";
      mysqli_query($db, $query);
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: home');
    }
  }

  // LOGIN USER
  public function login_user() { 
    $this->username = mysqli_real_escape_string($db, $this->input->post('username'));
    $password = mysqli_real_escape_string($db, $this->input->post('password'));

    if (empty($this->username)) {
      array_push($errors, "Username is required");
    }
    if (empty($password)) {
      array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
      $password = md5($password);
      $query = "SELECT * FROM users WHERE username='$this->username' AND password='$password'";
      $results = mysqli_query($db, $query);
      if (mysqli_num_rows($results) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: home');
      }else {
        array_push($errors, "Wrong username/password combination");
      }
    }
  }
}

?>