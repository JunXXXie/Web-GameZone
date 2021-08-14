<link href="<?=base_url().'css/playing_view_style.css'?>" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="whole_view">
    <div class="post">

        <div class="video_title">
        
            <?php
                //record postid to the viewd history
                if($this->Videopg_model->get_history($this->session->userdata('username')) != null){
                    $history_list = $this->Videopg_model->get_history($this->session->userdata('username'));
                    //if already added current postid to session
                    if(strpos($history_list,$_GET['id']) !== false){
                        $new_list = str_replace($_GET['id'].',','',$history_list);
                        $new_list = $new_list.$_GET['id'].',';
                        $this->Videopg_model->update_history($this->session->userdata('username'),$new_list);
                    }else{
                        $new_history_list = $history_list.$_GET['id'].',';
                        $this->Videopg_model->update_history($this->session->userdata('username'),$new_history_list);
                    }

                }else{
                    $this->Videopg_model->update_history($this->session->userdata('username'),$_GET['id'].',');
                }

                $video_title = $_GET['data'];
                echo $video_title;

            ?>
        </div>

        <div class="type">
            - <?php echo $_GET['ty'].' ';?>game 
        </div>

        <div class="video_section">
            <video   controls>
                <source src="../uploads/videos/<?php echo $_GET['id']; ?>" type="video/mp4" />
            </video>
        </div>

        <div class="info_card">
            <div class="uploader">
                Post by: 
                <?php
                    echo $_GET['up'];
                ?>
            </div>
            <div class="intro_like">
                <div class="video_intro"> 
                    <?php echo $_GET['intro'];?>
                </div>

                <div class="like" id="like">

                    <?php
                        //check whether user have liked this post
                        $user = $this->session->userdata('username');
                        $check = $this->Videopg_model->liked_check($_GET['id'],$user);
                        if($check == true){
                            //when user already liked the video
                            echo form_open('Play_video/cancel_like',array('class' => 'like_form'));
                            echo form_hidden('postid',$_GET['id']);
                            echo form_hidden('title',$_GET['data']);
                            echo form_hidden('description',$_GET['intro']);
                            echo form_hidden('uploader',$_GET['up']);
                            echo form_hidden('ty',$_GET['ty']);
                            echo form_submit('mysubmit', 'favorite',array('id' => 'btn_liked','class'=>'material-icons'));
                            echo '<br>';

                        }else{
                            //when user havent like the video
                            //Using icon as an submit button, submit postid of the current page to the get like function in controller

                            echo form_open('Play_video/like_button');
                            echo form_hidden('postid',$_GET['id']);
                            echo form_hidden('title',$_GET['data']);
                            echo form_hidden('description',$_GET['intro']);
                            echo form_hidden('uploader',$_GET['up']);
                            echo form_hidden('ty',$_GET['ty']);
                            echo form_submit('mysubmit', 'favorite',array('id' => 'btn_like','class'=>'material-icons'));
                            echo '<br>';

                        }
                        //show how many likes this post have got
                        //get the likes count from database
                    

                    ?>
                    <div id="num_likes">
                        <?php echo $likes_amount; ?>
                    </div>
                
                </div>

            </div>
            
            <!-- like and share button -->
            

            <!-- Some recommend video base on user's habits -->
            <div class="recommend">
                Recommend videos
                <div class="recommend_posts">
                <!-- post recommendation to user base on their visit record -->
                    <?php
                        echo $this->session->userdata('recommend_list'); 
                        //get the data of user's visit preference
                        $record_list = $this->Videopg_model->get_preference($user);
                        //get total viewed count
                        $total_viewed = $this->Videopg_model->get_viewed($user);
                        $each_type = explode(',',$record_list);
                        $type_amount = count($each_type) -1;
                        //get all recorded type from $each_type array
                        $num_array = [];
                        for($i=0;$i<$type_amount;$i++){
                            $substr = explode(':',$each_type[$i]);
                            $num_array[$i] = $substr[1];
                            
                        }
                        //Using algorithm to get 8 recommendations 
                        //calculate the percenage of each type of game. Adding the original percentage of each type on itself, then recommend a random post of the type which is equal or greater than 1.
                        $recommend_amount = 12;
                        $para = $recommend_amount +1;
                        for($k=0;$k<$para;$k++){
                            
                            for($p=0;$p<$type_amount;$p++){
                                if($k<$para){
                                    $num_array[$p] = $num_array[$p]+$num_array[$p];

                                    if($num_array[$p] >= 1){
                                        //get all post of this type
                                        //get the type
                                        $type = explode(':',$each_type[$p])[0];
                                        $type_allposts = $this->Videopg_model->type_posts($type);
                                        $randpost = $type_allposts[rand(0,count($type_allposts)-1)];
                                        //check whether the choosen random post have been recommened
                                        if(null !== $this->session->userdata('recommend_list')){
                                            //session exists
                                            
                                            $recommended = $this->session->userdata('recommend_list');
                                            //check recommended record
                                            if(strpos($recommended ,$randpost['postid']) !== false){
                                                //recorded
                                                $can = false;
                                            }else{
                                                //no record
                                                $new_list = $recommended.$randpost['postid'];
                                                //update session
                                                $this->session->set_userdata('recommend_list',$new_list);
                                                $can = true;
                                            }
                                            
                                            
                                        }else{
                                            //session not exist
                                            $this->session->set_userdata('recommend_list',$randpost['postid']);
                                            $can = true;
                                        }
                                        if($can == true){
                                            $cover = $randpost['cover'];
                                            $title = $randpost['title'];
                                            $postid = $randpost['postid'];
                                            $description = $randpost['description'];
                                            $uploader = $randpost['uploader'];
                                            $preview = '
                                                <a href="/milestone/Play_video/index?data='.$title.'&id='.$postid.'&intro='.$description.'&up='.$uploader.'&ty='.$type.'">
                                                <div class="preview_section">
                                                    <img src="../uploads/images/'.$cover.'" class = "preview_pic">
                                                    </a>
                                                    <div class="title">'.$title.' </div>
                                                </div>
                                                
                                                ';
                                            
                                            echo $preview;
                                            //reset percentage of this type
                                            $num_array[$p] = explode(':',$each_type[$p])[1];
                                            $k++;
                                        }
                                        
                                    }else{
                                        
                                    }

                                }
                                
                                
                            
                            }


                        }
                        //unset the recommended list before going to other playing views
                        $this->session->unset_userdata('recommend_list');

                    ?>
                </div>
            </div>

        </div>

    </div>

    <!--Comment area, right hand side if the page. -->
    <div class="comments">
        <div class="com_title">
            Comment:
        </div>
    
        <div class="comment_list">
            <?php 
                $this->session->set_flashdata('com_postid',$_GET['id']);
                //check whether this post have any comment. 
                //Display exists comment
                if(null !== $this->Videopg_model->exists_comment($_GET['id']) ){
                    $exist = $this->Videopg_model->exists_comment($_GET['id']);
                    $comment_amount = count($exist);
                    
                    for($c=0;$c<$comment_amount;$c++){
                        echo "
                        <div class='each_comment'>
                            <div class='comment_user'>"
                                .$exist[$c]['post_user'].
                            " :</div>
                            <div class='comment_content'>"
                                .$exist[$c]['content'].
                            "</div>
                        ";
                        $data['commentid'] = $exist[$c]['commentid'];
                        if($exist[$c]['reply_content'] !=null){
                            $replyer_list = explode(',',$exist[$c]['reply_user']);
                            $reply_list = explode('~`~',$exist[$c]['reply_content']);
                            $reply_count = count($reply_list);
                            for($r=0;$r<$reply_count-1;$r++){
                                echo '
                                    <div class="each_reply">
                                        <div class="reply_content">'
                                            .$replyer_list[$r].': '.$reply_list[$r].
                                        '</div>                                  
                                    </div>                                   
                                    ';

                            }
                        }
                        $this->load->view('reply_btn',$data);
                        
                        echo "</div>";
                        
                    }
                }
                
                
            ?>   
        </div>
        
        <?php
            $this->load->view('post_comment');
        ?>



    </div>


</div>




<style>
    /*style in css file*/
</style>

<script>
    //loading current like status and likes count 
     //$(document).ready(function(){
         //$("#like").click(function(){
             //$("#num_likes").load("#num_likes");
             //$("#btn_liked").load("#btn_liked");
             //$("#btn_like").load("#btn_like");
       //});
     //});
    // $(docuement).ready(function(){
    //     $(".btn_liked").click(function(){
    //         $("#current_likes").load("current_likes");
    //     });
    // });
</script>