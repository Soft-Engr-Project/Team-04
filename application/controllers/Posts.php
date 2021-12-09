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
                $json_data = file_get_contents(FCPATH."reaction.json");
                $react_id = $this->post_model->create_reaction_log($json_data);

                $data =array(
                        "title"=>$this->input->post("title"),
                        "body" =>$this->input->post("body"),
                        "slug" => url_title($this->input->post("title")),
                        "category_id"=> $this->input->post("category_id"),
                        "user_id" => $this->session->userdata("user_id"),
                        "react_id" => $react_id
                    );
                
                $this->post_model->create_post($data);
                
               
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
        
    }

?>