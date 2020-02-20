<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');

class ContentComments{

    private $id;
    private $content_id;
    private $user_id;
    private $comment_text;
    private $post_time;

    public function __construct($content_id, $user_id, $comment_text, $post_time){
        $this->content_id = $content_id;
        $this->user_id = $user_id;
        $this->comment_text = $comment_text;
        $this->post_time = $post_time;
    }

    /*Inserts the instance of the object in the DB*/
    public function save(){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO content_comments(content_id, user_id, comment_text, post_time) VALUES (?, ?, ?, ?)");

        $stmt->execute(array($this->content_id, $this->user_id, $this->comment_text, $this->post_time));
    }


    /*Returns an array of ContentComments objects
    If order is true, will order ASC*/
    public static function GetCommentsByContentId($id, $order = false){
        
        $conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM content_comments WHERE content_id = ?";

        if($order){
            $query .= " ORDER BY post_time ASC";
        }

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $comments = array();

        foreach ($queryResult as $comment) {
            $c = new ContentComments(
                $comment['content_id'], 
                $comment['user_id'], 
                $comment['comment_text'],
                $comment['post_time']
            );

            $c->setId($comment['id']);

            array_push($comments, $c);
        }

        return $comments;
    }

    /*Inserts a comment with the current time as the timestamp*/
    public static function InsertComment($content_id, $user_id, $comment_text){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO content_comments(content_id, user_id, comment_text, post_time) VALUES (?, ?, ?, ?)");

        $stmt->execute(array($content_id, $user_id, $comment_text, date('Y-m-d H:i:s')));
    }

    public static function DeleteCommentByCommentId($comment_id){

        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("DELETE FROM content_comments WHERE id = ?");

        $stmt->execute(array($comment_id));

    }

    /*Getters and setters*/

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of content_id
     */ 
    public function getContent_id()
    {
        return $this->content_id;
    }

    /**
     * Set the value of content_id
     *
     * @return  self
     */ 
    public function setContent_id($content_id)
    {
        $this->content_id = $content_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of comment_text
     */ 
    public function getComment_text()
    {
        return $this->comment_text;
    }

    /**
     * Set the value of comment_text
     *
     * @return  self
     */ 
    public function setComment_text($comment_text)
    {
        $this->comment_text = $comment_text;

        return $this;
    }

    public function getCommentPostTime(){
        return $this->post_time;
    }
}

?>