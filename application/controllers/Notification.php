<?php

	class Notification extends CI_Controller
    {
        private $data = array();
		public function index($user_id)
        {
               $data["categories"] = $this->categories_model->get_categories();
               $data["posts"] = $this->post_model->get_posts_high_react();
              
               $data["title"]="Notification";
               // display all the notification you have
               $dataNotif = array(
               		"read_status" => 1
               );
               $this->notification_model->read_notification($user_id, $dataNotif);
               $data["notification"] = $this->notification_model->get_notification($user_id);

               $this->pagetemplate->show("pages/home", $data, "notification/index");
		}
        public function bellCountChecker()
        {
            if($this->input->is_ajax_request()) {
                $userID = $this->input->post("userID");
                $data["notification"] = $this->notification_model->get_notification_count($userID);
                echo json_encode($data["notification"]);
            }
        }
        public function getNotification()
        {
            if($this->input->is_ajax_request()) {
                $userID = $this->input->post("userID");
                $data["notification"] = $this->notification_model->get_notification($userID);
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


