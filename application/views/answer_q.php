<link href="<?=base_url().'css/user.css'?>" rel="stylesheet">

<div class="login_popup">
    <div class ="sign_content">
            <div class="sign_window_name">Reset Password</div>
            <?php
            
                echo "Secure question: ".$question;
                
                echo form_open('Account/check_reset_pw');

                echo form_label('Email verification code:','ver_code_pw');
                echo form_input('ver_code_pw');
                echo'<br>';

                echo form_label('Answer:','answer');
                echo form_input('answer');
                echo'<br>';
                echo form_hidden('email',$email);
                echo form_label('New password:', 'pw');
                echo form_password('pw');
                echo '<br>';
                ?>
            <div class="sign_submit">
                    <?php
                    echo form_submit('mysubmit', 'Submit');
                    ?>
            </div>
    </div>
</div>