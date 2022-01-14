<?php

    class Profiles extends CI_Controller{
        
        public function view($user_id=NULL){
            if ($user_id == NULL) {
                $user_id = $this->session->userdata("user_id");
            }
            //for header pic
            $user_idIn = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($user_idIn);
            $this->load->view("templates/header.php",$this->data);

            $this->data["title"]="Profile";
            $this->data['posts'] = $this->profile_model->get_user_posts($user_id);
            $this->data["react_count"] = $this->profile_model->get_all_reaction($user_id);
            // $this->data["comment_count"] = $this->profile_model->get_all_comment($user_id);
            $this->load->view("templates/header.php");
            $this->data["user"] = $this->user_model->get_user($user_id);
            $this->load->view("profiles/profile.php",$this->data);
            $this->data["title"]="Personal Information";
            $this->load->view("profiles/information.php",$this->data);
            $this->data["title"]="My Threads";
            
            $this->load->view("profiles/index",$this->data);
            $this->load->view("templates/footer.php");
            
        }
        public function upload_image(){
           
                $user_id = $this->input->post("user_id");
                $id = $this->session->userdata('user_id');
                
                if ($user_id != $id) {
                    redirect("pages");
                }

                $config["upload_path"] = "./assets/images/post"; 
                if(!file_exists(FCPATH."assets/images/post")){
                    mkdir(FCPATH."assets/images/");
                    mkdir(FCPATH."assets/images/post");
                    
                }
                
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
                if(! $this->upload->do_upload('userfile')){
                    // dinidisplay nito yung error message
                    $errors= array("error" => $this->upload->display_errors());
                    // default
                    $post_image = "";
                    // eto piniprint pag di alam yung error
                    // base sa na experience ko need yung picture ay di lalagpas ng 800x800
                    echo $this->upload->display_errors();
                    redirect("profiles/view");
                    //die();
                }
                else{
                    $data = array("upload_data" => $this->upload->data());
                    // var_dump($_FILES);
                    // use file name
                    $post_image = "assets/images/post/".$_FILES['userfile']["name"];
                }
                $data = array(
                    "user_cover_photo" => $post_image
                );
                $this->profile_model->update_db_user_info($id,$data);
                redirect("profiles/view");
        }
         public function upload_profile(){

                $user_id = $this->input->post("user_id");
                $id = $this->session->userdata('user_id');
                
                if ($user_id != $id) {
                    redirect("pages");
                }
                
                 
                $config["upload_path"] = "./assets/images/post"; 
                if(!file_exists(FCPATH."assets/images/post")){
                      mkdir(FCPATH."assets/images/");
                    mkdir(FCPATH."assets/images/post");

                }
               
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
                if(! $this->upload->do_upload('userfile')){
                    // dinidisplay nito yung error message
                    $errors= array("error" => $this->upload->display_errors());
                    // default
                    $post_image = "";
                    // eto piniprint pag di alam yung error
                    // base sa na experience ko need yung picture ay di lalagpas ng 800x800
                    echo $this->upload->display_errors();
                    die();
                    redirect("profiles/view");
                    
                }
                else{
                    $data = array("upload_data" => $this->upload->data());
                    // var_dump($_FILES);
                    // use file name
                    $post_image = "assets/images/post/".$_FILES['userfile']["name"];
                }
                $data = array(
                    "user_profile_photo" => $post_image
                );
                $this->profile_model->update_db_user_info($id,$data);
                redirect("profiles/view");
        }
        // may aayusin pa dito sa delete
        public function delete_image(){
            $user_id = $this->input->post("user_id");
            $id = $this->session->userdata('user_id');
                
            if ($user_id != $id) {
                    redirect("pages");
            }

            $cover_photo = $this->input->post("cover_photo") ?? "";

            if(!empty($cover_photo)){
                 unlink("assets/images/posts/".$cover_photo);
            }
            else{
                redirect("profiles/view");
            }
            $id = $this->session->userdata('user_id');
            $this->profile_model->delete_image($id);
            redirect("profiles/view");
        }
         public function delete_profile(){
            $user_id = $this->input->post("user_id");
            $id = $this->session->userdata('user_id');
                
            if ($user_id != $id) {
                    redirect("pages");
            }

            $profile_photo = $this->input->post("profile_photo") ?? "";

            if(!empty($profile_photo)){
                 unlink("assets/images/posts/".$profile_photo);
            }
            else{
                redirect("profiles/view");
            }
            $this->profile_model->delete_profile($id);
            redirect("profiles/view");
        }
    
    }





?>