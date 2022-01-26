<?php

	class Notification extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Notification_model');
        }

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
        public function bellCountChecker()
        {
            if($this->input->is_ajax_request())
            {
                $userID = $this->input->post("userID");
                $this->data["notification"] = $this->Notification_model->get_notification_count($userID);
                echo json_encode($this->data["notification"]);
            }
        }
        public function getNotification()
        {
            if($this->input->is_ajax_request())
            {
                $userID = $this->input->post("userID");
                $this->data["notification"] = $this->Notification_model->get_notification($userID);
                echo json_encode($this->data["notification"]);
            }
        }
        public function readNotification()
        {
            if($this->input->is_ajax_request())
            {
                $userID = $this->input->post("userID");
                $data = array(
                    "read_status" => 1
                );
                $this->notification_model->read_notification($userID,$data);
            }
        }
	}


?>