<?php

	class Notification extends CI_Controller
    {
        private $data = array();
	
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


