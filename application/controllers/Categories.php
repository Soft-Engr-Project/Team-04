<?php

	class Categories extends CI_Controller
	{

		public function display()
		{
			$data["title"] = "Categories";
			$data["categories"] = $this->categories_model->get_categories();
			$this->load->view("templates/header", $data);
			$this->load->view("categories/display");
			$this->load->view("templates/footer");
		}
		// iviview lahat ng same category 
		public function view($name)
		{
			$data["title"] = $name;
			// pancheck kung may meron ba sa database na category
			if ($this->categories_model->get_categories($name)) {
				show_404();
			}
			$data["posts"] = $this->categories_model->get_posts_by_category($name);
			$this->load->view("templates/header", $data);
			$this->load->view("posts/index");
			$this->load->view("templates/footer");
		}
	}


