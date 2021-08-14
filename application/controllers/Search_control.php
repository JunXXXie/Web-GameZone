<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_control extends CI_Controller {


    public function __construct(){

        parent::__construct();
        $this->load->helper('url');
    
        // Load model
        $this->load->model('Upload_model');
    
    }

    public function index(){

        $this->load->view('autocomplete') ;

    }

    public function list(){

        //Post data
        $postData = $this->input->post();

        //get data
        $data = $this->Upload_model->get_all_titles($postData);

        echo json_encode($data);

    }

    public function search_post(){
        $this->load->model('Videopg_model');
        $title = $this->input->post('search_post');
        $data = array(
            'title' => $title
        );

        $this->load->view('nav');
        $this->load->view('after_search',$data);
    }



}


?>