<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Drag_images extends CI_Controller{
     public function index(){
        $this->load->view('nav');
        $this->load->view('dragfile');
     }

     //Drag file upload
    public function dragfileUpload(){
      $this->load->database();
      $this->load->model('Upload_model');
      $this->load->helper('form');
       
      if(!empty($_FILES['file']['name'])){

          // Set preference
          $config['upload_path'] =FCPATH.'uploads/images/'; 
          $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
          $config['max_size'] = '10000'; // max_size in kb
          $filename = $_FILES['file']['name'];
          $pattern = "/[\\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:\<\>,\.\?\\\]/";
          if(preg_match($pattern, $filename)){
              $justname = explode('.',$filename);
              $newname = random_string('numeric',8);

              $filename = $newname.'.'.$justname[1];
          }
          $image_post_name = 'P'.time().$filename;
          $this->session->set_userdata($image_post_name,$image_post_name);
          $config['file_name'] = $image_post_name;
     
          //Load upload library
          $this->load->library('upload',$config); 
     
          // File upload
          if($this->upload->do_upload('file')){
            // Get data about the file
            $uploadData = $this->upload->data();
          }
          //Send information of uploaded images to database
            $i = $this->session->flashdata('imamge_order');
            $imageid = $this->session->userdata($image_post_name);
            
            $amount = $this->session->userdata('upload_count');
            $count = $this->session->userdata('orderlist');

          if($count <= $amount){

            $this->session->set_userdata('coverimage'.$count,$imageid);
            
            $count = $count+1;
            $this->session->set_userdata('orderlist',$count);
          }

         
      }

      //Overlay watermark  images
      $imgConfig = array();
                        
      $imgConfig['image_library'] = 'GD2';
                              
      $imgConfig['source_image']  = './uploads/images/'.$image_post_name;
      $imgConfig['wm_type']       = 'overlay';    
                              
      $imgConfig['wm_overlay_path'] = './images/watermark.jpg';
      $imgConfig['wm_vrt_alignment'] = 'top';
      $imgConfig['wm_hor_alignment'] = 'left';
      $imgConfig['wm_opacity'] = 100;
                              
      $this->load->library('image_lib', $imgConfig);
                              
      $this->image_lib->initialize($imgConfig);
                              
      $this->image_lib->watermark(); 

      


    }
}