<link href="./css/user.css" rel="stylesheet">
<div class="login_popup">
    <div class ="sign_content">
        <div class="login_remind">
            <?php
                if(null !==  $this->session->flashdata('out')){
                    echo $this->session->flashdata('out');
                }else{
                    echo "Please login";
                }
            ?>
            
        </div>
    </div>
</div>