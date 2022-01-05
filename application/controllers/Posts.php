<?php
    class Posts extends CI_Controller{

        private $data = array();

        public function __construct(){
             parent::__construct();
            $this->load->model('Comments_model');
        }

        public function index(){
                $this->post_model->get_posts();
        }

        // get filter
        public function post_filter(){
            sleep(2);
                $post = $_GET['category'];
                
                $data["categories"] = $this->categories_model->get_categories();
               $data["posts"]=  $this->post_model->get_posts_for_filter($post);
              echo json_encode($data);
                    
                  
        }

        public function view($id=NULL, $comment_id=NULL){
            // if it is not set then $id is Null
            // $id = $this->input->post('id') ?? Null;

            //for header pic
            $user_idIn = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($user_idIn);
            $this->load->view("templates/header.php",$this->data);

            $this->data["post"] = $this->post_model->get_posts($id);
            $this->data["comments"] = $this->Comments_model->get_comments($id);
            $this->data["reported_id"] = $comment_id;
            $this->load->view("templates/header.php");
            $this->load->view("posts/view",$this->data);
            $this->load->view("templates/footer",$this->data);
        }

        public function create(){

            //for header pic
            $user_idIn = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($user_idIn);
            $this->load->view("templates/header.php",$this->data);

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
                $json_data = file_get_contents(FCPATH."reaction.json");
                $react_id = $this->post_model->create_reaction_log($json_data);

                // Upload a image
                $config["upload_path"] = "./assets/images/post"; 
                // kung walang post folder mag automatic make
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
                }
                else{
                    $data = array("upload_data" => $this->upload->data());
                    // var_dump($_FILES);
                    // use file name
                    $post_image = "assets/images/post/".$_FILES['userfile']["name"];
                    // var_dump($_FILES['userfile']);
                    // var_dump($data);
                    // die();
                }

                $category_id = $this->input->post("category_id");
                $data =array(
                    "category_id"=> $category_id,
                    "user_id" => $this->session->userdata("user_id"),
                    "react_id" => $react_id,
                    "title"=>$this->input->post("title"),
                    "body" =>$this->input->post("body"),
                    "slug" => url_title($this->input->post("title")),
                    "post_image" => $post_image
            
                );
                $data_category = array(
                    "category_post_count" => ++$this->data["categories"]["category_post_count"]
                );
                $this->categories_model->category_count($category_id,$data_category);
                $this->post_model->create_post($data);
                $this->session->set_flashdata("post_create","Create post succesfully");
                redirect("pages");
            }

        }
        // delete a post 
        public function delete($id){
            $category_id = $this->input->post("category");
            $user_id = $this->post_model->get_posts($id)["user_id"];
            $react_id = $this->input->post("react_id");
            if($this->session->userdata("user_id") != $user_id && $this->session->userdata("admin") != true){
                redirect("pages");
            }
            
            // get category of specific post
            $this->data["categories"] = $this->categories_model->get_categories($category_id);
            $data_category = array(
                    "category_post_count" => --$this->data["categories"]["category_post_count"]
            );
            $this->categories_model->category_count($category_id,$data_category);
            $this->post_model->delete_reactions($react_id);
            $this->post_model->delete_post($id);
            $this->session->set_flashdata("post_delete","Delete a thread succesfully");
            redirect("pages");
        }
        public function edit($id){
             //for header pic
            $user_idIn = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($user_idIn);
            $this->load->view("templates/header.php",$this->data);
            
            $user_id = $this->post_model->get_posts($id)["user_id"];

            if($this->session->userdata("user_id") != $user_id && $this->session->userdata("admin") != true){
                redirect("pages");
            }
            $this->data["post"] = $this->post_model->get_posts($id);
            $this->data["categories"] = $this->categories_model->get_categories();
            $this->data["title"]="Edit Post";
            // $this->data["slug"] = $slug;
            if(empty($this->data["post"])){
                show_404();
            }
            $this->data["title"] = $this->data["post"]["title"];
            $this->load->view("templates/header.php");
            $this->load->view("posts/edit",$this->data);
            $this->load->view("templates/footer.php");
        }
        public function update(){ 
            $category_id = $this->input->post("category_id");
            $post_id = $this->input->post("id");
            // get the post for checking if the category is change
            $this->data["post"] = $this->post_model->get_posts($post_id);
            // get category of specific post
            
            $post_image = $this->input->post("post_image");
            $image = $_FILES['userfile'];
            if($image && $image["tmp_name"]){
                echo "pasok";
                unlink("assets/images/posts/".$post_image);

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
                if(! $this->upload->do_upload('userfile')){
                    // dinidisplay nito yung error message
                    $errors= array("error" => $this->upload->display_errors());
                    // default
                    $post_image = "noimage.jpg";
                    // eto piniprint pag di alam yung error
                    // base sa na experience ko need yung picture ay di lalagpas ng 800x800
                    echo $this->upload->display_errors();
                    //die();
                }
                else{
                    $data = array("upload_data" => $this->upload->data());
                    // var_dump($_FILES);
                    // use file name
                    $post_image = $_FILES['userfile']["name"];
                }
            }
           
            $data=array(
            'title'=> $this->input->post('title'),
            'slug' => url_title($this->input->post('title')),
            'body' => $this->input->post('body'),
            'category_id'=> $this->input->post("category_id"),
            'post_image' => $post_image
             );  
            
            if($this->data["post"]["category_id"] != $category_id){
                 $data_category = array(
                    "category_post_count" => ++$this->data["categories"]["category_post_count"]
                 );
                 $this->categories_model->category_count($category_id,$data_category);

                 $this->data["categories"] = $this->categories_model->get_categories($this->data["post"]["category_id"]);
                  $data_category = array(
                    "category_post_count" => --$this->data["categories"]["category_post_count"]
                 );
                 $this->categories_model->category_count($this->data["categories"]["category_id"],$data_category);
            }
            $id = $this->input->post("id");
            $this->post_model->update_post($data,$id);
            $this->session->set_flashdata("post_update","Update post succesfully");
            redirect("pages");
        }
        public function reaction($id){

            $react_id = $this->input->post("react_id");
            // $json_data = file_get_contents(FCPATH."reaction.json");
            // $json =  json_decode($json_data,true);
            // echo "<pre>";
            // var_dump($json);
            // echo "<br>";
            // $json[12][] =array(1,2);
            // var_dump($json);
            // echo "</pre>";

            // check kung nasa json na
            /*
                {
                    userid:1,
                    reaction: upvote,
                    userid:2 ,
                    reaction: downvote,
                }
                { 
                    reaction: upvote,
                    userid:[ 1, 2 ,3, 4 ,5],
                    reaction: downvote,
                    userid:[7, 8]
                }

        
            */
            //  yung ginawa ko pag upvote tas pag pinindot yung upvote madedelete same kay downvote


             $json_data = file_get_contents(FCPATH."reaction.json");
             $json =  json_decode($json_data,true);
             // user na nagrereact
             $get_post = $this->post_model->get_posts($id);
             $total_upvote = $get_post["upvote"];
             $total_downvote = $get_post["downvote"];
             $user =  $this->session->userdata("user_id");
             // kung upvote ba o hindi
             $type_of_vote = $this->input->post("submit");
             // check kung upvote o hindi
             if($type_of_vote == "up_react"){
                $json_data = json_decode($this->post_model->get_reaction($react_id)["react_log"],true);
                  
                $upvote_array = $json_data["up_user_id"];
                $downvote_array = $json_data["down_user_id"];
                // check kung nasa nag upvote na 
                if(in_array($user,$upvote_array)){ 
                    $index = array_search($user,$json_data["up_user_id"]);
                    unset($json_data["up_user_id"][$index]);
                    $json_data = json_encode($json_data);    

                    $data = array(
                        "react_log" => $json_data
                    );
                    $total_upvote -= 1;
                    $data_upvote = array(
                        "upvote" => $total_upvote,
                        "downvote" => $total_downvote
                    );

                    $this->post_model->delete_reaction($react_id,$data);
                    $this->post_model->update_upvotes($id,$data_upvote);
                }
                else{
                    // check kung may react na siya sa downvote
                    
                    if(in_array($user,$downvote_array)){
                        $index = array_search($user,$json_data["down_user_id"]);        
                        unset($json_data["down_user_id"][$index]);
                        $total_downvote -= 1;
                    }
                    $json_data["up_user_id"][] = $user;
                    $json_data = json_encode($json_data);    
                
                    $data = array(
                        "react_log" => $json_data
                    );
                    $total_upvote += 1;
                    $data_upvote = array(
                        "upvote" => $total_upvote,
                        "downvote" => $total_downvote
                    );
                    $this->post_model->update_reaction($react_id,$data);
                    $this->post_model->update_upvotes($id,$data_upvote);
                }
             }
             else{
                echo "down_react";
                $json_data = json_decode($this->post_model->get_reaction($react_id)["react_log"],true);
                  
                $downvote_array = $json_data["down_user_id"];

                // check kung nasa nag upvote na 
                if(in_array($user,$downvote_array)){ 
                    $index = array_search($user,$json_data["down_user_id"]);
                    unset($json_data["down_user_id"][$index]);
                    $json_data = json_encode($json_data);    

                    $data = array(
                        "react_log" => $json_data
                    );
                    $total_downvote -= 1;
                    $data_downvote = array(
                        "upvote" => $total_upvote,
                        "downvote" => $total_downvote
                    );
                    $this->post_model->delete_reaction($react_id,$data);
                    $this->post_model->update_upvotes($id,$data_downvote);
                }
                else{
                    $upvote_array = $json_data["up_user_id"];
                    if(in_array($user,$upvote_array)){
                        $index = array_search($user,$json_data["up_user_id"]);
                        unset($json_data["up_user_id"][$index]);
                        $total_upvote -= 1;
                    }
                    $json_data["down_user_id"][] = $user;
                    $json_data = json_encode($json_data);

                    $data = array(
                        "react_log" => $json_data
                    );
                    $total_downvote += 1;
                    $data_downvote = array(
                        "upvote" => $total_upvote,
                        "downvote" => $total_downvote
                    );
                    $this->post_model->update_reaction($react_id,$data);
                    $this->post_model->update_upvotes($id,$data_downvote);
                }
             }
             redirect("posts/".$id);
        }
        
        public function Mark($id){
        
            $query = $this->comments_model->get_specific_comment($id);
            if ($query){
                $this->view($query['post_id'], $id);
            }
        }
        
        
    }

?>