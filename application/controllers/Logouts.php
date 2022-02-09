<?php

class Logouts extends CI_Controller
{
    public function logout()
    {   $isLog = array("isLogin" => 0);
        $this->user_model->isLogin($this->session->userdata("user_id"),$isLog);
        $this->session->unset_userdata(array('username', 'user_id', 'email', 'success', 'logged_in'));
        $this->session->sess_destroy();
        redirect("/");
    }
    public function admin_logout()
    {   
        $this->session->sess_destroy();
        redirect("/");
    }
}

