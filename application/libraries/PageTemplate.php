<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageTemplate {

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
        
    }

    public function show($content = null, $data = null, $page = null) {
        $layout = array();

        $layout['header'] = $this->CI->load->view('templates/header', $data, true);
        $layout['footer'] = $this->CI->load->view('templates/footer', null, true);

        $layout['content'] = $this->CI->load->view($content, null, true);
        ($page) ? $layout['page'] = $this->CI->load->view($page, null, true) : $layout['page'] = null;
        
        $this->CI->load->view('templates/layout', $layout);
    }

    public function showlogin($content = null, $data = null, $page = null) {
        $layout = array();

        $layout['header'] = $this->CI->load->view('templates/loginheader', $data, true);
        $layout['footer'] = $this->CI->load->view('templates/footer', null, true);

        $layout['content'] = $this->CI->load->view($content, null, true);
        ($page) ? $layout['page'] = $this->CI->load->view($page, null, true) : $layout['page'] = null;

        $this->CI->load->view('templates/layout', $layout);
    }

    public function showadmin($content = null, $data = null, $page = null) {
        $layout = array();

        $layout['header'] = $this->CI->load->view('templates/adminheader', $data, true);
        $layout['footer'] = $this->CI->load->view('templates/adminfooter', null, true);

        $layout['content'] = $this->CI->load->view($content, null, true);
        ($page) ? $layout['page'] = $this->CI->load->view($page, null, true) : $layout['page'] = null;

        $this->CI->load->view('templates/layout', $layout);
    }

    
}