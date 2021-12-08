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
        public function view($id=NULL){
            // if it is not set then $id is Null
            // $id = $this->input->post('id') ?? Null;
            $this->data["post"] = $this->post_model->get_posts($id);
            $this->data["comments"] = $this->Comments_model->get_comments($id);
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
                $log = array(
                    "reaction_log" => array()
                );
                $react = array(
                    "reaction_log" => json_encode($log)
                );
                $this->post_model->create_post($data);
                // get the post 
                $this->post_model->create_reaction_log($react);
                $this->session->set_flashdata("post_create","Create post succesfully");
                redirect("pages");
            }

        }
        public function delete($id){
            $user_id = $this->post_model->get_posts($id)["user_id"];
            if($this->session->userdata("user_id") != $user_id){
                redirect("pages");
            }

            $this->post_model->delete_post($id);
            $this->session->set_flashdata("post_delete","Delete a thread succesfully");
            redirect("pages");
        }
        public function edit($id){
            $user_id = $this->post_model->get_posts($id)["user_id"];

            if($this->session->userdata("user_id") != $user_id){
                echo "hello"; die();
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
        public function hello(){
            print_r($this->input->post());
            
        }
        public function reaction($id){
            // get all vote
            $type_of_vote = $this->input->post("submit");
            $vote = 1 ;
            // get all the total number of upvote and downvote
            $get_vote = $this->post_model->get_vote($id);
            $upvote = (int)$get_vote["upvote"];
            $downvote = (int)$get_vote["downvote"];

            // check if the user is in the log
            $isTrue = $this->post_model->check_user_reaction($id,$this->session->userdata("user_id"));
            // pag di pa nakakareact
            if(!$isTrue){
                // kung downvote ba o hindi
                if($type_of_vote == "upvote"){
                    $upvote += $vote;
                }
                else{
                    $downvote += $vote;
                }
              $data = array(
                "upvote" => $upvote,
                "downvote" => $downvote
              );
              // get_specific_post
              $reaction = $this->post_model->get_reaction($id);
              $reaction_log = json_decode($reaction["reaction_log"],true);
              $reaction_log[] = array(
                "user_id" => array( $this->session->userdata("user_id"),$type_of_vote)
                );
              $json_reaction  = json_encode($reaction_log);
              $log = array(
                "reaction_log" => $json_reaction
              );
              
              $this->post_model->update_reaction_log($id,$log);
              $this->post_model->update_vote($id,$data);
              redirect("posts/".$id);
            }
            else{
                redirect("posts/".$id);
            }
            
        }
        
    }

?>