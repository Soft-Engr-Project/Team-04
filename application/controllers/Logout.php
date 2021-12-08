<?php

class Logout extends CI_Controller{
    public function goback(){
        $data["title"]="Logout";
        $this->load->view("template/header");
        $this->load->view("pages/logout");
        $this->load->view("template/footer");
    }
}



?>