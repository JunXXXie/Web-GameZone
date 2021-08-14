<div class="post_comment">
    New comment:
    <div class="post_input">
    <?php
        echo form_close();
        echo form_open('Comment/new_comment');
        echo form_input('comment_content');
        echo form_hidden('postid',$this->session->flashdata('com_postid'));
        echo form_hidden('title',$_GET['data']);
        echo form_hidden('description',$_GET['intro']);
        echo form_hidden('ty',$_GET['ty']);
    ?>
    </div>

    
    <div class="post_btn">
        <?php
            echo form_submit('mysubmit','Post');
            echo form_close();
        ?>
    </div>

</div>
<style>
    .post_comment{
        font-size:1.3em;
        padding-top:5%;
    }
    .post_input input{
        height:fit-content;
        border:none;
        background-color:transparent;
        border:2px solid white;
        outline:none;
        width:100%;
        font-size:1em;
    }
    .post_btn input{
        padding:2%;
        color:white;
        border:2px solid white;
        border-radius:13px;
        background-color:transparent;
        margin-left:85%;
    }
    .post_btn input:hover{
        color:black;
        background-color:white;
    }
</style>