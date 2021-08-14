<?php

class Homepage extends CI_Controller{

    public function index(){
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->model('Upload_model');
        
        //variable that show username in when logged in, otherwise present 'log in'.
        $login_check = $this->session->userdata('username');
        if($login_check == false){
            $this->session->set_userdata('status','Log in');
            $this->load->view('nav');
            $this->load->view('login_remind');
        }else{
            $this->session->set_userdata('status',$login_check);
            $this->load->view('nav');

            $all_posts = $this->Upload_model->get_preview_title();
            $amount = count($all_posts);
            $data = array("postids"=> $all_posts,
                            "titles" => $all_posts,
                            "covers" => $all_posts,
                            "count" => $amount
                            );
            

            for($i = 0; $i<$amount;$i++){
                $each_post = $all_posts[$i];
                $info = array(  "postid"=> $each_post['postid'],
                                "title" => $each_post['title'],
                                "cover" => $each_post['cover'],
                                "count" => $amount
                              );
                
            }

            $this->load->view('choose_bg');

            
        }

        
    }
    public function login_window(){
        $this->load->helper('form');
        $this->load->view('nav');
        $this->load->view('loginframe');
    }
    public function signup_window(){
        $this->load->view('nav');
        $this->load->view('signup');
    }
    public function forgot_pw(){
        $this->load->view('nav');
        $this->load->view('forgotpw');
    }  

    public function history_pg(){
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->model('Upload_model');
        $this->load->model('Videopg_model');
        
        $this->load->view('nav');
        $this->load->view('choose_bg_history');

            
        
    }

   

}






?>