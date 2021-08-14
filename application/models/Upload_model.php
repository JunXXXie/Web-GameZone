<?php
class Upload_model extends CI_Model{
    //function that upload post information to database
    public function upload_post_info($postid,$title,$uploader,$type,$description,$coverid){
        $data = array(
            'postid' => $postid,
            'title' =>  $title,
            'uploader'    =>  $uploader,
            'type'  =>  $type,
            'description'    =>  $description,
            'cover'   =>  $coverid
        );

        $this->db->insert('post',$data);
    }

    //function that save the image ID and uploader name to database
    public function posted_imageid($cover){



        $amount = $this->session->userdata('upload_count');
        $count = $this->session->userdata('orderlist');

        if($count <= $amount){
            $postid = $this->session->userdata('postid'.$count);
            $this->db->where('cover',$cover);
            $this->db->where('postid', $postid);
            $sql = "UPDATE post SET cover = ? WHERE postid = ?";
            $query = $this->db->query($sql,array($cover,$postid));


            $count = $count+1;
            $this->session->set_userdata('orderlist',$count);
        }




    }
    //Get all post ID of current user
    public function get_posts($current_user){
        $sql = "SELECT * FROM post WHERE uploader = ?";
        $query = $this->db->query($sql,array($current_user));
        
        return $query->result_array();

    }

    //Get all title from all user for search bar
    public function get_all_titles($postData){
        $respone = array();
        if($postData['search']){
            $this->db->select('title');
            $this->db->where("title like '%".$postData['search']."%' ");
            $records = $this->db->get('post')->result();

            foreach($records as $row){
            $response[] = array("label" => $row->title);
            }
        }
        
        return $response;

    }

    //Get all videos for preview
    public function get_preview_title(){
        $sql = "SELECT * FROM post ORDER BY likes_count";
        $query = $this->db->query($sql,array());
        
        return $query->result_array();
    }

    //get video description name with video id
    public function find_videoid($videoid){
        $sql = "SELECT description FROM post WHERE postid = ?" ;
        $query = $this->db->query($sql,array($videoid));

        return $query->result_array();


    }
    
    //get post information for viewed post
    public function preview_history($history_postid, $viewed_amount){
        $viewed_id_list = explode(',',$history_postid);
        for($i=0;$i<$viewed_amount-1;$i++){
            $sql = "SELECT * FROM post WHERE postid = ?" ;
            $query = $this->db->query($sql,array($viewed_id_list[$i]));
            $data[$i] = $query->result_array()[0];
        }
        return $data;
    }



}


?>