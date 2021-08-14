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
<div class ="sign_content">
        <div class="sign_window_name">Forgot Password</div>
        <?php
                echo form_open('Account/forgotpw');
                echo form_label('Your username:','username');
                echo form_input('username');
                echo'<br>';
                echo form_label('Your email:','email');
                echo form_input('email');
                echo'<br>';
                echo $this->session->flashdata('invalid_name');
                echo'<br>';
        ?>
        <div class="sign_submit">
                <?php
                echo form_submit('mysubmit', 'Submit');
                ?>
        </div>
</div>