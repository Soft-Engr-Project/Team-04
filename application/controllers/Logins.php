<?php
class Logins extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Login');
        $this->load->model('User_model');
    }
	
    public function form()
    {
        $data["title"]="Login";

        $this->pagetemplate->showlogin("pages/login", $data);
    }
    
    public function login()
    {
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');
        // para mawala yung tag sa validation_error()
        $this->form_validation->set_error_delimiters('','');
        if($this->form_validation->run()===false) {
            $data["error"] =  validation_errors();
            $this->pagetemplate->showlogin("pages/login", $data); // Load body
        }else {
            // Get user login input
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Check first if it is an admin
            $query = $this->Login->isAdmin($username,$password);
            
            if($query !== false) {
                $email = $query['email'];
                $data['email'] = $email;
                
                 // Content to be passed on email format
                $emailData = array(
                    'header' => 'Account 2FA',
                    'user' => $username,
                    'passcode' => $query['2FA_code'],
                    'body' => 'Please enter the 6 digit pin given above to login.'
                     );
                $this->send($email, 'templates/ChangePass_Email', $emailData); // Call email setup function

                $newdata = array('email'=>$email);
                $this->session->set_userdata($newdata);
                
                $this->pagetemplate->showlogin("templates/2FAformat", $data);// Load body
                     
            }else {
                $data["error"] = $this->Login->login_user($username,$password); // Login validation 
                if($data["error"] == "Login Success"){
                    $isLog =array(
                        "isLogin" => 1
                    );
                    $this->User_model->isLogin($this->session->userdata("user_id"),$isLog);
                    redirect("pages/view");
                }
                $this->pagetemplate->showlogin("pages/login", $data); // Load body
            }
        }
    }
    // EMAIL MESSAGE SETUP
    public function send($email, $template, $emaildata){
       
        $to =  $email;
        $subject = 'Email verification';
        $from = 'thinklikblog@gmail.com';
        $password = env('PASSWORD'); //get password from env file

        // Config setup
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_timeout' => '60',
            'smtp_user' => 'thinklikblog@gmail.com',
            'smtp_pass' => $password,
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'mailtype' => 'html',
            'validation' => TRUE
        );

        // Setup email from autoload['helper']
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);

        // Load the format and content of email
        $message=$this->email->message($this->load->view($template, $emaildata, true));

        $status=$this->email->send(); // Send the email
    }

    public function codeVerify()
    {
        $email = $this->session->userdata('email');
        $data['email'] = $email;
        if($email == NULL) { //if user forces to visit
            redirect("/");
        }else {
            $this->form_validation->set_rules("passcode","Code","callback_checkCode");
            if($this->form_validation->run() != false) {
                redirect("admins/dashboard");
            }else {
                $this->pagetemplate->showlogin("templates/2FAformat", $data);
            }   
        }   
    }
    // CHECK CODE IF RIGHT
    public function checkCode($code)
    {
        $this->form_validation->set_message('checkCode', 'Incorrect verification code');
        $email = $this->session->userdata('email');
        $query = $this->Login->check_passcode($email, $code);  // Check if same passcode
        if ($query) {
            return true;
        }else {
            return false;
        }
    }
}





