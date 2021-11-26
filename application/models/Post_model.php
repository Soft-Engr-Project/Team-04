<?php
//
class Post_model extends CI_Model{
    public function __construct()
    {
        // load the database();
        $this->load->database();
    }
    public function get_posts($slug = FALSE){
        if($slug===FALSE){
            // $this->db->order_by('posts.id','DESC');
            // $this->db->join("categories","categories.id  = posts.category_id");
            // $query = $this->db->get('posts');
                $query = $this->get_categories_manually();
             return $query;
        }
        $query = $this->db->get_where('posts',array('slug'=> $slug));
        return $query->row_array();
    }
    public function get_categories(){
        $query = $this->db->get('categories');
        return $query->result_array();
    }
    public function create_post(){
        // create a slug using url_title()
        // $this->input->post("title"); meaning niyan kinuha niya yung inimput ni user 
        // post meaning method niya ay $_POST 
        // "title" eto yung kinuha
        $slug = url_title($this->input->post("title"));
        $data = array(
            'title'=> $this->input->post("title"),
            'slug' => $slug,
            'body' => $this->input->post("body"),
            'category_id' => $this->input->post("category_id")
        );
        return $this->db->insert('posts',$data);
    
    }
    public function delete_post($id){
        $this->db->where('id',$id);
        $this->db->delete('posts');
        return true;
    }
    public function update_post(){
        $slug = url_title($this->input->post('title'));
        $data=array(
            'title'=> $this->input->post('title'),
            'slug' => $slug,
            'body' => $this->input->post('body'),
            'category_id' => $this->input->post("category_id")
        );  
        $this->db->where("id",$this->input->post("id"));
        return $this->db->update("posts",$data);
    }

    public function get_categories_manually(){
        // // kinuha ko yung data ni post table
        // $query = $this->db->get("posts");

        // // kinuha ko yung data ni categories table
        // $query1 = $this->db->get("categories");
       
        // // yung data na nakuha ko hinold ko kay $a naka associative array siya pati si $q1
        // $q = $query->result_array();

        // $q1 = $query1->result_array();

        // foreach($q as $key => $value){
            
        //     foreach($q1 as $key1 => $value1){
        //         if($q[$key]["category_id"]==$q1[$key1]["id"]){
        //             $q[$key]["category_id"] = $q1[$key1]["name"];
        //         }
        //     }
            
        // }

        $query = $this->db->get("posts");
        $num = $query->num_rows();
        // kinuha ko yung data ni categories table
        //$this->db->order_by("name",DESC);
        $query1 = $this->db->get("categories");
       
         $q = $query->result_array();

        $q1 = $query1->result_array();

        for($i=0;$i<$num;$i++){
            
            $id=$q[$i]["category_id"];
            $q[$i]["category_id"]=$q1[$id-1]["name"];
            
        }
        //    echo "<pre>";
         //   var_dump($q);
         //   echo "</pre>";
         return $q;
       

    }
   

}



?>