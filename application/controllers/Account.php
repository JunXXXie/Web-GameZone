<?php

class Account extends CI_Controller{

    public function login(){
        $this->load->helper('form');
        $this->load->model('Signup_model');
        $this->load->helper('cookie');
        $username = $this->input->post('username');
        $password = $this->input->post('pw');
        $remember = $this->input->post('remember');
        //check whether user have pick remember account

        //check whether input password is encrypted 'remember' password
            //If input password is same as 'remember' password, no need to encrypt again, else encrypt.
            if($password != $this->input->cookie('rem_password')){
                //Encrypt password which user used to login
                $password = $this->Signup_model->encrypt_pw($password);
            }
        
        //Prevent multiple accounts log in at the same time.
        if($this->session->userdata('username') == false){
            
                //Check valid input
                if ($username != Null && $password!= Null){
                    

                    //Check username and password in database.
                    $result = $this->Signup_model->login($username, $password);
                    if($result == true){
                        //Check whether user have pick remember me for future auto login
                        if($remember == true){
                            //set up cookie for username and password(for remember me option)
                            $cookie_username = array(
                                'name' => 'rem_username',
                                'value' => $username,
                                'expire' => time() + 1000*36000,
                            );
                            $cookie_password = array(
                                'name' => 'rem_password',
                                'value' => $password,
                                'expire' => time() + 1000*36000,
                            );
                            
                            set_cookie($cookie_password);
                            set_cookie($cookie_username);
                            
                        }else{//Untick the box this time and delete cookie information
                            delete_cookie('rem_username');
                            delete_cookie('rem_password'); 
                        }

                        
                        //Call function in signup_model which store logged in account to session
                        $data = $this->Signup_model->get_acc_info($username);

                        $this->session->set_userdata($data);
                        redirect(base_url().'Homepage');
                    }else{
                        //even info not correct, can still delete 'remember me' data.
                        if($remember != true){
                            delete_cookie('rem_username');
                            delete_cookie('rem_password'); 
                        }
                        $this->session->set_flashdata('logged',"Please make sure username and password are correct.");
                        redirect(base_url().'Homepage/login_window');
                    }
                }else{
                    $this->session->set_flashdata('logged',"Please make sure username and password are correct.");
                    redirect(base_url().'Homepage/login_window');
                }

        }else{
            $this->session->set_flashdata('logged',"You have logged in already. Please log out first if you want to log in a different account.");
            redirect(base_url().'Homepage/login_window');
        }

    }
    
    public function logout(){
        
        $this->load->helper('cookie');
        //Delete account information that have been stored.
        $this->session->unset_userdata('password'); 
        $this->session->unset_userdata('username'); 
        $this->session->unset_userdata('phone'); 
        $this->session->unset_userdata('email'); 
        $this->session->set_flashdata('out',"You have been logged out.");
        redirect(base_url().'Homepage');
        

    }

    public function signup(){
        $this->load->database();
        $this->load->model('Signup_model');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('string');

        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $password = $this->input->post('pw');
        $question = $this->input->post('question');
        $answer = $this->input->post('answer');

        


        //check username uniqueness and length
        if($username != NULL && $this->Signup_model->check_username_exists($username) != $username && strlen($username)<=20){
            //check email uniqueness
            if($email != NULL && $this->Signup_model->check_email_exists($email) != $email){
                    //check the strength of password
                    if($password!=Null&& strlen($password)>=6 && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)){
                        //Check necessary information.(Further instrustion need here)
                        if ($question!=Null && $answer != NULL){  
                            //send email
                            $config = array();
                            $config['protocol'] = 'smtp';
                            $config['mailtype'] = 'html';
                            $config['charset'] = 'iso-8859-1';
                            $config['smtp_host'] = 'ssl://smtp.gmail.com';
                            $config['smtp_port'] = '465';
                            $config['smtp_user'] = '';
                            $config['smtp_pass'] = '';

                            
                            //randome 6-digits verification code
                            $ver_code = random_string('numeric',6);
                            $this->session->set_userdata('ver_code',$ver_code);
                            $this->email->initialize($config);
                            $this->email->set_newline("\r\n"); 
                            $this->email->from('xxxxxx@email.com', 'Web Project');
                            $this->email->to($email);
                            $this->email->subject("The test of CodeIgniter's sending mail");
                            $this->email->message('This is a test email of the video project. Your 6-digits verification code for account setup is: '.$ver_code);
                            if($this->email->send()){

                                //Encrypt password before save to the database
                                $password = $this->Signup_model->encrypt_pw($password);

                                //For missing details, store 'none'.
                                if($phone == NULL){
                                    $phone = '0';
                                }
                                $this->session->set_userdata('sign_username',$username);
                                $this->session->set_userdata('sign_email',$email);
                                $this->session->set_userdata('sign_phone',$phone);
                                $this->session->set_userdata('sign_password',$password);
                                $this->session->set_userdata('sign_question',$question);
                                $this->session->set_userdata('sign_answer',$answer);
                                redirect(base_url().'Account/email_verify');
                                
                            }else{
                                $this->session->set_flashdata('email_invalid','Invalid email.');
                                redirect('Homepage/signup_window');
                            }


                        }else{
                            $this->session->set_flashdata('qa','Please set security question and answer.');
                            redirect('Homepage/signup_window');
                        }

                        


                    }else{
                        $this->session->set_flashdata('pw_weak','Password must contains letters and numbers.(length at least 6).');
                        redirect('Homepage/signup_window');
                    }

  
            }else{
                $this->session->set_flashdata('email_used','Email is missing or have been registered.');
                redirect('Homepage/signup_window');
            }
        }else{
            $this->session->set_flashdata('name_used','Username is missing or have been registered.');
            
            redirect('Homepage/signup_window');
        }
            

    }

    public function forgotpw(){
        $this->load->database();
        $this->load->model('Signup_model');
        $this->load->helper('form');
        $this->load->library('email');
        //Search preset secret question by username.
        $username = $this->input->post('username');
        $email = $this->input->post('email');
    
        $question = $this->Signup_model->find_q($username)[0]['question'];
        $database_email = $this->Signup_model->find_q($username)[0]['email'];
        if($username!=NULL && $question != NULL && $email == $database_email){
            //generate 6 digits verification code
            //send email
            $config = array();
            $config['protocol'] = 'smtp';
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_user'] = 'xxxxxx@email.com';
            $config['smtp_pass'] = '';

            
            //randome 6-digits verification code
            $ver_code = random_string('numeric',6);
            $this->session->set_userdata('ver_code_pw',$ver_code);
            $this->email->initialize($config);
            $this->email->set_newline("\r\n"); 
            $this->email->from('xxxxx@email.com', 'Web Project');
            $this->email->to($email);
            $this->email->subject("The test of CodeIgniter's sending mail");
            $this->email->message('This is a test email of the video project. Your 6-digits verification code for password reset is: '.$ver_code);
            if($this->email->send()){
                //Pass the secret question to View.
            $data['question'] = $question;
            $data['email'] = $email;
            $this->load->view('nav');
            $this->load->view('answer_q',$data);
            }else{
                $this->session->set_flashdata('invalid_name','Invaild information!');
                redirect(base_url().'Homepage/forgot_pw');
            }
            
        }else{
            $this->session->set_flashdata('invalid_name','Invaild information!');
            redirect(base_url().'Homepage/forgot_pw');
        }
         
    }
    //This function will check whether secret answer have bee answered correctly. Then update the password for processing account.
    public function check_reset_pw(){
        $this->load->database();
        $this->load->helper('form');
        $this->load->model('Signup_model');

        $answer = $this->input->post('answer');
        $code = $this->input->post('ver_code_pw');
        $password = $this->input->post('pw');
        $email = $this->input->post('email');
        if ($answer != Null && $code !=NULL && $password != NULL){
            //check the strength of password
            if($password!=Null&& strlen($password)>=6 && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)){
                //check the answer of secret question
                $result = $this->Signup_model-> ans_check($email,$answer);
                $code_com = $this->session->userdata('ver_code_pw');
                if($result == true && $code == $code_com){
                    //when answer is correct
                    $this->Signup_model->resetpw($password,$email);
                    $this->load->view('nav');
                    $done = true;
                }else{
                    $done = false;
                }
            }else{
                $weak = true;
            }
        }else{
            $done = false;
        }

        if($done == true){
            $this->session->set_flashdata('sign_pop',"Your password have been reset");
            redirect(base_url().'Homepage/login_window');
        }elseif($weak == true){
            $this->session->set_flashdata('logged',"Password must contains both numbers and letters, password length at least 6.");
            redirect(base_url().'Homepage/forgot_pw');
        }elseif($done == false){
            $this->session->set_flashdata('logged',"Fail to reset password, verification code or answer is wrong.");
            redirect(base_url().'Homepage/forgot_pw');
        }



        
    }
    //page of email code verification
    public function email_verify(){
        $this->load->view('nav');
        $this->load->view('email_ver');

    }

    public function email_code_check(){
        $this->load->database();
        $this->load->model('Signup_model');
        $info = $this->input->post('info');
        $input_code = $this->input->post('code');
        $ver_code = $this->session->userdata('ver_code');
        //match input code with real code
        if($input_code == $ver_code){
            $username = $this->session->userdata('sign_username');
            $email = $this->session->userdata('sign_email');
            $phone = $this->session->userdata('sign_phone');
            $password = $this->session->userdata('sign_password');
            $question = $this->session->userdata('sign_question');
            $answer = $this->session->userdata('sign_answer');
            //Add new account information to the database.
            $this->Signup_model->simple_insert($username,$email,$phone,$password,$question,$answer);
            $signup_done = true;
            $this->session->unset_userdata('sign_username');
            $this->session->unset_userdata('sign_email');
            $this->session->unset_userdata('sign_phone');
            $this->session->unset_userdata('sign_password');
            $this->session->unset_userdata('sign_question');
            $this->session->unset_userdata('sign_answer');
            $this->session->unset_userdata('ver_code');

        }else{
            $signup_done = false;
        }   


        if($signup_done == true){
            $this->session->set_flashdata('sign_pop',"You have sign up successfully!");
            redirect(base_url().'Homepage/login_window');
        }else{
            $this->session->set_flashdata('sign_pop',"Sign up fail, please fill all required information correctly");
            redirect(base_url().'Homepage/signup_window');
        }
       


    }

    
}
?>