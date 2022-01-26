<?php

class Login extends CI_Model{
  // CONNECT TO THE DATABASE
  public function __construct(){
        // load the database();
        
        $this->load->database();
  }

  // Check if the user is an admin or not
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
   // CHECK PASSCODE IN DATABASE
   public function check_passcode($email, $passcode){
    $this->db->select('*');
    $this->db->where('email', $email);
    $this->db->where('2FA_code', $passcode);
    $query = $this->db->get('admins');
    if ($query->num_rows() > 0) {

      $q = $query->row_array();
      $user_data = array(
        'user_id' => $q["id"],
        'username' => $q["username"],
        'email' => $q["email"],
        'success' => "You are now logged in",
        'admin' => true,
        'bgColor' => $q["bgColor"],
        'logged_in'=> true
      );
      
      $this->session->set_userdata($user_data);
      return true;
    }
  
    return false; 
  }


  // LOGIN USER
  public function login_user($username,$password) {

    // Check the database
    $this->db->select('*');
    $this->db->where('username', $username); 

    $query = $this->db->get('users');  
    if ($query->num_rows() > 0){ // Check if username is in users
    
      $q = $query->row_array();
        // Store values from query
        $result1 = $q['username'];
        $result2 = $q['password'];
        $result3 = $q['verified'];
        
        if($result3==="0"){ // Check if user is verified
          echo "Sorry your not verified";
          redirect('/');
        }
        else{ // User is verified
          if (password_verify($password, $result2)) { // Check if password matched
            // Set the session
            $user_data = array(
              'user_id' => $q["user_id"],
              'username' => $q["username"],
              'email' => $q["email"],
              'success' => "You are now logged in",
              'bgColor' => $q["bgColor"],
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