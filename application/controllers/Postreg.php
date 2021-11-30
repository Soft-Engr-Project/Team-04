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
                    // $this->data["title"] = "Wrong passcode";
                    // 
                    $this->form_validation->set_rules("passcode","Code","callback_checkCode");
                    if($this->form_validation->run() == false){
                        $this->load->view("templates/loginheader.php");
                        $this->load->view("pages/passcode",$this->data);
                        $this->load->view("templates/footer.php");
                    }
                    else{
                        redirect("postreg/passverify");
                    }
                   
                }
            }
            
        }
        // check the code if it has an error
        public function checkCode($code){
            if(is_null($this->server->get_code($code))){
                $this->form_validation->set_message('checkCode', 'Wrong passcode');
                return false;
            }
            else{
                return true;
            }
        }

        public function change_pass(){
            
            $email = $this->session->userdata('email');
            // echo $email;
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
                 $this->form_validation->set_message('checkEmailVerify', 'Email does not exist');
                 return false;
            } 
            else {
             $this->form_validation->set_message('checkEmailVerify', 'Change password link sent to your email');
                return true;
            }
        }  

        // USER REISTRATION
        public function register(){
            // Rules for forms
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
            }else{ // If the is forms filled up correctly
                // Code Generation
                $hash = md5(rand(0,1000));  // Generate hash value
                $code = substr(str_shuffle($hash), 0, 12); // Transform it to 12 key code
                $this->server->reg_user($code); //pass the code and update the database
                
                // Content to be passed on email format
                $username = $this->input->post('username');
                $email = $this->input->post('email');
                $data = array(
                'header' => 'Verify your account',
                'username' => $username,
                'body' => 'Verify',
                'button' => 'Verify',
                'link' => base_url()."postreg/verify/".$username."/".$code
                 );
                $this->send($email,'templates/email_format',$data); // Call email setup function
              
                // Load email sent html to notify the user
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/checkemail.php");
                $this->load->view("templates/footer.php"); 
            }
        }

        // EMAIL MESSAGE SETUP
        public function send($email,$template,$data){
           
            $to =  $email;  
            $subject = 'Email verification';
            $from = 'thinklikblog@gmail.com';           
            $password = env('PASSWORD'); // Get password from env file
            // Config setup
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465'; 
            $config['smtp_timeout'] = '60';
            $config['smtp_user'] = 'thinklikblog@gmail.com';    //Important
            $config['smtp_pass'] = $password;  //Important
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['mailtype'] = 'html'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not 

            // Setup email from autoload['helper']
            $this->email->initialize($config);
            $this->email->set_mailtype("html");
            $this->email->from($from);
            $this->email->to($to);
            $this->email->subject($subject);

            // Load the format and content of email
            $message=$this->email->message($this->load->view($template,$data,true));
  
            $status=$this->email->send(); // Send the email
         
        }
        
        // VERIFICATON OF DATA IN THE LINK
        public function verify(){
      
            //Get data from URL
            $username = $this->uri->segment(3); //get email from url
            $code = $this->uri->segment(4); //get code from url
            $data['verified'] = 1;

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