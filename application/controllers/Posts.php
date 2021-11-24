<?php
//
    class Posts extends CI_Controller{
        public function index(){
            // APPPATH - ROOT FOLDER
            //THIS IF CHECK IF WE HAVE FOLDER PAGES IN THE VIEW AND IF IT HAS PAGES FOLDER THEN FIND A SPECIFIC
            // PHP FILE
            $data['posts'] = $this->post_model->get_posts();
            $data["title"]="Latest Post";
            $this->load->view("templates/header.php");
            $this->load->view("posts/index",$data);
            $this->load->view("templates/footer.php");
        }
        public function view($slug=NULL){
            // kukunin yung laman sa model
            $data["post"] = $this->post_model->get_posts($slug);
            // check kung walang laman;
            if(empty($data["post"])){
                show_404();
            }
            $data["title"] = $data["post"]["title"];
            $this->load->view("templates/viewPostHeader.php");
            $this->load->view("posts/view",$data);
            $this->load->view("templates/footer.php");
        }
        public function create(){
            $data["title"]="Create Post";
            $data["categories"] = $this->post_model->get_categories();
            // setting rules
            $this->form_validation->set_rules('title','Title','required');
            $this->form_validation->set_rules('body','Body','required');

            //  pag walaa pang sinusubmit
            if($this->form_validation->run()===false){
                $this->load->view("templates/header.php");
                $this->load->view("posts/create",$data);
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
            $data["post"] = $this->post_model->get_posts($slug);
            $data["title"]="Edit Post";
            $data["categories"] = $this->post_model->get_categories();
            if(empty($data["post"])){
                show_404();
            }
            $data["title"] = $data["post"]["title"];
            $this->load->view("templates/viewPostHeader.php");
            $this->load->view("posts/edit",$data);
            $this->load->view("templates/footer.php");
            
        }
        public function update(){
            $this->post_model->update_post();
            redirect("pages/view");
        }
    }

?>