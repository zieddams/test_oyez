<?php

class Post{
       // Refer to database connection
       private $db;

       public function __construct($db_conn)
       {
           $this->db = $db_conn;
       }
       
       public function save_new_question($creator_id,$content){
        try{        
            $sql = "INSERT INTO post(creator_id, content) VALUES(:creator_id, :content)";
            $query = $db_conn->prepare($sql);
            $query->bindParam(':creator_id', $creator_id);
            $query->bindParam(':content', $content); 
            $query->execute();
            }
            catch (PDOException $e) {
                array_push($errors, $e->getMessage());
            }
       }
       public function getAllquestions(){
           $query = $this->db->query("SELECT * FROM post");
            return $query;
       }
       public function save_answer($post_id,$ans,$creator_id){
        try {
            $sql = "INSERT INTO post(creator_id,content,post_id) VALUES(:creator_id, :content, :post_id)";
            $query = $this->db->prepare($sql);
            $query->bindParam(":creator_id", $creator_id);
            $query->bindParam(":content", $ans);
            $query->bindParam(":post_id", $post_id);
            /* echo var_dump( $query); */
            $query->execute();
        }
        catch (PDOException $e) {
           return $e->getMessage();
        }
       }
       public function getAllans($post_id){
           $q = "SELECT * FROM answer WHERE post_id=:post_id";
           $query = $this->db->prepare($q);
           $query->bindParam(':post_id',$post_id);
           $query->execute();
           return $query;
       }
}