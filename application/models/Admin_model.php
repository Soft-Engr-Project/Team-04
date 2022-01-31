<?php

class Admin_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function admin_info($id){
        $this->db->where("id",$id);
		$query = $this->db->get("admins");
		
        return $query->row_array();
    }

    public function total_counts($keyword = Null){
        if ($keyword) {
            $query = $this->db->get($keyword);
            $count[$keyword] = $query->num_rows();
            
        }else {
            $query = $this->db->get("posts");
            $count["posts"] = $query->num_rows();
            $query = $this->db->get("categories");
            $count["categories"] = $query->num_rows();
            $query = $this->db->get("users");
            $count["users"] = $query->num_rows();
            $query = $this->db->get("reports");
            $count["reports"] = $query->num_rows();
        }
        

        return $count;
    }
}