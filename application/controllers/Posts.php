<?php
//
    class Posts extends CI_Controller{
        private $data = array();
        public function index(){
            // APPPATH - ROOT FOLDER
            //THIS IF CHECK IF WE HAVE FOLDER PAGES IN THE VIEW AND IF IT HAS PAGES FOLDER THEN FIND A SPECIFIC
            // PHP FILE
            $this->data['posts'] = $this->post_model->get_posts();
            $this->data["title"]="Latest Post";
            $this->load->view("templates/header.php");
            $this->load->view("posts/index",$this->data);
            $this->load->view("templates/footer.php");
        }
        public function view($slug=NULL){
            // kukunin yung laman sa model
            $this->data["post"] = $this->post_model->get_posts($slug);
            // check kung walang laman;
            if(empty($this->data["post"])){
                show_404();
            }
            $this->data["title"] = $this->data["post"]["title"];
            $this->load->view("templates/viewPostHeader.php");
            $this->load->view("posts/view",$this->data);
            $this->load->view("templates/footer.php");
        }
        public function create(){
            $this->data["title"]="Create Post";
            $this->data["categories"] = $this->post_model->get_categories();
            // setting rules
            $this->form_validation->set_rules('title','Title','required');
            $this->form_validation->set_rules('body','Body','required');

            //  pag walaa pang sinusubmit
            if($this->form_validation->run()===false){
                $this->load->view("templates/header.php");
                $this->load->view("posts/create",$this->data);
                $this->load->view("templates/footer.php");     
            }else{
                $this->post_model->create_post();
                redirect("pages/view");
            }
        }
        public function delete($idNum){
            // delete certain post
            $this->post_model->delete_post($idNum);
            redirect("pages/view");
    
        }
        public function edit($slug){
            $this->data["post"] = $this->post_model->get_posts($slug);
            $this->data["title"]="Edit Post";
            $this->data["categories"] = $this->post_model->get_categories();
            if(empty($this->data["post"])){
                show_404();
            }
            $this->data["title"] = $this->data["post"]["title"];
            $this->load->view("templates/viewPostHeader.php");
            $this->load->view("posts/edit",$this->data);
            $this->load->view("templates/footer.php");
            
        }
        public function update(){
            $this->post_model->update_post();
            redirect("pages/view");
        }
    }

?>