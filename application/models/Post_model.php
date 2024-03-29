<?php
//
class Post_model extends CI_Model{
    private $post_table = "posts";
    private $categories_table = "categories"; 
    private $users_table = "users";
    private $reactions_table = "reactions";
    
    public function __construct()
    {
        $this->load->database();
        
    }
    // get all the posts
    public function get_posts($id=Null){
        if($id == False){
            // get posts table
             $this->db->order_by($this->post_table.".id","category_id DESC");
             $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
             $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->post_table.".user_id");
             $query = $this->db->get($this->post_table);
          
             return $query->result_array();
        }
        $this->db->where($this->post_table.".id",$id);
        $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
        $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->post_table.".user_id");
        $query = $this->db->get($this->post_table);
        return $query->row_array();
    }

    public function get_posts_for_filter($categoryID, $filterBy){
        if ($categoryID > 0) {
            $this->db->where($this->post_table.".category_id", $categoryID);
            $this->db->order_by($filterBy, "DESC");
            $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
            $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->post_table.".user_id");
            $query = $this->db->get($this->post_table);
        }
        else {
            $this->db->order_by($filterBy, "DESC");
            $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
            $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->post_table.".user_id");
            $query = $this->db->get($this->post_table);
        }
        return $query->result_array();
    }
    // get the top 10 post with many reaction
    public function get_posts_high_react(){
        
        $this->db->select('*');
        $this->db->order_by($this->post_table.".post_comment_count DESC");
        $this->db->limit(10,FALSE);
        $this->db->where('MONTH(post_created_at)', date('m'));
        $this->db->where('YEAR(post_created_at)', date('Y'));
        $query = $this->db->get($this->post_table);

        return $query->result_array();
    }

    public function create_post($data){
        return $this->db->insert($this->post_table,$data);
    }
    // delete a specific post
    public function delete_post($id){
        $this->db->where("id",$id);
        $this->db->delete($this->post_table);
        return true;
    }
    // put the data in reaction
    public function create_reaction_log($reactions_log){
        $this->db->insert($this->reactions_table,array("react_log" => $reactions_log));
        return $this->db->insert_id($this->post_table);
    }
    public function update_post($data,$id){
        $this->db->where("id",$id);
        return $this->db->update("posts",$data);
    }
    public function get_reaction($react_id){
        $this->db->join($this->reactions_table,$this->reactions_table.".react_id = ".$this->post_table.".react_id");
        $this->db->where($this->post_table.".react_id",$react_id);
        $query = $this->db->get($this->post_table);
        return $query->row_array();
    }
    public function update_reaction($react_id,$data){
        
        $this->db->where("react_id",$react_id);
        return $this->db->update($this->reactions_table,$data);
    }
    public function delete_reaction($react_id,$data){
        $this->db->where("react_id",$react_id);
        return $this->db->update($this->reactions_table,$data); 
    }

    public function update_upvotes($id,$data){
        $this->db->where("id",$id);
        return $this->db->update($this->post_table,$data);
    }
    // delete a certain react log 
    public function delete_reactions($react_id) {
        $this->db->where("react_id",$react_id);
        return $this->db->delete($this->reactions_table);
    }

    public function get_posts_content(){
        // get posts table
        $this->db->select('id,title,body,post_created_at,users.user_id,users.username,users.user_profile_photo');
        $this->db->order_by($this->post_table.".id","category_id DESC");
        $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->post_table.".user_id");
        $query = $this->db->get($this->post_table);
        return $query->result_array();
    }

   
    public function getPostProfile($userID){
      
            $this->db->order_by($this->post_table.".id","post_created_at DESC");
             $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
             $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->post_table.".user_id");
            $this->db->where($this->post_table.".user_id" , $userID);
            $query = $this->db->get($this->post_table);
            return $query->result_array(); 
    }


}



?>