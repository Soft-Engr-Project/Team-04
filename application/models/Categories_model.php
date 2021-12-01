<!-- <?php

	class Categories_model extends CI_Model{
		private $category_table = "categories";
		private $data = array();
		
		public function __construct(){
			$this->load->database();
		}

		public function get_categories(){
			$this->db->order_by("name","DESC");
			$query = $this->db->get("categories");
			return $query->result_array();
		}
	}


?> -->