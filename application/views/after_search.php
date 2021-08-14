<div class="search_result">
    <?php 

        $all_posts =  $this->Videopg_model->search_post($title);
        $amount = count($all_posts);
        $data = array("postids"=> $all_posts,
                        "titles" => $all_posts,
                        "uploaders" => $all_posts,
                        "covers" => $all_posts,
                        "types" => $all_posts,
                        "descriptions"  => $all_posts,
                        "count" => $amount
                        );

        for($i = 0; $i<$amount;$i++){
            $each_post = $all_posts[$i];
            $cover = $each_post['cover'];
            $title = $each_post['title'];
            $postid = $each_post['postid'];
            $description = $each_post['description'];
            $uploader = $each_post['uploader'];
            $type = $each_post['type'];
            $num = $i+1;
    ?>
    <div class="index">
        <?php echo 'Search result '.$num.': '; ?>
    </div>
    
    <?php        
            //save current url
            $preview = '
                    <a href="/milestone/Play_video/index?data='.$title.'&id='.$postid.'&intro='.$description.'&up='.$uploader.'&ty='.$type.'">
                    <div class="preview_section">
                        <img src="'.base_url().'uploads/images/'.$cover.'" class = "preview_pic">
                        </a>
                        <div class="title">'.$title.' </div>
                    </div>
                    ';
            echo $preview;
        }

    ?>
</div>

<style>
.preview_section{
    text-align: center;
    margin-left:4%;
    height:250px;
    width:20%;
    position:relative;
    background-color:rgb(217, 216, 215);
    border-radius:12px;
    overflow:hidden;
    margin-bottom:2%;



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
    font-size:1.3em;
}
.search_result{
    border:2px solid black;
    background-image:url('../images/homebg.png');
    background-repeat: no-repeat;
    background-size: cover;
    min-height:91.2%;

}
.index{
    color:white;
    font-size:1.3em;
    margin-top:0.5%;
}

</style>