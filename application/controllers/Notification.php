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
               $userID = $this->session->userdata("user_id");
               $this->data["user"] = $this->user_model->get_user($userID);
               $this->load->view("templates/header",$this->data);
               $this->data["categories"] = $this->categories_model->get_categories();
               $this->data["posts"] = $this->post_model->get_posts_high_react();
               $this->load->view("pages/home",$this->data);
               $this->data["title"]="Notification";
               // display all the notification you have
               $dataNotif = array(
               		"read_status" => 1
               );
               $this->notification_model->read_notification($user_id,$data);
               $this->data["notification"] = $this->notification_model->get_notification($user_id);
             
               $this->load->view("notification/index",$this->data);
			   $this->load->view("templates/footer");
		}
        public function bellCountChecker()
        {
            if($this->input->is_ajax_request()) {
                $userID = $this->input->post("userID");
                $data["notification"] = $this->Notification_model->get_notification_count($userID);
                echo json_encode($data["notification"]);
            }
        }
        public function getNotification()
        {
            if($this->input->is_ajax_request()) {
                $userID = $this->input->post("userID");
                $data["notification"] = $this->Notification_model->get_notification($userID);
                echo json_encode($data["notification"]);
            }
        }
        public function readNotification()
        {
            if($this->input->is_ajax_request()) {
                $userID = $this->input->post("userID");
                $dataNotif = array(
                    "read_status" => 1
                );
                $this->notification_model->read_notification($userID, $dataNotif);
            }
        }
	}


?>