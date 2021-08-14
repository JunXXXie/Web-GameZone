<html>

    <div class="videoinfo">
        <?php 
            echo '<br>';
            echo 'Video ID: ';
            $id = $this->session->flashdata('posted_video_name');
            echo $id;
            $i = $this->session->flashdata('post_num');
            $this->session->set_userdata('postid'.$i, $id);
            echo '<br>';
            echo form_open_multipart('Video/new_post');
            echo form_label('Title:','post_title'.$i);
            echo form_input('post_title'.$i);
            echo'<br>';
            echo '<br>';
            
            echo form_label('Tyeps:', 'type'.$i);
            $options = array(
                'action'         => 'Action',
                'adventure'      => 'Adventure',
                'role'         => 'Role-playing',
                'simulation'        => 'Simulation',
                'strategy'         => 'Strategy',
                'sport'         => 'Sports',
                'puzzle'         => 'Puzzle',
                'idle'         => 'Idle',
            );
            
            echo form_dropdown('type'.$i,$options,'', 'class="types"');
            echo '<br>';
            echo '<br>';

            echo form_label('Description:','description'.$i);
            $description = array(
                'name' => 'description'.$i,
                'id'    =>  'description'.$i,
                'maxlength' =>  '200',
                'style' =>  'height:6%;
                            width:15%;
                             vertical-align:text-top;'
                             
            );
            echo form_input($description);
            echo '<br>';

            
            
            ?>


            
            

        
    </div>
    

</html>

<style>
.videoinfo{
    margin-left:15%;
    width: 150%;
    font-size:1.2em;
    padding:1%;
}
.videoinfo input{
    background-color:transparent;
    border:2px solid white;
    border-bottom:2px solid white;
    font-size:1em;
    height:3.5%;
    margin-left:1.5%;
    wrap:wrap;
}
.types{
    background-color:transparent;
    height:5%;
    width:auto;
    font-size:0.8em;
    margin-left:1%;
    border-radius:15px;
    border:1px solid white;
    font-weight:bold;
}
.types:hover{
    background-color:rgb(107, 107, 107);
    color:white;
    font-weight:bold;
}
</style>