<?php

class Pages extends CI_Controller{
    private $data = array();

    public function view($page = "home"){
        
        if(!file_exists(APPPATH."views/pages/".$page.".php")){
            show_404();
         }
        
         $this->data["title"]=ucfirst($page);
         $this->load->view("templates/header.php");
         $this->load->view("pages/".$page,$this->data);
         if($page = "home"){
             
         }
         $this->load->view("templates/footer.php");
    }

}



?>