<div class="bg">


    <?php
            error_reporting(0);
            ini_set('display_errors', 0);
            $this->load->view('choose_video_history');
        
    ?>

</div>

<style>
    .bg{
        display:flex;
        justify-content:flex-start;
        flex-direction: row;
        flex-wrap:wrap;
        background-image:url('../images/homebg.png');
        background-repeat: no-repeat;
        background-size: cover;
        min-height:91.2%;
    }

</style>