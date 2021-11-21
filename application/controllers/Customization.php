<?php

    class Customization extends CI_Controller{
        private $data;
        public function view(){
            $this->data["title"] = "Customization";
            $this->load->view("templates/header.php");
            $this->load->view("settings/customization.php",$this->data);
            $this->load->view("templates/footer.php");
        }
    }

?>