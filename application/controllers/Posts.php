<?php


class Posts extends CI_Controller{

    public function index(){
        // APPPATH - ROOT FOLDER
        //THIS IF CHECK IF WE HAVE FOLDER PAGES IN THE VIEW AND IF IT HAS PAGES FOLDER THEN FIND A SPECIFIC
        // PHP FILE
        $data['posts'] = $this->post_model->get_posts();
        $data["title"]="Latest Post";
        $this->load->view("templates/header.php");
        $this->load->view("posts/index",$data);
        $this->load->view("templates/footer.php");
    }

}



?>