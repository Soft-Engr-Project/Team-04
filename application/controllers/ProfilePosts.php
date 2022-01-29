<?php


    class ProfilePosts extends CI_Controller
    {
        private $data = array();
        public function index()
        {
            // APPPATH - ROOT FOLDER
            //THIS IF CHECK IF WE HAVE FOLDER PAGES IN THE VIEW AND IF IT HAS PAGES FOLDER THEN FIND A SPECIFIC
            // PHP FILE
            $this->data['posts'] = $this->post_model->get_posts();
            $this->data["title"]="Latest Post";
            $this->load->view("templates/header");
            $this->load->view("profiles/index",$this->data);
            $this->load->view("templates/footer");
        }

        public function view($slug=NULL)
        {
            // kukunin yung laman sa model
            $this->data["post"] = $this->post_model->get_posts($slug);
            // check kung walang laman;
            if(empty($this->data["post"])) {
                show_404();
            }
            $this->data["title"] = $this->data["post"]["title"];
            $this->load->view("templates/viewPostHeader");
            $this->load->view("profiles/view",$this->data);
            $this->load->view("templates/footer");
        }

        public function delete($id)
        {
            $user_id = $this->post_model->get_posts($id)["user_id"];
            $react_id = $this->input->post("react_id");
            if($this->session->userdata("user_id") != $user_id && $this->session->userdata("admin") != true) {
                redirect("pages/view");
            }

            $this->post_model->delete_reactions($react_id);
            $this->post_model->delete_post($id);
            $this->session->set_flashdata("post_delete","Delete a thread succesfully");
            redirect("profiles");
        }

        public function edit($id)
        {
            $user_id = $this->post_model->get_posts($id)["user_id"];

            if($this->session->userdata("user_id") != $user_id && $this->session->userdata("admin") != true) {
                redirect("pages");
            }
            $this->data["post"] = $this->post_model->get_posts($id);
            $this->data["categories"] = $this->categories_model->get_categories();
            $this->data["title"]="Edit Post";
            // $this->data["slug"] = $slug;
            if(empty($this->data["post"])) {
                show_404();
            }
            $this->data["title"] = $this->data["post"]["title"];
            $this->load->view("templates/viewPostHeader");
            $this->load->view("posts/edit",$this->data);
            $this->load->view("templates/footer");
        }

        public function update()
        { 
            $postID = $this->input->post("id");
            $postImage = $this->input->post("post_image");
            $image = $_FILES['userfile'];
            if($image && $image["tmp_name"]) {
            
                unlink("assets/images/posts/".$postImage);

                $config["upload_path"] = "./assets/images/posts";
                // kung anong file extension yung need
                $config["allowed_types"] = "gif|jpg|png";
                // 2048 = 2gb kung ano yung max file size 
                $config["max_size"] = "2048";
                // kung ano yung max width ng images
                $config["max_width"] = "2000";
                // kung ano yung max height ng images
                $config["max_height"] = "2000";

                // use for library upload yung $config
                $this->load->library('upload',$config);
                // check kung pede bang iupload
                if(! $this->upload->do_upload('userfile')) {
                    // dinidisplay nito yung error message
                    $errors= array("error" => $this->upload->display_errors());
                    // default
                    $postImage = "noimage.jpg";
                    // eto piniprint pag di alam yung error
                    // base sa na experience ko need yung picture ay di lalagpas ng 800x800
                    echo $this->upload->display_errors();
                    die();
                }
                else {
                    $data = array("upload_data" => $this->upload->data());
                    // var_dump($_FILES);
                    // use file name
                    $postImage = $_FILES['userfile']["name"];
                }
            }
        }
    }




?>