<?php

    class Profiles extends CI_Controller
    {
        
        public function view($userID=NULL)
        {
            if ($userID == NULL) {
                $userID = $this->session->userdata("user_id");
            }
            //for header pic
            $userIdIn = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($userIdIn);
            $this->load->view("templates/header",$this->data);
            // kung sinong user yung viniew mo kung si session user o visit ka ng ibang profile
            $this->data["title"]="Profile";
            $this->data['posts'] = $this->profile_model->get_user_posts($userID);
            $this->data["react_count"] = $this->profile_model->get_all_reaction($userID);
            // $this->data["comment_count"] = $this->profile_model->get_all_comment($userID);
            $this->data["user"] = $this->user_model->get_user($userID);
            $this->load->view("profiles/profile",$this->data);
            $this->data["title"]="Personal Information";
            $this->load->view("profiles/information",$this->data);
            $this->data["title"]="My Threads";
            $this->data["user"] = $this->user_model->get_user($userID);
            $this->load->view("profiles/index",$this->data);
            $this->load->view("templates/footer");
        }

        public function upload_image()
        {
            $userID = $this->input->post("user_id");
            $id = $this->session->userdata('user_id');
            
            if ($userID != $id) {
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
            $this->load->library('upload', $config);
            // check kung pede bang iupload
            if(! $this->upload->do_upload('userfile')) {
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
            else {
                $userData = array("upload_data" => $this->upload->data());
                // var_dump($_FILES);
                // use file name
                $post_image = "assets/images/post/".$_FILES['userfile']["name"];
            }
            $userData = array(
                "user_cover_photo" => $post_image
            );
            $this->profile_model->update_db_user_info($id, $userData);
            redirect("profiles/view");
        }

        public function upload_profile()
        {
            $userID = $this->input->post("user_id");
            $id = $this->session->userdata('user_id');
            
            if ($userID != $id) {
                redirect("pages");
            }
            
            $config["upload_path"] = "./assets/images/post";
            if(!file_exists(FCPATH."assets/images/post")) {
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
            $this->load->library('upload', $config);
            // check kung pede bang iupload
            if(! $this->upload->do_upload('userfile')) {
                // dinidisplay nito yung error message
                $errors= array("error" => $this->upload->display_errors());
                // default
                $post_image = "";
                // eto piniprint pag di alam yung error
                // base sa na experience ko need yung picture ay di lalagpas ng 800x800
                // aayusin ko to 
                echo $this->upload->display_errors();
                // die();
                redirect("profiles/view");
                
            }
            else {
                $userData = array("upload_data" => $this->upload->data());
                // var_dump($_FILES);
                // use file name
                $post_image = "assets/images/post/".$_FILES['userfile']["name"];
            }
            $userData = array(
                "user_profile_photo" => $post_image
            );
            $this->profile_model->update_db_user_info($id, $userData);
            redirect("profiles/view");
        }
        // may aayusin pa dito sa delete
        public function delete_image()
        {
            $userID = $this->input->post("user_id");
            $id = $this->session->userdata('user_id');
                
            if ($userID != $id) {
                    redirect("pages");
            }

            $cover_photo = $this->input->post("cover_photo") ?? "";

            if(!empty($cover_photo)) {
                 unlink("assets/images/posts/".$cover_photo);
            }
            else {
                redirect("profiles/view");
            }
       
            $this->profile_model->delete_image($id);
            redirect("profiles/view");
        }

        public function delete_profile()
        {
            $userID = $this->input->post("user_id");
            $id = $this->session->userdata('user_id');
                
            if ($userID != $id) {
                    redirect("pages");
            }

            $profile_photo = $this->input->post("profile_photo") ?? "";

            if(!empty($profile_photo)) {
                 unlink("assets/images/posts/".$profile_photo);
            }
            else {
                redirect("profiles/view");
            }
            $this->profile_model->delete_profile($id);
            redirect("profiles/view");
        }
    
    }





?>