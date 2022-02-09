<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageTemplate {

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
        
    }

    public function show($content = null, $data = null, $page = null) {
        // $data['user'] = $this->user_model->get_profile();
        $layout = array();

        $layout['header'] = $this->CI->load->view('templates/header', $data, true);
        $layout['footer'] = $this->CI->load->view('templates/footer', null, true);

        $layout['content'] = $this->CI->load->view($content,$data, true);
        if ($page) {
            $layout['page'] = $this->CI->load->view($page,$data, true);
        }

        $this->CI->load->view('templates/layout', $layout);
    }
    public function loadWhatSauceTemplate($content = null, $data = null) {
        // $data['user'] = $this->user_model->get_profile();
        $layout = array();
        $layout['navbar3'] = $this->CI->load->view('templates/navbar3', null, true);
       // $layout['header'] = $this->CI->load->view('templates/header', null, true);
        $layout['footer'] = $this->CI->load->view('templates/footer', null, true);
       // $layout['links'] = $this->CI->load->view('templates/links', $data, true);
        $layout['content'] = $this->CI->load->view($content, $data, true);
  
        $this->CI->load->view('templates/content1', $layout);
    }
}