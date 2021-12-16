<?php
class Logins extends CI_Controller{
	private $data = array();
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Login');

    }
	
    public function form(){
        $data["title"]="Login";
        $this->load->view("templates/loginheader.php");
        $this->load->view("pages/login.php",$data);
        $this->load->view("templates/footer.php");
    }
    
    public function login(){
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');
        if($this->form_validation->run()===false){
            $this->load->view("templates/loginheader.php");
            $this->load->view("pages/login",$this->data);
            $this->load->view("templates/footer.php");     
        }
        else{
            // Get user login input
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Check first if it is an admin
            $query = $this->Login->isAdmin($username,$password);
            
            if($query !== false){ 
                $email = $query['email'];
                $this->data['email'] = $email;
                
                 // Content to be passed on email format
                $email_data = array(
                    'header' => 'Account 2FA',
                    'user' => $username,
                    'passcode' => $query['2FA_code'],
                    'body' => 'Please enter the 6 digit pin given above to login.'
                     );
                $this->send($email,'templates/ChangePass_Email',$email_data); // Call email setup function

                $newdata = array('email'=>$email);
                $this->session->set_userdata($newdata);
                

                $this->load->view("templates/loginheader.php");
                $this->load->view("templates/2FAformat",$this->data);
                $this->load->view("templates/footer.php");
            }
            else{
                $this->Login->login_user($username,$password); // Login validation
                $this->load->view("templates/loginheader.php");
                $this->load->view("pages/view",$this->data);
                $this->load->view("templates/footer.php");     

            }
           

        }
    }

    
    // EMAIL MESSAGE SETUP
    public function send($email,$template,$data){
       
        $to =  $email;  
        $subject = 'Email verification';
        $from = 'thinklikblog@gmail.com';           
        $password = env('PASSWORD'); //get password from env file

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

    public function codeVerify(){
        $email = $this->session->userdata('email');
        $this->data['email'] = $email;
        if($email == NULL){ //if user forces to visit
            redirect("/");
        }
        else{
          
            $this->form_validation->set_rules("passcode","Code","callback_checkCode");
            if($this->form_validation->run() != false){

                redirect("pages/view"); // Log in the user
            }
            else{
                $this->load->view("templates/loginheader.php");
                $this->load->view("templates/2FAformat",$this->data);
                $this->load->view("templates/footer.php");
            }

               
            }
        
        
    }
    // CHECK CODE IF RIGHT
    public function checkCode($code){
        $this->form_validation->set_message('checkCode', 'Incorrect verification code');
        $email = $this->session->userdata('email');
        $query = $this->Login->check_passcode($email, $code);  // Check if same passcode
        if ($query){
            return true; 
        }
        else{
            return false;
        }
    }

}





?>