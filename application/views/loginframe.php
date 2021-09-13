<link href="../css/user.css" rel="stylesheet">




<div class="login_popup">
<?php
    if(null !== $this->session->flashdata('logged')){
        echo '<div class="pop">'.$this->session->userdata('logged').'</div>';
    }
    if(null !== $this->session->flashdata('sign_pop')){
        echo '<div class="pop_correct">'.$this->session->flashdata('sign_pop').'</div>';
    }
?>
    <div class ="login_content">
        <div class="login_window_name">Login</div>

        <!--Login function-->
        <div class="login_username">
            <?php 
                echo'<br>';
                echo form_open('Account/login');
                echo form_label('Username:','username');
                echo '  ';
                echo form_input('username',$this->input->cookie('rem_username'));
                echo'<br>';

                echo form_label('Password:  ', 'pw');
                echo '  ';
                echo form_password('pw',$this->input->cookie('rem_password'));
                echo '<br>';
            ?>
        </div>
            </br><input type="checkbox" name="remember" value=true
            <?php
                if($this->input->cookie('rem_username') != NULL){
                    echo "checked";
                }
             ?>>Remember me</br>
            
            <div class="formsub">
            <?php 
                echo '<br>';
                echo form_submit('mysubmit', 'Submit'); 
            ?>
            </div>

        
        <!--Sign up function-->
        <button class="signup_button">
            <a href="<?=base_url()?>Homepage/signup_window">Sign up</a>
        </button>
        <!-- Forgot password-->
        <a class = "forgot" href="<?=base_url()?>Homepage/forgot_pw">Forgot password</a>

    </div>
</div>