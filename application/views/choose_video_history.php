<?php
    //get all postid of viewed post
    
    $history_postid = $this->Videopg_model->get_history($this->session->userdata('username'));
    $viewed_id_list = explode(',',$history_postid);
    $viewed_amount = count($viewed_id_list);
    if($viewed_amount>0){
        //get all info by using postid
    $all_viewed_post = $this->Upload_model->preview_history($history_postid,$viewed_amount);
    for($i=$viewed_amount-2;$i>-1;$i--){
        $preview = '
                    <a href="'.base_url().'/Play_video/index?data='.$all_viewed_post[$i]['title'].'&id='.$all_viewed_post[$i]['postid'].'&intro='.$all_viewed_post[$i]['description'].'&up='.$all_viewed_post[$i]['uploader'].'&ty='.$all_viewed_post[$i]['type'].'">
                    <div class="preview_section">
                        <img src="../uploads/images/'.$all_viewed_post[$i]['cover'].'" class = "preview_pic">
                        </a>
                        <div class="title">'.$all_viewed_post[$i]['title'].' </div>
                    </div>
                        
                    ';
        echo $preview;
    }

    }
    

?>

<style>
.preview_section{
    text-align: center;
    margin-left:4%;
    margin-top: 2%;

    height:250px;
    width:20%;
    position:relative;
    background-color:rgb(217, 216, 215);
    border-radius:12px;
    overflow:hidden;



}
.preview_pic{

    max-width:100%;
    height:90%;
    overflow:hidden;
    justify-content:center;


}
.title{
    font-size:20px;
    border-top:1px solid black;
}


</style>