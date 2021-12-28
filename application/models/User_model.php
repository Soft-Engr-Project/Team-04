<?php

    class User_model extends CI_Model{
        private $post_table = "posts";
        private $categories_table = "categories"; 
        private $users_table = "users";
        private $reactions_table = "reactions";
        private $comment_table = "discussion";
    
      public function get_user($user_id){
        $this->db->where("user_id",$user_id);
        $query = $this->db->get($this->users_table);
        return $query->row_array();
      }
    }





?>