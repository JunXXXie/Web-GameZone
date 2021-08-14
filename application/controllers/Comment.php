<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comment extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('url','html','form')); 
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->database();
        $this->load->model('Videopg_model');
    }

    public function index(){

    }
    public function new_comment(){
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->database();
        $this->load->model('Videopg_model');
        //save new comment to database
        $postid = $this->input->post('postid');
        $post_user = $this->session->userdata('username');
        $comment_content = $this->input->post('comment_content');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $type = $this->input->post('ty');
        $test = $this->Videopg_model->new_comment($postid,$post_user,$comment_content);
        if($test == true){
            redirect(base_url()."Play_video/index?data=$title&id=$postid&intro=$description&up=$post_user&ty=$type");
        }else{
            echo 'something wrong in database.';
        }
        
    }

    public function reply(){
        $commentid = $this->input->post('commentid');
        $replyer = $this->input->post('replyer');
        $reply_content = $this->input->post('reply_input');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $type = $this->input->post('ty');
        $postid = $this->input->post('postid');
        $up = $this->input->post('uploader');
        //update reply information to database
        $this->Videopg_model->add_reply($commentid,$replyer,$reply_content);
        redirect(base_url()."Play_video/index?data=$title&id=$postid&intro=$description&up=$up&ty=$type");
        
    }
    




}


?>