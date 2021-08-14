<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Video extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('url','html','form')); 
    }

    public function index(){
        $this->load->model('Signup_model');
        //Check login status. Session return false it cannot serach a value.
        $username = $this->session->userdata('username');
        $password = $this->session->userdata('password');
        $login_check = $this->Signup_model->login($username,$password);

        if($login_check == false){
            redirect('Homepage');
        }else{
            $this->load->view('nav');
            $this->load->view('upload_view');

            

        }
        
    }

    public function post_info(){
        $this->load->view('nav');
        
        $this->load->view('post_video_info_bg');
             
            
    }

    public function upload_video(){
        $this->load->library('encryption');
        if($this->input->post('upload') != NULL){
            $data = array();

            // Count total files
            $countfiles = count($_FILES['userfile']['name']);

            for($i=0;$i<$countfiles;$i++){
                if(!empty($_FILES['userfile']['name'][$i])){
                     // Define new $_FILES array - $_FILES['file']
                    $_FILES['file']['name'] = $_FILES['userfile']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['userfile']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['userfile']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['userfile']['size'][$i];

                    $config['upload_path'] = FCPATH.'uploads/videos/';
                    $config['allowed_types'] = 'mp4|webm|flv';
                    $config['max_size'] = '502400';
                    //change video name to a uniquie ID by adding timestamp
                    $get_name = $_FILES['userfile']['name'][$i];
                    $filename_part = explode('.',$get_name)[0];
                    $pattern = "/[\\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:\<\>,\.\?\\\]/";
                    if(preg_match($pattern, $filename_part)){
                        $justname = explode('.',$get_name);
                        $newname = random_string('numeric',8);

                        $get_name = $newname.'.'.$justname[1];
                    }
                    $video_id = 'V'.time().$get_name;
                    $config['file_name'] = $video_id;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $upload_data = array();
            

                    if($this->upload->do_upload('file')) {
                        //data of upload file
                        $upload_data =  $this->upload->data();
                        $data['video_name'] = $upload_data['file_name'];
                        
                        $all_videos_name = $all_videos_name.$get_name.', ';
                        
                        
                        
                    }else{
                        
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error',$error);
                    }
                    $this->session->set_flashdata('videoID'.$i, $video_id);
                    $this->session->set_userdata('upload_count',$i+1);
                }

            } 

            $this->session->set_flashdata('upload_file', $all_videos_name);
            redirect(base_url().'Video/post_info');
            
            
        }  
    }


    public function new_post(){

        $this->load->database();
        $this->load->model('Upload_model');
        $this->load->helper('form');
        $this->load->library('upload');



        $post_amount = $this->session->userdata('upload_count');
        //get input value for multiple posts
        for($i=1; $i <= $post_amount; $i++){
            
            $postid = $this->session->userdata('postid'.$i);
            $title =  $this->input->post('post_title'.$i);
            $uploader = $this->session->userdata('username');
            $type =  $this->input->post('type'.$i);
            $description = $this->input->post('description'.$i);
            $coverid = $this->session->userdata('coverimage'.$i);


            if($postid != null && $title != null && $uploader != null && $type != null && $description != null && $coverid != null){
                //Add post information to database
                $this->Upload_model->upload_post_info($postid,$title,$uploader,$type,$description,$coverid);
                $title_list = $title_list.'Video ID: '.$postid.'  Title: '.$title.', ';
                $this->session->set_flashdata('postcount',$title_list.'have been posted');

            }else{
                $this->session->set_flashdata('post_error', $postid.' Post fail. Please fill all information correctly.');
                redirect(base_url().'Video');
            }
            
            
            
        }
        redirect(base_url().'Video');
    }




    



}



?>