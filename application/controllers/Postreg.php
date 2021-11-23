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
            $data['verified'] = 'true';
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