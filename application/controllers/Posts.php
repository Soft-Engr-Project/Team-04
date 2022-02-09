<?php
    class Posts extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata("logged_in") != true) {
                show_404();
            }
        }

        public function index()
        {
            $this->post_model->get_posts();
        }

        // get filter
        public function post_filter()
        {
            
            $post = $_GET['category'];
            $by = $_GET['keyword'];
            $data["categories"] = $this->categories_model->get_categories();
            $data["posts"]=  $this->post_model->get_posts_for_filter($post, $by);
            echo json_encode($data);
                    
        }

        // get the top user post 
        public function top_post()
        {
            $data["posts"] = $this->post_model->get_posts_high_react();
        }

        public function view($id=NULL, $commentID=NULL)
        {
            //for header pic
            $userID = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($userID);
            
            $data["post"] = $this->post_model->get_posts($id);
            $data["comments"] = $this->comments_model->get_comments($id);
            $data["reported_id"] = $commentID;

            $this->pagetemplate->show("posts/view", $data, "posts/view_scripts");
        }

        public function create()
        {
            //for header pic
            $userID = $this->session->userdata("user_id");
            $data["user"] = $this->user_model->get_user($userID);

            $data["title"] = "Create Post";
            // get all the categories
            $data["categories"] = $this->categories_model->get_categories();

            // test it using form_validation
            $this->form_validation->set_rules("title","Title","required|min_length[5]");
            $this->form_validation->set_rules("body","Body","required");

            if($this->form_validation->run() == false) {
                $this->pagetemplate->show("posts/create", $data);
            }else {
                $json = file_get_contents(FCPATH."reaction.json");
                $reactID = $this->post_model->create_reaction_log($json);

                // Upload a image
                $config["upload_path"] = "./assets/images/post";
                // kung walang post folder mag automatic make
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
                    $errors = array("error" => $this->upload->display_errors());
                    // default
                    $postImage = "";
                    // eto piniprint pag di alam yung error
                    // base sa na experience ko need yung picture ay di lalagpas ng 800x800
                    echo $this->upload->display_errors();
                    // die();
                }else {
                    $postData = array("upload_data" => $this->upload->data());
                    // var_dump($_FILES);
                    // use file name
                    $postImage = "assets/images/post/".$_FILES['userfile']["name"];
                    // var_dump($_FILES['userfile']);
                    // var_dump($data);
                    // die();
                }

                $categoryID = $this->input->post("category_id");
                $postData = array(
                    "category_id"=> $categoryID,
                    "user_id" => $this->session->userdata("user_id"),
                    "react_id" => $reactID,
                    "title"=>$this->input->post("title"),
                    "body" =>$this->input->post("body"),
                    "slug" => url_title($this->input->post("title")),
                    "post_image" => $postImage
            
                );

                // Loop through the categories to update the value of count
                foreach ($data["categories"] as $category) {
                    if ($category["category_id"] == $categoryID) {
                        $categoryData["category_post_count"] = ++$category["category_post_count"];
                    }
                }
                
                $this->categories_model->category_count($categoryID, $categoryData);
                $this->post_model->create_post($postData);
                $this->session->set_flashdata("post_create","Create post succesfully");
                redirect("pages");
            }
        }

        public function delete($id)
        {
            $categoryID = $this->input->post("category");
            $userID = $this->post_model->get_posts($id)["user_id"];
            $reactID = $this->input->post("react_id");
            if($this->session->userdata("user_id") != $userID && $this->session->userdata("admin") != true) {
                redirect("pages");
            }
            
            // get category of specific post
            $data["categories"] = $this->categories_model->get_categories($categoryID);
            $categoryData = array(
                    "category_post_count" => --$data["categories"]["category_post_count"]
            );
            $this->categories_model->category_count($categoryID,$categoryData);
            $this->post_model->delete_reactions($reactID);
            $this->post_model->delete_post($id);
            $this->session->set_flashdata("post_delete","Delete a thread succesfully");
            redirect("pages");
        }

        public function edit($id)
        {
            $userID = $this->post_model->get_posts($id)["user_id"];
            $data["user"] = $this->user_model->get_user($userID);
            $data["post"] = $this->post_model->get_posts($id);
            $data["categories"] = $this->categories_model->get_categories();
            $data["title"]="Edit Post";
            // $data["slug"] = $slug;
            if(empty($data["post"])) {
                show_404();
            }
            $this->pagetemplate->show("posts/edit", $data);
        }
        
        public function update()
        {
            $categoryID = $this->input->post("category_id");
            $postID = $this->input->post("id");
            // get the post for checking if the category is change
            $data["post"] = $this->post_model->get_posts($postID);
            // get category of specific post 
            $data["categories"] = $this->categories_model->get_categories();
            $data["title"]="Edit Post";
      
            $this->form_validation->set_rules("title","Title","required|min_length[10]");
            $this->form_validation->set_rules("body","Body","required");
            
            if ($this->form_validation->run() == false) {
                $this->pagetemplate->show("posts/edit", $data);
            }else {
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
                        //die();
                    }else {
                        $postData = array("upload_data" => $this->upload->data());
                        // var_dump($_FILES);
                        // use file name
                        $postImage = $_FILES['userfile']["name"];
                    }
                }
        
                $postData=array(
                'title'=> $this->input->post('title'),
                'slug' => url_title($this->input->post('title')),
                'body' => $this->input->post('body'),
                'category_id'=> $categoryID,
                'post_image' => $postImage
                );  
                
                if($data["post"]["category_id"] != $categoryID) {
                    $categoryData = array(
                        "category_post_count" => ++$data["categories"]["category_post_count"]
                    );
                    $this->categories_model->category_count($categoryID, $categoryData);

                    $data["categories"] = $this->categories_model->get_categories($data["post"]["category_id"]);
                    $categoryData = array(
                        "category_post_count" => --$data["categories"]["category_post_count"]
                    );
                    $this->categories_model->category_count($data["categories"]["category_id"], $categoryData);
                }

                $this->post_model->update_post($postData, $postID);
                $this->session->set_flashdata("post_update","Update post succesfully");
                redirect("pages");
            }
        }

        public function fetch()
        {
            if($this->input->is_ajax_request()) {
                $postID = $this->input->post("post_id");
                $data = $this->post_model->get_posts($postID);
                echo json_encode($data);
            }else{
                echo "No direct script access allowed";
            }
        }

        public function getPostProfile()
        {
            if($this->input->is_ajax_request()) {
                $userID = $this->input->post("userID");
                $data = $this->post_model->getPostProfile($userID);
                echo json_encode($data);
            }else{
                echo "No direct script access allowed";
            }
        }

        public function reaction()
        {
            $id = $this->input->post("post_id");
            $get_post = $this->post_model->get_posts($id);
            $reactID = $get_post["react_id"];
           

            //  yung ginawa ko pag upvote tas pag pinindot yung upvote madedelete same kay downvote
            $json = file_get_contents(FCPATH."reaction.json");
            $json =  json_decode($json,true);
            // user na nagrereact
            
            $totalUpvote = $get_post["upvote"];
            $totalDownvote = $get_post["downvote"];
            $user =  $this->session->userdata("user_id");
             // kung upvote ba o hindi
            $voteType = $this->input->post("type_of_vote");
             // check kung upvote o hindi
            if($voteType == "up_react") {
                $json = json_decode($this->post_model->get_reaction($reactID)["react_log"],true);
                  
                $upvoteJson = $json["up_user_id"];
                $downvoteJson = $json["down_user_id"];
                // check kung nasa nag upvote na 
                if(in_array($user,$upvoteJson)) { 
                    $index = array_search($user,$json["up_user_id"]);
                    unset($json["up_user_id"][$index]);
                    $json = json_encode($json);    

                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalUpvote -= 1;
                    $upvoteData = array(
                        "upvote" => $totalUpvote,
                        "downvote" => $totalDownvote
                    );
                    $this->notification_model->notification_delete($id);
                    $this->post_model->delete_reaction($reactID,$reactData);
                    $this->post_model->update_upvotes($id,$upvoteData);
                }
                else {
                    // check kung may react na siya sa downvote
                    if(in_array($user,$downvoteJson)) {
                        $index = array_search($user,$json["down_user_id"]);
                        unset($json["down_user_id"][$index]);
                        $totalDownvote -= 1;
                        $this->notification_model->notification_delete($id);
                    }

                    $json["up_user_id"][] = $user;
                    $json = json_encode($json);
                
                    $reactData= array(
                        "react_log" => $json
                    );
                    $totalUpvote += 1;
                    $upvoteData = array(
                        "upvote" => $totalUpvote,
                        "downvote" => $totalDownvote
                    );

                    // notification
                    if($this->session->userdata("user_id") !=  $get_post["user_id"]) {
                        $notifData = array(
                            "action_id" => $get_post["id"],
                            "type_of_notif" => "react",
                            "user_id" => $this->session->userdata("user_id"),
                            "owner_id" => $get_post["user_id"],
                            "post_id" => $get_post["id"],
                            "comment_id" => NULL,
                            "read_status" => 0
                    );
                    
                    $this->notification_model->create_notification($notifData);
                    }
                    $this->post_model->update_reaction($reactID,$reactData);
                    $this->post_model->update_upvotes($id,$upvoteData);
                }
            }
            else {
                $json = json_decode($this->post_model->get_reaction($reactID)["react_log"],true);
                $downvoteJson = $json["down_user_id"];

                // check kung nasa nag upvote na 
                if(in_array($user,$downvoteJson)) {
                    $index = array_search($user,$json["down_user_id"]);
                    unset($json["down_user_id"][$index]);
                    $json = json_encode($json);

                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalDownvote -= 1;
                    $downvoteData = array(
                        "upvote" => $totalUpvote,
                        "downvote" => $totalDownvote
                    );
                    $this->notification_model->notification_delete($id);
                    $this->post_model->delete_reaction($reactID,$reactData);
                    $this->post_model->update_upvotes($id,$downvoteData);
                }
                else {
                    $upvoteJson = $json["up_user_id"];
                    if(in_array($user,$upvoteJson)) {
                        $index = array_search($user,$json["up_user_id"]);
                        unset($json["up_user_id"][$index]);
                        $totalUpvote -= 1;
                        $this->notification_model->notification_delete($id);
                    }
                    $json["down_user_id"][] = $user;
                    $json = json_encode($json);

                    $reactData = array(
                        "react_log" => $json
                    );
                    $totalDownvote += 1;
                    $downvoteData = array(
                        "upvote" => $totalUpvote,
                        "downvote" => $totalDownvote
                    );

                    if($this->session->userdata("user_id") !=  $get_post["user_id"]) {
                    $notifData = array(
                        "action_id" => $get_post["id"],
                        "type_of_notif" => "react",
                        "user_id" => $this->session->userdata("user_id"),
                        "owner_id" => $get_post["user_id"],
                        "post_id" => $get_post["id"],
                        "comment_id" => NULL,
                        "read_status" => 0
                    );
                    $this->notification_model->create_notification($notifData);
                    }
                    $this->post_model->update_reaction($reactID,$reactData);
                    $this->post_model->update_upvotes($id,$downvoteData);
                }
            }
        }
        
        public function view_comment($id)
        {
            $query = $this->comments_model->get_specific_comment($id);
            if ($query) {
                $this->view($query['post_id'], $id);
            }
        }
        
        
    }

