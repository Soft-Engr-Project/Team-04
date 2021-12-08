<?php

class Logout extends CI_Controller{
    private $data;
    public function goback(){
        $this->data["title"]="Logout";
        $this->load->view("templates/header");
        $this->load->view("pages/logout.php",$this->data);
        $this->load->view("templates/footer");
    }
}



?>