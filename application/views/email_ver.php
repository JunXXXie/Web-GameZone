
<link href="../css/user.css" rel="stylesheet">
<?php


?>
<div class="login_popup">
<div class ="sign_content">
        <div class="sign_window_name">Verification</div>
        <?php
        echo '<br>';
        //type in the verification code.Save info to database if email code match.
        echo form_open('Account/email_code_check');
        echo form_label('6-digits verification code that have been sent to your registered email:','code');
        echo '<br>';
        echo form_input('code');
        ?>
        <div class="sign_submit">
            <?php
            echo form_submit('mysubmit', 'Confirm');
            ?>
        </div>

</div>