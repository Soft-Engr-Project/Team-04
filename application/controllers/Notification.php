<?php

	class Notification extends CI_Controller
    {
		private $data = array();
		public function index($user_id)
        {
			   $this->data["title"]=ucfirst('home');
               $this->load->view("templates/header.php");
               $this->data["categories"] = $this->categories_model->get_categories();
               $this->data["posts"] = $this->post_model->get_posts_high_react();
               $this->load->view("pages/home",$this->data);
               $this->data["title"]="Notification";
               // display all the notification you have
               $data = array(
               		"read_status" => 1
               );
               $this->notification_model->read_notification($user_id,$data);
               $this->data["notification"] = $this->notification_model->get_notification($user_id);
             
               $this->load->view("notification/index",$this->data);
			   $this->load->view("templates/footer.php");
		}
	}


?>