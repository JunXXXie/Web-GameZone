<link href="<?=base_url().'css/user.css'?>" rel="stylesheet">

<div class="login_popup">
    <div class ="sign_content">
            <div class="sign_window_name">Update Information</div>
            <?php         
                echo form_open('Profile_interface/info_update');
                echo form_label('Email verification code:','ver_code_edit');
                echo form_input('ver_code_edit');
                echo form_hidden('username',$username);
                echo form_hidden('email',$email);
                echo form_hidden('phone',$phone);
                echo'<br>';

                ?>
            <div class="sign_submit">
                    <?php
                    echo form_submit('mysubmit', 'Confirm');
                    ?>
            </div>
    </div>
</div>