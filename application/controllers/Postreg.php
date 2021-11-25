<?php
//
    class Postreg extends CI_Controller{
       
        private $data = array();
           public function login(){
            $this->form_validation->set_rules('username','Username','required');
            $this->form_validation->set_rules('password','Password','required');
            if($this->form_validation->run()===false){
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/login",$this->data);
                $this->load->view("templates/footer.php");     
            }else{
                $this->server->login_user();
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/view",$this->data);
                $this->load->view("templates/footer.php");     
            }
        }

        public function logout()
        {
            $this->session->unset_userdata(array('username','id'));
            $this->session->sess_destroy();
            redirect("/");
        }


        public function forgot_password(){

            $this->form_validation->set_rules('email','Email','required|callback_checkEmailVerify');
            if($this->form_validation->run()===false){
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/forgot_password",$this->data);
                $this->load->view("templates/footer.php");     
            }else{
                // Code Generation
                $passcode = random_int(0,999999);  // Generate hash value
                $passcode = str_pad($passcode, 6, 0, STR_PAD_LEFT);
                $lock_id = 0;
            
                // Email generation
                $email = $this->input->post('email'); //Get user email input
                $this->server->passcode($email, $passcode); //pass the code and update the database
                $user = $this->server->get_user($email);
                $to      = $email; // Send email to our user
                $subject = 'Change Password'; // Give the email a subject 
                $message = "
               
                    Account Password Reset:

                    $email,

                    Code: $passcode

                    Please Enter the 6 digit pin given above to proceed on changing password.
                
                "; // Our message above including the link
                                    
                $headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers

                mail($to, $subject, $message, $headers); // Send our email
                

                //Enter 6 digit pin

                $newdata = array('email'=>$email, 'lock_id'=>$lock_id);
                $this->session->set_userdata($newdata);


                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/passcode",$this->data);
                $this->load->view("templates/footer.php");


            }
        }

        public function passverify(){
            $email = $this->session->userdata('email');
            if($this->session->userdata('email') == NULL){ //if user forces to visit
                redirect("/");
            }
            else{
                $passcode = $this->input->post('passcode');
                //check if same passcode
                $query= $this->server->check_passcode($email, $passcode); 

                // If true, direct to change password
                if ($query){
                    $this->session->set_userdata(array('lock_id'=>1));
                    $this->load->view("templates/loginheader.php");
                    $this->load->view("pages/change_password");
                    $this->load->view("templates/footer.php"); 
                }
                else{
                    echo "Wrong passcode";
                    $this->load->view("templates/loginheader.php");
                    $this->load->view("pages/passcode",$this->data);
                    $this->load->view("templates/footer.php");
                }
            }
            
        }

        public function change_pass(){
            
            $email = $this->session->userdata('email');
            echo $email;
            if($this->session->userdata('email') == NULL){ //if user force to visit
                redirect("/");
            }
            else{
                //if user attempts to directly visit change pass, destroy session
                if($this->session->userdata('lock_id') != 1){
                    $this->session->sess_destroy();
                    redirect("/");
                }
                $this->form_validation->set_rules('password_1','Password','required');
                $this->form_validation->set_rules('password_2', 'Confirm Password', 'required|matches[password_1]');
                if($this->form_validation->run()===false){
                    $this->load->view("templates/loginheader.php");
                    $this->load->view("pages/change_password");
                    $this->load->view("templates/footer.php");       
                }
                else{
                    $query = $this->server->change_pass($email);
                        if ($query){
                        $this->load->view("templates/loginheader.php");
                        $this->load->view("pages/passwordverify");
                        $this->load->view("templates/footer.php"); 
                        $this->session->sess_destroy();
                    }
                }
            }
        }


        function checkEmailVerify($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('checkEmailVerify', 'Invalid email format');
                return false;
            }
            if ($this->server->checkEmail($email) == false) {
                 $this->form_validation->set_message('checkEmailVerify', 'Email Does not Exist');
                 return false;
            } 
            else {
             $this->form_validation->set_message('checkEmailVerify', 'Change password link sent to your email');
                return true;
            }
        }  




        public function register(){
            $this->form_validation->set_rules('username','Username','required|callback_checkUserName');
            $this->form_validation->set_rules('firstname','Firstname','required');
            $this->form_validation->set_rules('lastname','Lastname','required');
            $this->form_validation->set_rules('birthdate','Birthdate','required');
            $this->form_validation->set_rules('email','Email','required|callback_checkEmail');

            $this->form_validation->set_rules('password_1','Password','required');
            $this->form_validation->set_rules('password_2', 'Confirm Password', 'required|matches[password_1]');
            if($this->form_validation->run()===false){
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/signup",$this->data);
                $this->load->view("templates/footer.php");     
            }else{
                
                // Code Generation
                $hash = md5(rand(0,1000));  // Generate hash value
                $code = substr(str_shuffle($hash), 0, 12); // Transform it to 12 key code
                $this->server->reg_user($code); //pass the code and update the database
                
                // Email generation
                $email = $this->input->post('email'); //Get user email input
                $username = $this->input->post('username'); //Get user email input
                $name = $this->input->post('firstname'); //Get user name input
                $password = $this->input->post('password_1'); //Get user name input

                $to      = $email; // Send email to our user
                $subject = 'Signup | Verification'; // Give the email a subject 
                $message = "
               
                    Thank you for Registering.

                    Your Account:
                    Email: ".$email."
                    Password: ".$password."
                    Please click the link below to activate your account.
                    ".base_url()."postreg/verify/".$username."/".$code."
                
                "; // Our message above including the link
                                    
                $headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers

                mail($to, $subject, $message, $headers); // Send our email
                echo "Check your email";
  
               
            }
        }
        
        public function verify(){
      
            //Get data from URL
          
            $username = $this->uri->segment(3); //get email from url
            $code = $this->uri->segment(4); //get code from url
            $data['verified'] = 1;
            echo $username;
            echo $code;

            $query= $this->server->activate_acc($username, $code, $data); //check in the database
           
            // If true, inform the user in verify.php
            if ($query){
            $this->load->view("templates/loginheader.php");
            $this->load->view("pages/verify");
            $this->load->view("templates/footer.php");  
           
            }
            else{
                echo "Invalid URL";
            }
        }

        function checkUserName($username){
            if ($this->server->checkUserExist($username) == false) {
                 return true;
            } 
            else {
             $this->form_validation->set_message('checkUserName', 'Username already exists');
                return false;
            }
        }

        function checkEmail($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('checkEmail', 'Invalid email format');
                return false;
            } 
           
            if ($this->server->checkEmail($email) == false) {
                 return true;
            } 
            else {
             $this->form_validation->set_message('checkEmail', 'Email already exists');
                return false;
            }
        }       

    }

?>