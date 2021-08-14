<link href="<?=base_url().'css/user.css'?>" rel="stylesheet">

<div class="sign_section">
        <?php
        if(null !== $this->session->flashdata('sign_pop')){
                echo '<div class="pop">'.$this->session->flashdata('sign_pop').'</div>';
        }
        ?>
        <div class ="sign_content">
                <div class="sign_window_name">Sign up</div>
                <?php
                echo'<br>';
                echo form_open('Account/signup');
                echo form_label('Your username*:','username');
                echo form_input('username');
                echo'<br>';

                echo form_label('Your email*:','email');
                echo form_input('email');
                echo '<br>';

                echo form_label('Your phone number:','phone');
                echo form_input('phone');
                echo '<br>';

                echo form_label('Password*:', 'pw');
                echo form_password('pw');
                echo '<br>';

                echo form_label('Set your secret question*:', 'question');
                echo form_input('question');
                echo '<br>';
                echo form_label('Answer*:', 'answer');
                echo form_input('answer');
                echo '<br>'."(* are the information that have to be filled)";
                echo '<br>';
                echo '<br>';
                echo $this->session->flashdata('name_used');
                echo $this->session->flashdata('email_used');
                echo $this->session->flashdata('pw_weak');
                echo $this->session->flashdata('email_invalid');
                echo $this->session->flashdata('qa');
                echo '<br>';
                ?>
                <div class="sign_submit">
                        <?php
                        echo form_submit('mysubmit', 'Submit');
                        ?>
                </div>
        </div>
</div>


                

