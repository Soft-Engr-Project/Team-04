<?php

    class PersonalInfo extends CI_Controller{
        private $data;
        public function view(){
            $this->data["title"] = "My Information";
            $this->load->view("templates/header.php");
            $this->load->view("settings/personalinfo.php",$this->data);
            $this->load->view("templates/footer.php");
        }

    }


?>