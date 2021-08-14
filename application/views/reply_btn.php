<div class="reply_btn">

    <div class="type">
    <?php
        echo form_close();
        echo form_open('Comment/reply');
        echo form_label('Reply: ','reply_input');
        echo form_input('reply_input');
        echo form_hidden('commentid',$commentid);
        echo form_hidden('replyer',$this->session->userdata('username'));
        echo form_hidden('postid',$this->session->flashdata('com_postid'));
        echo form_hidden('title',$_GET['data']);
        echo form_hidden('description',$_GET['intro']);
        echo form_hidden('ty',$_GET['ty']);
        echo form_hidden('uploader',$_GET['up']);

    ?>
    </div>
    
    <div class="btn">
        <?php
            echo form_submit('mysubmit','Reply');
            echo form_close();
        ?>
    </div>
</div>

<style>
    .reply_btn{
        padding:0%;
        font-size:0.8em;
    }
    .type input{
        height:1.8%;
        border:none;
        background-color:transparent;
        border-bottom:2px solid white;
        outline:none;
        width:68%;
        font-size:1em;
        margin-top:5%;
    }
    .btn input{
        padding:2%;
        color:white;
        border:2px solid white;
        border-radius:13px;
        background-color:transparent;
        margin-left:87%;
        margin-top:-14%;
    }
    .btn input:hover{
        color:black;
        background-color:white;
    }
</style>