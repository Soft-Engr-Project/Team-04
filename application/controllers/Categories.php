<?php

	class Categories extends CI_Controller
	{

		public function display()
		{
			$data["title"] = "Categories";
			$data["categories"] = $this->categories_model->get_categories();
			$this->pagetemplate->show("categories/display", $data);
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
			$this->pagetemplate->show("posts/index", $data);
		}
		public function create_category()
		{
			$categoryData = array(
				"name" => $this->input->post("category")
			);
			$this->categories_model->create($categoryData);
			redirect("admins/categories");
		}
		public function delete_category()
		{
			$id = $this->input->post("id");
			$this->categories_model->delete($id);
			redirect("admins/categories");
		}
	}


