<?php
class Logins extends CI_Controller{
    public function form(){
        $data["title"]="Login";
        $this->load->view("templates/loginheader.php");
        $this->load->view("pages/login.php",$data);
        $this->load->view("templates/footer.php");
    }
}





?>