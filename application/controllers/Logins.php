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
            $this->Login->login_user();
            $this->load->view("templates/loginheader.php");
            $this->load->view("pages/view",$this->data);
            $this->load->view("templates/footer.php");     
        }
    }
}





?>