
<div class="bg">
    <div class="content">
        <div class="upload_title">Videos Upload</div>
        <?php echo form_open_multipart('Video/upload_video');?>
        <div class="upload_section">
        <input type="file" name="userfile[]" multiple="multiple" id="input_button"/>
        <br>
        <input type="submit" value="upload" name = 'upload' id="upload_button"/>
        <br>
        </div>
        <?php 
            $uploaded = $this->session->flashdata('upload_file');
            
            $error = $this->session->flashdata('error');
            if($uploaded != NULL){
                echo '<div class="flash">'.$uploaded.' have been upload.</div>';
            }
            if(null !== $this->session->flashdata('filename_err')){
                echo '<div class="flash">'.$this->session->flashdata('filename_err').'</div>';
            }
            
            echo $error;
            //inform user the number of successful posts
            echo '<div class="flash">'.$this->session->flashdata('postcount').'</div>';
            echo '<br>';
            echo '<br>';
            //inform user if post is fail
            echo '<div class="flash">'.$this->session->flashdata('post_error').'</div>';

        ?>
    </div>

</div>
<style>
.bg{
    background-image: url("./images/login_bg.jpg");
    width:auto;
    height:95%;
    opacity: 0.9;
    background-size: cover;
    padding:0.2%;

}
.upload_title{
    font-size:1.5em;
    margin:1.2%;
    color:white;
    font-size:2.3em;
}
.upload_section{
    margin-left:25%;
    margin-top:3%;
    height: fit-content;
    width:60%;
}
.content{
    border: 2px solid black;
    background-color: rgb(56, 92, 140);
    width:90%;
    margin-left:5%;
    margin-top:2%;
    
}
#input_button{

    font-size:1.2em;
    color:white;
}

#upload_button{
    font-size:1.2em;
    margin-top:3%;
    background-color: transparent;
    border: 2px solid white;
    color: white;
    padding:7px;
    width:9%;
    border-radius:15px;
    margin-left:60%;
}
#upload_button:hover{
    background-color:white;
    color:black;
}
.flash{
    margin-top:1%;
    font-size:1.1em;
    margin-left:1.2%;
    color:white;
}
</style>
