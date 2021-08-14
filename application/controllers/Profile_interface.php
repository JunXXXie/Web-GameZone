<?php

class Profile_interface extends CI_Controller{
    public function index(){
        $this->load->view('nav');
        $this->load->helper('cookie');
        $this->load->model('Signup_model');
        $this->load->model('Upload_model');
        //Check login status. Session return false it cannot serach a value.
        $username = $this->session->userdata('username');
        $password = $this->session->userdata('password');
        $login_check = $this->Signup_model->login($username,$password);

        if($login_check == false){
            redirect(base_url().'Homepage');
        }else{

            $this->load->view('profile');

            $current_user = $this->session->userdata('username');
            $ids = $this->Upload_model->get_posts($current_user);
            $data = array("postids"=>$ids,
                            "titles" => $ids,
                            "types" => $ids,
                            "descriptions" => $ids,
                            "covers" => $ids,
                            );
            $amount = count($ids);
            $this->session->set_flashdata('no.',0);
            $num = $this->session->flashdata('no.');
            foreach($ids as $postid){

                if($num <$amount){
                    $this->session->set_userdata('videoid'.$num, $postid['postid']);
                    $this->session->set_userdata('title'.$num, $postid['title']);
                    $this->session->set_userdata('type'.$num, $postid['type']);
                    $this->session->set_userdata('description'.$num, $postid['description']);
                    $this->session->set_userdata('cover_posted'.$num, $postid['cover']);

                    $this->load->view('profile_posts');
                    $num = $num +1;
                    $this->session->set_flashdata('no.',$num);
                }
            }
            

            
        }

    }
    public function edit_info(){
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->model('Signup_model');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $data['username'] = $username;
        $data['email'] = $email;
        $data['phone'] = $phone;

        //send email verification code
        //check whether new input is null and same as before
        if($username != NULL && $email!=NULL){
            $email_exist = $this->Signup_model->check_email_exists($email);
            if($email_exist == $email){
                $this->session->set_flashdata('edit_err','Email exists already.');
                redirect(base_url().'Profile_interface');
            }else{
                if($username != $this->session->userdata('username')|| $email != $this->session->userdata('email') || $phone != $this->session->userdata('phone')){
                    $config = array();
                    $config['protocol'] = 'smtp';
                    $config['mailtype'] = 'html';
                    $config['charset'] = 'iso-8859-1';
                    $config['smtp_host'] = 'ssl://smtp.gmail.com';
                    $config['smtp_port'] = '465';
                    $config['smtp_user'] = 'jiedxie@gmail.com';
                    $config['smtp_pass'] = 'xieironexia';
    
                    //randome 6-digits verification code
                    $ver_code = random_string('numeric',6);
                    $this->session->set_userdata('ver_code_e',$ver_code);
                    $this->email->initialize($config);
                    $this->email->set_newline("\r\n"); 
                    $this->email->from('jiedxie@gmail.com', 'INFS7202 Project');
                    $this->email->to($this->session->userdata('email'));
                    $this->email->subject("The test of CodeIgniter's sending mail");
                    $this->email->message('This is a test email of the video project. Your 6-digits verification code for editing account information is: '.$ver_code);
                    if($this->email->send()){
                        $this->load->view('nav');
                        $this->load->view('email_ver_edit',$data);
                    }else{
                        $this->session->set_flashdata('edit_err','Invaild email.');
                        redirect(base_url().'Profile_interface');
                        
                    }
    
                }else{
                    
                    redirect(base_url().'Profile_interface');
                }
            }

            
        }else{
            $this->session->set_flashdata('edit_err','Username and email can not be null.');
            redirect(base_url().'Profile_interface');
        }
            


    }

    public function info_update(){
        $this->load->database();
        $this->load->model('Signup_model');
        $this->load->helper('form');
        $this->load->library('encryption');
        $input_code = $this->input->post('ver_code_edit');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $code_com = $this->session->userdata('ver_code_e');

        if($input_code == $code_com){
            //update inputs to database
            $this->Signup_model->profile_update($username,$email,$phone);
            if($username != $this->session->userdata('username')){
                //update uploader name from the post table
                $this->Signup_model->uploader_update($username,$this->session->userdata('username'));
            }
            //Renew account information to session
            $data = $this->Signup_model->get_acc_info($username);
            $this->session->set_userdata($data);
            

            $this->session->set_flashdata('saved','Saved!');
            redirect(base_url().'Profile_interface');
        }else{
            $this->session->set_flashdata('saved','Wrong verification code, update fail.');
            redirect(base_url().'Profile_interface');
        }
            
    }

    public function delete_post(){
        $this->load->helper('form');
        $this->load->database();
        $this->load->model('Videopg_model');
        $this->load->view('delete');
        $this->load->helper("file");

        $id = $_GET['id'];
        $cover = $_GET['cover'];
        //Delete post from database and edit history of the deleted post
        $this->Videopg_model->delete_post($id);

        //Delete uploaded file of this post
        unlink('uploads/images/'.$cover);
        unlink('uploads/videos/'.$id);
        redirect(base_url().'Profile_interface');

        
        
    }

}
?>