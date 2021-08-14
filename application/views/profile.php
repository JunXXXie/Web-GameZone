
<link href="<?=base_url().'css/profilepage.css'?>" rel="stylesheet">
<div class="profile_section">
    <div class="profile_title">Profile</div>

    <div class="greeting">
        <?php
            echo '<br>';
            echo "Hello, ". $this->session->userdata('username').'.';
        ?>
    </div>

    <div class="acc_info">-Basic information

        <?php
            echo '<br>';
            echo form_open('Profile_interface/edit_info');
            echo '<br>';

            echo form_label('Username: ', 'username');
            echo form_input('username', $this->session->userdata('username'));
            echo '<br>';

            echo form_label('Email:', 'email');
            echo form_input('email',$this->session->userdata('email'));
            echo '<br>';

            echo form_label('Phone:', 'phone');
            echo form_input('phone',$this->session->userdata('phone'));
            echo '<br>';
            echo '<br>';
            echo $this->session->flashdata('saved');
            $submit_id = array(
                'id' => 'subid'
            );
            echo $this->session->flashdata('edit_err');
            
            echo '<br>';
            echo form_submit('mysubmit', 'Save',$submit_id);
        ?>
            
            
        
    </div>
</div>