<!-- <?php

	class Categories_model extends CI_Model{
		private $category_table = "categories";
		private $data = array();
		
		public function __construct(){
			$this->load->database();
		}

		public function get_categories($id=Null){
			if($id == Null){
				$this->db->order_by("name","DESC");
				$query = $this->db->get("categories");
				return $query->result_array();
			}
			$this->db->where("category_id",$id);
			$query = $this->db->get("categories");
			return $query->row_array();
		}
		public function category_count($category_id,$data_category){
			$this->db->where("category_id",$category_id);
			$this->db->update($this->category_table,$data_category);
		}
	}


?> -->