<?php

	class Categories extends CI_Controller{
		private $data = array();
		public function display(){
			$this->data["title"] = "Categories";
			$this->data["categories"] = $this->categories_model->get_categories();
			$this->load->view("templates/header.php");
			$this->load->view("categories/display.php",$this->data);
			$this->load->view("templates/footer.php");
		}
		// iviview lahat ng same category 
		public function view($name){
			$this->data["title"] = $name;
			// pancheck kung may meron ba sa database na category
			if($this->categories_model->get_categories($name)){
				show_404();
			}
			$this->data["posts"] = $this->categories_model->get_posts_by_category($name);
			$this->load->view("templates/header.php");
			$this->load->view("posts/index.php",$this->data);
			$this->load->view("templates/footer.php");
		}
		

		
	}


?>