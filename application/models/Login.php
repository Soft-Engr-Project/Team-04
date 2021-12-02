<?php

class Login extends CI_Model{
  // CONNECT TO THE DATABASE
  public function __construct(){
        // load the database();
        
        $this->load->database();
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
      
    
      if($result3==="0"){ // Check if user is verified
        echo "Sorry your not verified";
        redirect('/');
      }
      else{ // User is verified
        if ($password == $result2) { // Check if password matched
          // Set the session
          $user_data = array(
            'user_id' => $q["userID"],
            'username' => $q["username"],
            'email' => $q["email"],
            'success' => "You are now logged in",
            'logged_in'=> true
          );
          $this->session->set_userdata($user_data);
          // $_SESSION['username'] = $username;
          // $_SESSION['success'] = "You are now logged in";
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