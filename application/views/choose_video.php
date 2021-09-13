
        <?php 

            $all_posts = $this->Upload_model->get_preview_title();
            $amount = count($all_posts);
            $data = array("postids"=> $all_posts,
                            "titles" => $all_posts,
                            "uploaders" => $all_posts,
                            "covers" => $all_posts,
                            "types" => $all_posts,
                            "descriptions"  => $all_posts,
                            "count" => $amount
                            );

            for($i = $amount-1; $i>=0;$i--){
                $each_post = $all_posts[$i];
                $cover = $each_post['cover'];
                $title = $each_post['title'];
                $postid = $each_post['postid'];
                $description = $each_post['description'];
                $uploader = $each_post['uploader'];
                $type = $each_post['type'];
                //save current url
                $preview = '
                        <a href="'.base_url().'/Play_video/index?data='.$title.'&id='.$postid.'&intro='.$description.'&up='.$uploader.'&ty='.$type.'">
                        <div class="preview_section">
                            <img src="uploads/images/'.$cover.'" class = "preview_pic">
                            </a>
                            <div class="title">'.$title.' </div>
                        </div>
                        
                    ';
                echo $preview;
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