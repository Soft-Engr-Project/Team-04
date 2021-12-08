<?php

class Logouts extends CI_Controller{
    public function logout(){
        $this->session->unset_userdata(array('username','user_id','email','success','logged_in'));
        $this->session->sess_destroy();
        redirect("/");
    }

}



?>