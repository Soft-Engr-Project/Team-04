<?php
//
class Reports_model extends CI_Model{

    public function __construct(){
        $this->load->database();
        $this->load->model('Comments_model');
        $this->load->model('Post_model');
    }

    // INSERT REPORT DETAILS IN THE DB
    public function create_report($data) {
        return $this->db->insert('reports', $data);
    }
    
    public function update_count($id, $count) {
        $this->db->where('id', $id);
        $this->db->update('posts', $count);
    }

    public function delete_report($id) {
        $this->db->where("id",$id);
        $this->db->delete('reports');
    }
    
    public function get_reports(){
        // GET ALL REPORTS
        $reports = array();
        $this->db->select('reports.*,reports.id AS report_id, users.username AS complainant');
        $this->db->join('users','users.user_id = reports.complainant_id');
        // $this->db->join('posts','posts.id = reports.post_id','left');
        // $this->db->join('discussion','discussion.comment_id = reports.comment_id','left');
        $query = $this->db->get('reports');
    
        $q = $query->result_array();
        // echo '<pre>';
        // var_dump($q);
        // echo '</pre>';
        // exit;

        // Loop through the reports to get the content
        foreach($q as $report){
            if ($report['post_id']){
                $query_report = $this->post_model->get_posts($report['post_id']);
                $report += $query_report;
            }
            else{
                $query_comment = $this->comments_model->get_specific_comment($report['comment_id']);
                $report += $query_comment;
            }
            
            $reports [$report['id']] = $report;
        }
        // echo '<pre>';
        // var_dump($reports);
        // echo '</pre>';
        // exit;
        
        return $reports;
    }

    public function get_specific_report($id){

        $this->db->select('reports.* , users.username');
        $this->db->join('users','users.user_id = reports.complainant_id');
        $this->db->where('id',$id);
        $query = $this->db->get('reports');
        
        if($query->num_rows()>0){
            $report = $query->row_array();
            if ($report['type'] == 'thread'){
                
                $query2 = $this->post_model->get_posts($report['content_id']);
                $report['complainant'] = $report['username'];
                $report = array_merge($query2,$report);
            }
            else{
        
                $query2 = $this->comments_model->get_specific_comment($report['content_id']);
                $report['complainant'] = $report['username'];
                $report = array_merge($query2,$report);
            }
            
        }
        return $report;
    }
    

    
 
        
    

}



?>