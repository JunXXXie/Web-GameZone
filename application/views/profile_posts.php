<div class="posted_content">
    <?php
        echo "Post ID： ".$this->session->userdata('videoid'.$this->session->flashdata('no.'));
        $id = $this->session->userdata('videoid'.$this->session->flashdata('no.'));
        $de_cover = $this->session->userdata('cover_posted'.$this->session->flashdata('no.'));
    ?>

    <div class="video_section" >
        <video   controls >
            <source src="uploads/videos/<?php echo $this->session->userdata('videoid'.$this->session->flashdata('no.')); ?>" type="video/mp4" />
        </video>
    </div>

    <div class="info">
        <?php
            echo "Title: ".$this->session->userdata('title'.$this->session->flashdata('no.'));
            echo '<br>';
            echo '<br>';
            echo "Type: ".$this->session->userdata('type'.$this->session->flashdata('no.'));
            echo '<br>';
            echo '<br>';
            echo "Description: ".$this->session->userdata('description'.$this->session->flashdata('no.'));
            echo '<br>';
            echo '<br>';
           
            
        ?>

       
    </div>

    <div class="cover_section">
        <?php

            echo "Cover: ";
            echo '<br>';
            ?>
            <img src="uploads/images/<?php echo $this->session->userdata('cover_posted'.$this->session->flashdata('no.')); ?>" class = "cover_pic">

            
            <button class="delete">
                <a href="<?=base_url()?>Profile_interface/delete_post?id=<?php echo $id;?>&cover=<?php echo $de_cover; ?>">
                    Delete
                </a>
            </button>
            
    </div>
    

</div>
<style>
    .video_section{

        margin-top: 2%;
    }
    .video_section video{
        width:650px;
        height:350px;
        margin-bottom: 10px;
    }

    .posted_content{
        border: 2px solid black;
        margin-top: 6px;
        display:flex;
        z-index:-1;
        height:45%;
        background-image:url('./images/homebg.png');
        background-repeat: no-repeat;
        background-size: cover;
        color: white;
        font-size:1.2em;
        
    }
    .postid{
        margin-left:7%;
    }
    .info{
        margin-top:3%;
        margin-bottom:4%;
        margin-left:5%;
        width:20%;
        padding-left:20px;
        padding-top:10px;
        border-left:2px solid black;

    }
    .cover_pic{
        
        height:300px;
        width:500px;
    }
    .cover_section{
        margin-top:2%;
        float:right;
        margin-right:10px;
    }
    .delete{
        float:right;
        margin-top:5%;
        margin-right:3%;
        border:none;
        background-color: #DC143C;
        padding:10px;
        
    }
    .delete a{
        text-decoration: none;
        color:white;
    }
   
</style>

<script>

</script>