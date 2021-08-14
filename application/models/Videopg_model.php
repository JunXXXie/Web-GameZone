<?php
class Videopg_model extends CI_Model{

    public function givelike($postid,$user){
        //get the current likes amount and liked accounts of the current post
        $sql = "SELECT likes_count,liked_accounts  FROM post WHERE postid = ?";
        $query = $this->db->query($sql,array($postid));
        $get = $query->result_array();
        $row = $get[0];
        $old_list = $row['liked_accounts'];

        //increase likes count by one and add username to the list
        $likes_count = $row['likes_count'] +1;
        $liked_accounts = $old_list.$user.',';

        //updata new likes count and list to database
        $sql = "UPDATE post SET likes_count = ?, liked_accounts = ?WHERE postid = ?";
        $query = $this->db->query($sql,array($likes_count, $liked_accounts,$postid));

    }

    public function droplike($postid,$user){
        //get the current likes amount and liked accounts of the current post
        $sql = "SELECT likes_count,liked_accounts  FROM post WHERE postid = ?";
        $query = $this->db->query($sql,array($postid));
        $get = $query->result_array();
        $row = $get[0];
        //decrease likes count by one and add username to the list
        $likes_count = $row['likes_count'] -1;
        $old_list = $row['liked_accounts'];
        $new_list = str_replace($user.',','',$old_list);

       
        //updata new likes count and list to database
        $sql = "UPDATE post SET likes_count = ?, liked_accounts = ?WHERE postid = ?";
        $query = $this->db->query($sql,array($likes_count, $new_list,$postid));
    }


    public function likes_got($postid){
        $sql = "SELECT likes_count  FROM post WHERE postid = ?";
        $query = $this->db->query($sql,array($postid));
        $result = $query->result_array();
        $likes = $result[0]['likes_count'];
        return $likes;
    }

    public function liked_check($postid,$user){
        $sql = "SELECT liked_accounts  FROM post WHERE postid = ?";
        $query = $this->db->query($sql,array($postid));
        $list = $query->result_array()[0]['liked_accounts'];
        $liked_account = explode(',',$list);
        $count = count($liked_account);
        for($i=0;$i<$count;$i++){
            if(strpos($list,$user) !== false){
                return true;
            }else{
                return false;
            }
        }
    }

    public function search_post($title){
        $sql = "SELECT *  FROM post WHERE title = ?";
        $query = $this->db->query($sql,array($title));
        return $query->result_array();
    }

    public function delete_post($postid){
        $sql = "DELETE FROM post WHERE postid = ?";
        $query = $this->db->query($sql,array($postid));
        //edit history of the deleted post
        $sql = "SELECT * FROM user";
        $query = $this->db->query($sql,array());
        $result = $query->result_array();
        $all_user_amount = count($result);
        for($i = 0; $i < $all_user_amount;$i++){
            $history_list = $result[$i]['history'];
            if(strpos($history_list,$postid.',') !== false){
                $history_list = str_replace($postid.',','',$history_list);
            }
            //updata history list
            $sql = "UPDATE user SET history = ? WHERE username = ?";
            $query = $this->db->query($sql,array($history_list,$result[$i]['username']));
        }

        return true;

    }

    public function get_preference($user){
        $sql = "SELECT type_preference FROM user WHERE username = ?";
        $query = $this->db->query($sql,array($user));
        $result = $query->result_array()[0]['type_preference'];
        return $result;
    }

    public function get_viewed($user){
        $sql = "SELECT viewed FROM user WHERE username = ?";
        $query = $this->db->query($sql,array($user));
        $result = $query->result_array()[0]['viewed'];
        return $result;
    }

    public function update_type_viewed($list,$viewed,$user){
        $sql = "UPDATE user SET type_preference = ?, viewed = ? WHERE username = ?";
        $query = $this->db->query($sql,array($list,$viewed,$user));

    }

    public function type_posts($type){
        $sql = "SELECT * FROM post WHERE type = ?";
        $query = $this->db->query($sql,array($type));
        return $query->result_array();
    }

    //check exists of comment
    public function exists_comment($postid){
        $sql = "SELECT * FROM comment WHERE postid = ?";
        $query = $this->db->query($sql,array($postid));
        return $query->result_array();
    }

    //post new comment
    public function new_comment($postid,$post_user,$comment_content){
        $comment_id = time().$post_user;
        $sql = "INSERT INTO comment VALUES(?,?,?,?,?,?)";

        $query = $this->db->query($sql,array($comment_id,$postid,$post_user,$comment_content,null,null));
        return true;
    }
    //add reply for specific comment
    public function add_reply($commentid,$replyer,$reply_content){
        //get exists reply info
        $sql = "SELECT reply_user,reply_content FROM comment WHERE commentid = ?";
        $query = $this->db->query($sql,array($commentid));
        $cur_replyer_list = $query->result_array()[0]['reply_user'];
        $cur_reply_list = $query->result_array()[0]['reply_content'];
        $new_replyer_list = $cur_replyer_list.$replyer.',';
        $new_reply_list = $cur_reply_list.$reply_content.'~`~';
        $sql = "UPDATE comment SET reply_user = ?, reply_content = ? WHERE commentid = ?";
        $query = $this->db->query($sql,array($new_replyer_list,$new_reply_list,$commentid));
    }

    //get account's view history
    public function get_history($username){
        $sql = "SELECT history FROM user WHERE username = ?";
        $query = $this->db->query($sql,array($username));
        $history = $query->result_array()[0]['history'];
        return $history;
    }
    //update viewed history
    public function update_history($username,$history_list){
        $sql = "UPDATE user SET history = ? WHERE username = ?";
        $query = $this->db->query($sql,array($history_list,$username));
    }



}
?>