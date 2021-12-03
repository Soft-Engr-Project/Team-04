<?php
    class Posts extends CI_Controller{

        private $data = array();

        public function index(){
            $this->post_model->get_posts();

        }
        public function view($slug=NULL){
            // if it is not set then $id is Null
            $id = $this->input->post('id') ?? Null;
            $this->data["post"] = $this->post_model->get_posts($slug,$id);
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
                $data =array(
                        "title"=>$this->input->post("title"),
                        "body" =>$this->input->post("body"),
                        "slug" => url_title($this->input->post("title")),
                        "category_id"=> $this->input->post("category_id"),
                        "user_id" => $this->session->userdata("user_id")
                    );
                $this->post_model->create_post($data);
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
            $id = $this->input->post("id");
            $user_id = $this->post_model->get_posts($slug,$id)["user_id"];

            if($this->session->userdata("user_id") != $user_id){
                redirect("pages");
            }
            $this->data["post"] = $this->post_model->get_posts($slug,$id);
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
            $data=array(
            'title'=> $this->input->post('title'),
            'slug' => url_title($this->input->post('title')),
            'body' => $this->input->post('body'),
            'category_id'=> $this->input->post("category_id")
             );  
            $id = $this->input->post("id");
            $this->post_model->update_post($data,$id);
            $this->session->set_flashdata("post_update","Update post succesfully");
            redirect("pages");
        }
        
    }

?>