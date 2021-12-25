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
            
            if($page == "home"){
               $this->data["title"]=ucfirst($page);
               $this->load->view("templates/header.php");
               $this->data["categories"] = $this->categories_model->get_categories();
               $this->load->view("pages/".$page,$this->data);
               $this->data["title"] = " Latest Post";
               $this->data["posts"] = $this->post_model->get_posts();
               $this->load->view("posts/index.php",$this->data);
            }else{
                $this->data["title"]=ucfirst($page);
                $this->load->view("templates/header.php");
                $this->load->view("pages/".$page,$this->data);
            }
           
            $this->load->view("templates/footer.php");
        }

    }





?>