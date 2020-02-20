<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');

class Message{
	private $id;
	private $source_id;
	private $dest_id;
	private $text;
    private $sent_time;
    private $soft_delete;
    private $archive_delete;

	public function __construct($source_id, $dest_id, $text, $sent_time, $soft_delete, $archive_delete){
		$this->source_id = $source_id;
		$this->dest_id = $dest_id;
		$this->text = $text;
        $this->sent_time = $sent_time;
        $this->soft_delete = $soft_delete;
        $this->archive_delete = $archive_delete;
    }

    /*Send the instance of the object to the DB*/
    public function save(){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO messages(source_id, dest_id, message_text, sent_time) VALUES (?, ?, ?, ?)");

        $stmt->execute(array($this->source_id, $this->dest_id, $this->text, $this->sent_time));
    }

    /*Returns an array of Messages received by the user with the passed id
    when order is true, will return ordered by ASC sent_date*/
    public static function GetReceivedMessagesByUserId($id, $order = false){
        $conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM messages WHERE dest_id = ?";

        if($order){
            $query .= " ORDER BY sent_time ASC";
        }

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $messages = array();

        foreach ($queryResult as $row) {
            $m = new Message(
                $row['source_id'], 
                $row['dest_id'], 
                $row['message_text'],
                $row['sent_time'],
                $row['soft_delete'],
                $row['archive_delete']
            );

            $m->setId($row['id']);

            array_push($messages, $m);
        }

        return $messages;
    }

    /*Returns an array of Messages sent by the user with the passed id
    when order is true, will return ordered by asc sent_date*/
    public static function GetSentMessagesByUserId($id, $order = false){
        $conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM messages WHERE source_id = ?";

        if($order){
            $query .= " ORDER BY sent_time ASC";
        }

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $messages = array();

        foreach ($queryResult as $row) {
            $m = new Message(
                $row['source_id'], 
                $row['dest_id'], 
                $row['message_text'],
                $row['sent_time'],
                $row['soft_delete'],
                $row['archive_delete']
            );

            $m->setId($row['id']);

            array_push($messages, $m);
        }

        return $messages;
    }

    /*Add a message to the db, without instancing an object*/
    public static function InsertMessage($source_id, $dest_id, $text){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO messages(source_id, dest_id, message_text, sent_time) VALUES (?, ?, ?, ?)");

        $stmt->execute(array($source_id, $dest_id, $text, date('Y-m-d H:i:s')));
    }

    /* Permanent deletion */
    public static function DeleteMessage($message_id){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");

        $stmt->execute(array($message_id));
    }

    //Better deletion methods
    public static function SoftDelete($message_id){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("UPDATE messages SET soft_delete = TRUE WHERE id = ?");

        $stmt->execute(array($message_id));
    }

    public static function ArchiveDelete($message_id){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("UPDATE messages SET archive_delete = TRUE WHERE id = ?");

        $stmt->execute(array($message_id));
    }
    

    /*Getters and setters*/
    public function getSoftDelete(){
        return $this->soft_delete;
    }

    public function getArchiveDelete(){
        return $this->archive_delete;
    }

    public function getId(){
    	return $this->id;
    }

    public function getSourceId(){
    	return $this->source_id;
    }

    public function getDestId(){
    	return $this->dest_id;
    }

    public function getText(){
    	return $this->text;
    }

    public function getSentTime(){
    	return $this->sent_time;
    }
	
	public function setText($text){
		$this->text = $text;
	}

    public function setId($id){
        $this->id = $id;
    }
}