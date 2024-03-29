<?php
class Signup extends CI_Controller
{
    public function __construct()
    {
            parent::__construct();
            if ($this->session->userdata("admin") || $this->session->userdata("logged_in")) {
                redirect("/");
            }
    }

    public function form()
    {
        $data["title"]="Signup";
        $this->load->view("templates/loginheader.php");
        $this->load->view("pages/signup.php",$data);
        $this->load->view("templates/footer.php");
    }

    public function navigate()
    {
        // ipapasok dito para  ipasok sa model
        redirect("logins/form");
    }

    // USER REISTRATION
    public function register()
    {
        // Rules for forms
        $this->form_validation->set_rules('username','Username','required|max_length[28]|callback_checkUserName');
        $this->form_validation->set_rules('firstname','Firstname','required');
        $this->form_validation->set_rules('lastname','Lastname','required');
        $this->form_validation->set_rules('birthdate','Birthdate','required|callback_checkBirthdate');
        $this->form_validation->set_rules('email','Email','required|callback_checkEmail');
        $this->form_validation->set_rules('password_1','Password','required|min_length[8]|max_length[25]|callback_check_strong_password');
      
        $this->form_validation->set_rules('password_2', 'Confirm Password', 'required|matches[password_1]');
        $this->form_validation->set_error_delimiters('','');
        if($this->form_validation->run()===false) {
            $data["error"] =  validation_errors();
            $this->pagetemplate->showlogin("pages/signup");
            // $this->load->view("templates/loginheader");
            // $this->load->view("pages/signup");
            // $this->load->view("templates/footer");
        }else { // If the is forms filled up correctly
            // Get form input
            $password = $this->input->post("password_1");
            $email = $this->input->post("email");
            $username = $this->input->post("username");

            $hashedPass = password_hash($password, PASSWORD_DEFAULT); // hash the password

            // Code Generation fo email verification
            $code = random_int(100000,999999);  // Generate 6 digit value
            $bgColor = "rgba(255, 255, 255, 1)";
            // Place all input values from the form in an array
            $userData = array(
                'username'=> $username,
                'firstname'=> $this->input->post("firstname"),
                'lastname'=> $this->input->post("lastname"),
                'birthdate'=> $this->input->post("birthdate"),
                'email' => $email,
                'password' => $hashedPass,
                'code' => $code,
                'bgColor' => $bgColor,
                'verified' => 0
              );
            $this->registration->insert_user($userData); // Pass the data and update the database
            
            // Content to be passed on email format
            $emailData = array(
            'header' => 'Verify your account',
            'username' => $username,
            'body' => 'Verify',
            'button' => 'Verify',
            'link' => base_url()."Signup/verify/".$username."/".$code
            );
            $this->send($email, 'templates/email_format', $emailData); // Call email setup function
          
            // Load email sent html to notify the user
            $this->pagetemplate->showlogin("pages/checkemail");
            // $this->load->view("templates/loginheader");
            // $this->load->view("pages/checkemail");
            // $this->load->view("templates/footer");
        }
    }
   

    public function checkUserName($username)
    {
        if ($this->registration->checkUserExist($username) == false) {
             return true;
        }else {
         $this->form_validation->set_message('checkUserName', 'Username already exists');
            return false;
        }
    }

    public function checkEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->form_validation->set_message('checkEmail', 'Invalid email format');
            return false;
        } 
       
        if ($this->registration->checkEmail($email) == false) {
             return true;
        }else {
         $this->form_validation->set_message('checkEmail', 'Email already exists');
            return false;
        }
    }

    public function checkBirthdate($birthdate)
    {
        $this->form_validation->set_message('checkBirthdate', 'User must be 13 and above to create an account');
        $dob = new DateTime($birthdate);
        $now = new DateTime();
        $difference = $now->diff($dob);
        $age = $difference->y;
        if($age<13) {
            return false;
        }
        return true;
    }

    // EMAIL MESSAGE SETUP
    public function send($email, $template, $emailData)
    {
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
        $message=$this->email->message($this->load->view($template, $emailData, true));

        $status=$this->email->send(); // Send the email
     
    }

     // VERIFICATON OF DATA IN THE LINK
    public function verify(){
    
        //Get data from URL
        $username = $this->uri->segment(3); //get email from url
        $code = $this->uri->segment(4); //get code from url
        $data['verified'] = 1;

        $query= $this->registration->activate_acc($username, $code, $data); //check in the database
        
        // If true, inform the user in verify.php
        if ($query){
        $this->pagetemplate->showlogin("pages/verify");
        
        }else {
            echo "Invalid URL";
        }
    }

    public function check_strong_password($password){
        $this->form_validation->set_message('check_strong_password', 'The password field must be contains at least one digit, one capital and small letter.');
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-z]#', $password)  && preg_match('#[A-Z]#', $password)) {
            return TRUE;
        }
        return FALSE;
    }

}


