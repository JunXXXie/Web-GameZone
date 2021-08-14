<?php
class Signup_model extends CI_Model {

    public function first_query(){

    }
    
    public function find_q($username){
        $sql = "SELECT question,email FROM user WHERE username = ?";
        $query = $this->db->query($sql,array($username));

        return $query->result_array();
        
    }

    public function ans_check($email,$answer){
        $sql = "SELECT answer FROM user WHERE email = ?";
        $query = $this->db->query($sql,array($email));

        foreach($query->result_array() as $row){
            if ($row['answer'] == NULL){
                return false;
                
            }else{
                return true;
            }
        }

    }

    public function resetpw($password,$email){
        $this->db->where('email',$email);
        $this->db->where('password', $password);
        //Encrypt password
        $password = $this->Signup_model->encrypt_pw($password);
        $sql = "UPDATE user SET password = ? WHERE email = ?";
        $query = $this->db->query($sql,array($password,$email));

    }


    public function simple_insert($username,$email,$phone, $password,$question,$answer){
        $this->load->library('encryption');
        
        $data = array(
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'question' => $question,
            'answer' => $answer
        );
        $this->db->insert('user', $data);
        
    }

    // Log in
		public function login($username, $password){
            $this->load->library('encryption');
            //Decrypt input password
            $password =  $this->encryption->decrypt($password);
			// Validate
            $sql = "SELECT * FROM user WHERE username = ?";
            $query = $this->db->query($sql,array($username));

            foreach($query->result_array() as $row){
                $database_pw = $row['password'];
                //Decrypt database password to match with type in password
                $database_pw = $this->encryption->decrypt($database_pw);
                if ($database_pw!=NULL && $password == $database_pw){
                    return true;
                    
                }else{
                    return false;
                }
            }
            
		}

    // Check whether sign up username exists already
    public function check_username_exists($username){
        $sql = "SELECT username FROM user WHERE username = ?";
        $query = $this->db->query($sql,array($username));
        foreach($query->result_array() as $row){
            $data_name = $row['username'];
            return $data_name;
        }
    }
    // Check whether sign up email exists already
    public function check_email_exists($email){
        $sql = "SELECT email FROM user WHERE email = ?";
        $query = $this->db->query($sql,array($email));
        foreach($query->result_array() as $row){
            $data = $row['email'];
            return $data;
        }
    }


    //Get account's phone number and email by using matched uername, and save array to session
    public function get_acc_info($username){
        
        $sql = "SELECT  phone,email,username,password FROM user WHERE username = ?";
        $query = $this->db->query($sql,array($username));
        foreach($query->result_array() as $row){
            $phone = $row['phone'];
            $email = $row['email'];
            $username = $row['username'];
            $password = $row['password'];
            
        }
        return $user_array = array(
            'username' => $username,
            'phone' => $phone,
            'email' => $email,
            'password' => $password
        );
        
        
    }

    //Update the logged in account's uername, phone and email.---Profile page.
    public function profile_update($username,$email,$phone){
        $logged_acc = $this->session->userdata('username');
        $sql = "UPDATE user SET username = ?, phone = ?, email = ? WHERE username = ?";
        $query = $this->db->query($sql,array($username, $phone,$email,$logged_acc));
    }

    //Update uploader name if the username have been change
    public function uploader_update($new_username,$old_username){
        $sql = "UPDATE post SET uploader = ? WHERE uploader = ?";
        $query = $this->db->query($sql,array($new_username,$old_username));
    }


    //Encryption
    public function encrypt_pw($password){
        $this->load->library('encryption');
        $password = $this->encryption->encrypt($password);
        return $password;

    }
}
?>