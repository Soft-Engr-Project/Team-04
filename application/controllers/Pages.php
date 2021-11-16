<?php

    class Pages extends CI_Controller{
        private $data = array();
        public function view($page ='home'){
            // APPPATH - ROOT FOLDER
            //THIS IF CHECK IF WE HAVE FOLDER PAGES IN THE VIEW AND IF IT HAS PAGES FOLDER THEN FIND A SPECIFIC
            // PHP FILE
            if(!file_exists(APPPATH."views/pages/".$page.".php")){
               show_404();
            }
            $this->data["title"]=ucfirst($page);
            $this->load->view("templates/header.php");
            $this->load->view("pages/".$page,$this->data);
            if($page == "home"){
                $this->data["title"]="Create Post";
                $this->data['posts'] = $this->post_model->get_posts();
                $this->load->view("posts/createpostbutton",$this->data);
                $this->data["title"]="Latest Posts";
                $this->load->view("posts/index",$this->data);
            }
           
            $this->load->view("templates/footer.php");
        }

    }





?>