<?php
class Signup extends CI_Controller{
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
}


?>