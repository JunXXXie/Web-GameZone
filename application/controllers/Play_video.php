<?php

class Play_video extends CI_Controller{



    public function index(){
        $this->load->database();
        $this->load->model('Videopg_model');
        $this->load->model('Upload_model');
        
        //get the current likes amount
        $likes_amount = $this->Videopg_model->likes_got($_GET['id']);
        $data['likes_amount'] = $likes_amount;

       

        //Save view history to databse
        // get type preference from database
        $user = $this->session->userdata('username');
        $preference = $this->Videopg_model->get_preference($user);
        //get the total viewed amount
        $viewed = $this->Videopg_model->get_viewed($user);

        if(strpos($preference,$_GET['ty'])!==false){
            //check whether the current type exits in the list already
            $listed_type = explode(',',$preference);
            $count = count($listed_type);
            $added = false;
            $list='';
            for($i = 0; $i<$count-1;$i++){
                $substr = explode(':',$listed_type[$i]);
                $amount = $substr[1];
                $type = $substr[0];
                if($type == $_GET['ty']){
                    $amount = $amount +1;
                    $new = $_GET['ty'].':'.$amount.',';
                    $list = $list.$new;
                }else{ 
                    $list = $list.$listed_type[$i].',';
                }
            
            }
        }else{
            $list = $preference.$_GET['ty'].':1,';
        }
           
            
        //total viewed amount plus 1
        $viewed = $viewed + 1;
        //update to database
        $this->Videopg_model->update_type_viewed($list,$viewed,$user);

       
        
         //load views
         $this->load->view('nav');
         $this->load->view('playing_view',$data);
    }

    //give like to the post
    public function like_button(){
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->database();
        $this->load->model('Videopg_model');
        $postid = $this->input->post('postid');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $uploader = $this->input->post('uploader');
        $type = $this->input->post('ty');
        $user = $this->session->userdata('username');
        $this->Videopg_model->givelike($postid,$user);
        redirect(base_url()."Play_video/index?data=$title&id=$postid&intro=$description&up=$uploader&ty=$type");
    }
    
    //cancel like
    public function cancel_like(){
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->database();
        $this->load->model('Videopg_model');
        $postid = $this->input->post('postid');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $uploader = $this->input->post('uploader');
        $type = $this->input->post('ty');
        $user = $this->session->userdata('username');
        $this->Videopg_model->droplike($postid,$user);
        redirect(base_url()."Play_video/index?data=$title&id=$postid&intro=$description&up=$uploader&ty=$type");
    }
}


?>