<?php
class Signup extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Registration');

    }
    private $data = array();
    public function form(){
        $data["title"]="Signup";
        $this->load->view("templates/loginheader.php");
        $this->load->view("pages/signup.php",$data);
        $this->load->view("templates/footer.php");
    }
    public function navigate(){

        // ipapasok dito para  ipasok sa model
        redirect("logins/form");
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
            $this->Registration->reg_user($code); //pass the code and update the database
            
            // Content to be passed on email format
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $data = array(
            'header' => 'Verify your account',
            'username' => $username,
            'body' => 'Verify',
            'button' => 'Verify',
            'link' => base_url()."Signup/verify/".$username."/".$code
             );
            $this->send($email,'templates/email_format',$data); // Call email setup function
          
            // Load email sent html to notify the user
            $this->load->view("templates/loginheader.php");
            $this->load->view("pages/checkemail.php");
            $this->load->view("templates/footer.php"); 
        }
    }

    function checkUserName($username){
        if ($this->Registration->checkUserExist($username) == false) {
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
       
        if ($this->Registration->checkEmail($email) == false) {
             return true;
        } 
        else {
         $this->form_validation->set_message('checkEmail', 'Email already exists');
            return false;
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

     // VERIFICATON OF DATA IN THE LINK
        public function verify(){
      
            //Get data from URL
            $username = $this->uri->segment(3); //get email from url
            $code = $this->uri->segment(4); //get code from url
            $data['verified'] = 1;

            $query= $this->Registration->activate_acc($username, $code, $data); //check in the database
           
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




}


?>