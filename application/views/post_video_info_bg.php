<div class="post_info_bg">
    <div class="drag">
        <?php
            $this->session->set_userdata('orderlist',1);
            //Using for loop to list all upload item and input section for each of it
            $videos_count = $this->session->userdata('upload_count');
            $this->load->view('dragfile');
        ?>
    </div>
    <div class="info_list">
        <?php

            if($videos_count > 0){
                for($i = 0; $i< $videos_count; $i++){
                    echo '<div class="each_post">' ;   
                    $this->session->set_flashdata('posted_video_name', $this->session->flashdata('videoID'.$i));
                    $this->session->set_flashdata('post_num',$i+1);
                    $this->load->view('upload_file_info');
                    echo '</div>';
                } 
                $this->load->view('post_but');
            }

        ?>
    </div>

</div>

<style>
.post_info_bg{
    background-image: url("../images/login_bg.jpg");
    background-size: cover;
    padding-bottom:2%;
    min-height:90%;
    height:auto;
}
.drag{
    background-image:url("../images/color_bg.jpg");
    padding:2%;
    background-size: cover;
}
.info_list{

}
.each_post{

    margin-top:0.6%;
    background-image: url("../images/homebg.png");
    color:white;
}
.post_info_bg input[type=submit]{
    border:2px solid white;
    height:5.2%;
    padding:1%;
    width:5.5%;
    border-radius:15px;
    background-color:transparent;
    color: white;
    font-size:1em;
    font-weight:bold;
}
.post_info_bg input[type=submit]:hover{
    background-color:white;
    color:black;

}
</style>