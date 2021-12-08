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
             $this->db->order_by($this->post_table.".id","DESC");
             $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
             $this->db->join($this->users_table,$this->users_table.".userID = ".$this->post_table.".user_id");
             $query = $this->db->get($this->post_table);
             return $query->result_array();
        }
        $this->db->where("id",$id);
        $this->db->join($this->categories_table,$this->categories_table.".category_id = ".$this->post_table.".category_id");
        $this->db->join($this->users_table,$this->users_table.".userID = ".$this->post_table.".user_id");
        $query = $this->db->get($this->post_table);
        return $query->row_array();
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
        $post_last_inserted = $this->db->insert_id($this->post_table);
        $this->db->insert($this->reactions_table,array("id" => $post_last_inserted,"reaction_log" => $reactions_log));
    }

    // check the user kung naka react na o hindi
    public function check_user_reaction($id,$user_id){
        $this->db->where("id",$id);
        $query = $this->db->get($this->reactions_table);
        // pancheck
        $json = json_decode($query->row_array()["reaction_log"],true);
        echo "<pre>";
        var_dump($json);
        echo "</pre>";
        die();
        // foreach(json)
        if(in_array($user_id,$json)){
            return true;
        }
        else{
            return false;
        }

    }
    // kunin lahat ng nagreact
    public function get_reaction($id){
        $this->db->where("id",$id);
        $query = $this->db->get($this->reactions_table);
        return $query->row_array();

    }
    // update yung reaction_log sa magrereact
    public function update_reaction_log($id,$data){
        $this->db->where("id",$id);
        return $this->db->update($this->reactions_table,$data);
    }

    public function update_post($data,$id){
      
        $this->db->where("id",$id);
        return $this->db->update("posts",$data);
    }
    public function get_vote($id){
            $query = $this->db->get_where($this->post_table,array("id" => $id));
            return $query->row_array();
    }
    public function update_vote($id,$data){
            $this->db->where("id",$id);
            return $this->db->update($this->post_table,$data);
            
    }

}



?>