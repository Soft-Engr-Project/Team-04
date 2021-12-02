<?php
//
class Post_model extends CI_Model{
    private $post_table = "posts";
    private $categories_table = "categories"; 
    private $users_table = "users";
    public function __construct()
    {
        // load the database();
        $this->load->database();
    }
    // get all the posts
    public function get_posts($slug=False){
        if($slug == False){
            // get posts table
             $this->db->order_by($this->post_table.".id","DESC");
             $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
             $this->db->join($this->users_table,$this->users_table.".userID = ".$this->post_table.".user_id");
             $query = $this->db->get($this->post_table);
             return $query->result_array();
        }
        // get a specific post
        $id = $this->input->post("id");
        $this->db->where("id",$id);
        $this->db->where("slug",$slug);
        $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
        $this->db->join($this->users_table,$this->users_table.".userID = ".$this->post_table.".user_id");
        $query = $this->db->get($this->post_table);
        return $query->row_array();
    }
    public function create_post(){
        // get the submitted title and the body
        $title = $this->input->post("title",True);
        $body = $this->input->post("body",True);
        $slug = url_title($this->input->post("title"));
        $data = array(
            'title'=>$title,
            'slug' => $slug,
            'body' => $body,
            'category_id'=> $this->input->post("category_id"),
            "user_id" => $this->session->userdata("user_id")
        );
        // insert it to database
        return $this->db->insert($this->post_table,$data);
    }
    // delete a specific post
    public function delete_post($id){
        $this->db->where("id",$id);
        $this->db->delete($this->post_table);
        return true;
    }
    public function update_post(){
        $slug = url_title($this->input->post('title'));
        $data=array(
            'title'=> $this->input->post('title'),
            'slug' => $slug,
            'body' => $this->input->post('body'),
            'category_id'=> $this->input->post("category_id")
        );  
        $this->db->where("id",$this->input->post("id"));
        return $this->db->update("posts",$data);
    }

}



?>