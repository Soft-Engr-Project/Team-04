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

      public function search_all($key){
        $results = array();

        $this->db->select('id,title,body,post_created_at,users.user_id,users.username,users.user_profile_photo');
        $this->db->like('title', $key); 
        $this->db->or_like('body', $key);
        $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->post_table.".user_id");
        $query = $this->db->get('posts');
        $results['Threads'] = $query->result_array();

        $this->db->select('comment_id,post_id,content,created_at,users.user_id,users.username,users.user_profile_photo');
        $this->db->like('content', $key); 
        $this->db->join($this->users_table,$this->users_table.".user_id = ".$this->comment_table.".user_id");
        $query = $this->db->get('discussion');
        $results['Comments'] = $query->result_array();

        $this->db->like('username', $key); 
        $query = $this->db->get('users');
        $results['Profiles'] = $query->result_array();

        
        return $results;
      }

      public function get_suggestions($key){
        $this->db->select('title');
        $this->db->like('title', $key); 
        
        $this->db->limit(10);
        $query = $this->db->get('posts');
        return $query->result_array();
      }
      

    }





?>