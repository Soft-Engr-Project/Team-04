<!-- <?php

	class Categories_model extends CI_Model{
		private $table = "categories";
		private $data = array();
		
		public function __construct(){
			parent::__construct();
  
    		/* Load Models - Model_1 */
    		$this->load->model('Post_model');
			$this->load->database();

		}
		// get all category 
		public function get_categories($name = false){
			if($name == false){
				$query = $this->db->get($this->table);
	        	return $query->result_array();
			}
	        // pancheck kung may categories ba na ganon o wala
	        $query = $this->db->get_where($this->table,array("name"=>$name));
			return empty($query->row_array());
		}
		// eto may mali pa to pano pag yung name wala
		public function get_posts_by_category($name){
			$get_post = $this->Post_model->get_posts();
			$get_category = $this->get_categories();
			$get_posts_category = array();
			foreach($get_post as $post){
				
				foreach($get_category as $category){
					if($category["name"] === $post["category_id"] && $name == $post["category_id"]){

						$get_post_category[] = $post;
					}
				}
			}
			return $get_post_category;
		}



	}


?> -->