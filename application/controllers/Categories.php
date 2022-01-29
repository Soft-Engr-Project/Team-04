<?php

	class Categories extends CI_Controller
	{
		private $data = array();

		public function display()
		{
			$this->data["title"] = "Categories";
			$this->data["categories"] = $this->categories_model->get_categories();
			$userID = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($userID);
			$this->load->view("templates/header",$this->data);
			$this->load->view("categories/display",$this->data);
			$this->load->view("templates/footer");
		}
		// iviview lahat ng same category 
		public function view($name)
		{
			$this->data["title"] = $name;
			// pancheck kung may meron ba sa database na category
			if ($this->categories_model->get_categories($name)) {
				show_404();
			}
			$this->data["posts"] = $this->categories_model->get_posts_by_category($name);
			$userID = $this->session->userdata("user_id");
            $this->data["user"] = $this->user_model->get_user($userID);
			$this->load->view("templates/header",$this->data);
			$this->load->view("posts/index",$this->data);
			$this->load->view("templates/footer");
		}
	}


?>