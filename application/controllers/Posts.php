<?php
    class Posts extends CI_Controller{

        private $data = array();

        public function index(){
            $this->post_model->get_posts();

        }
        public function view($slug=NULL){
            $this->data["post"] = $this->post_model->get_posts($slug);
            $this->load->view("templates/header.php");
            $this->load->view("posts/view",$this->data);
            $this->load->view("templates/footer");
        }

        public function create(){
            $this->data["title"] = "Create Post";
            // get all the categories
            $this->data["categories"] = $this->categories_model->get_categories();
            // test it using form_validation
            $this->form_validation->set_rules("title","Title","required");
            $this->form_validation->set_rules("body","Body","required");

            if($this->form_validation->run() == false){
                 $this->load->view("templates/header.php");
                 $this->load->view("posts/create.php",$this->data);
                 $this->load->view("templates/footer.php");
            }else{
                $this->post_model->create_post();
                $this->session->set_flashdata("post_create","Create post succesfully");
                redirect("pages");
            }

        }
        public function delete($id){
            $slug = $this->input->post("slug");
            $user_id = $this->post_model->get_posts($slug)["user_id"];
            if($this->session->userdata("user_id") != $user_id){
                redirect("pages");
            }

            $this->post_model->delete_post($id);
            $this->session->set_flashdata("post_delete","Delete a thread succesfully");
            redirect("pages");
        }
        public function edit($slug){
            $user_id = $this->post_model->get_posts($slug)["user_id"];

            if($this->session->userdata("user_id") != $user_id){
                redirect("pages");
            }
            $this->data["post"] = $this->post_model->get_posts($slug);
            $this->data["categories"] = $this->categories_model->get_categories();
            $this->data["title"]="Edit Post";
            $this->data["slug"] = $slug;
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
            $this->session->set_flashdata("post_update","Update post succesfully");
            redirect("pages");
        }
        
    }

?>