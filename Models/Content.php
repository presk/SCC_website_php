<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');

class Content{
	
	private $id;
	private $user_id;
    private $type;
	private $content;
	private $post_time;

	public function __construct($user_id, $type, $content, $post_time){
		$this->user_id = $user_id;
        $this->type = $type;
		$this->content = $content;
		$this->post_time = $post_time;
    }

    /*Returns an array of Content objects that are a part of the Event*/
    public static function GetContentByEventId($id, $order = false){
    	$conn = DB::getInstance()->getConnection();

    	$query = "SELECT * FROM content WHERE content.id IN (SELECT content_id FROM event_content WHERE event_id = ?)";

        if($order){
        	$query .= " ORDER BY post_time ASC";
        }

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

		$queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$allContent = array();

		foreach ($queryResult as $content) {
			$c = new Content(
				$content['user_id'], 
				$content['type'], 
				$content['content'],
				$content['post_time']
			);

			$c->setId($content['id']);

			array_push($allContent, $c);
		}

		return $allContent;
    }

    /*Returns an array of Content objects that are a part of the Group*/
    public static function GetContentByGroupId($id, $order = false){
    	$conn = DB::getInstance()->getConnection();

    	$query = "SELECT * FROM content WHERE content.id IN (SELECT content_id FROM group_content WHERE group_id = ?)";

        if($order){
        	$query .= " ORDER BY post_time ASC";
        }

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

		$queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$allContent = array();

		foreach ($queryResult as $content) {
			$c = new Content(
				$content['user_id'], 
				$content['type'], 
				$content['content'],
				$content['post_time']
			);

			$c->setId($content['id']);

			array_push($allContent, $c);
		}

		return $allContent;
	}
	
	public static function GetContentByContentId($content_id){

		$conn = DB::getInstance()->getConnection();
		
		$query = "SELECT * FROM content WHERE content.id = ?";

        $stmt = $conn->prepare($query);

		$stmt->execute(array($content_id));

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$content_object = new Content($result['user_id'], $result['type'], $result['content'], $result['post_time']);

		$content_object->setId($content_id);

		return $content_object;
	}

	public static function DeleteContentByContentId($content_id){
		$conn = DB::getInstance()->getConnection();
		
		$query = "DELETE FROM content WHERE content.id = ?";

        $stmt = $conn->prepare($query);

		$stmt->execute(array($content_id));
	}

	/*Returns an array with all the content relevant to the userID passed, ordered by post_date*/
	public static function GetMainFeed($userID){
		$conn = DB::getInstance()->getConnection();

    	$query = "SELECT * FROM content WHERE 
		(content.id IN (SELECT content_id FROM group_content WHERE group_id IN (SELECT group_id FROM group_participants WHERE user_id = ?))) 
		OR 
		(content.id IN (SELECT content_id FROM event_content WHERE event_id IN ( SELECT event_id FROM event_participants WHERE user_id = ?)))
		ORDER BY post_time ASC";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($userID, $userID));

		$queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$mainFeed = array();

		foreach ($queryResult as $content) {
			$c = new Content(
				$content['user_id'], 
				$content['type'], 
				$content['content'],
				$content['post_time']
			);

			$c->setId($content['id']);

			array_push($mainFeed, $c);
		}

		return $mainFeed;
	}

	/*Need this for deleting content related to groups when we delete groups. Content is not caught by the ON CASCADE because of the relation tables*/
	public static function DeleteContentByGroupId($groupID){
		$conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare("DELETE FROM content WHERE content.id IN (SELECT content_id from group_content WHERE group_id = ?)");
		$stmt->execute(array($groupID));
	}

	public static function DeleteContentByEventId($eventID){
		$conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare("DELETE FROM content WHERE content.id IN (SELECT content_id from event_content WHERE event_id = ?)");
		$stmt->execute(array($eventID));
	}

    /*Getters and setters*/
    public function getId(){
    	return $this->id;
    }

    public function getUserId(){
    	return $this->user_id;
    }

    public function getTypeContent(){
        return $this->type;
    }

    public function getContent(){
    	return $this->content;
    }

    public function getPostTime(){
    	return $this->post_time;
    }
	
    public function setId($id){
    	$this->id = $id;
    }

	public function setTypeContent($type){
		$this->type = $type;
	}
	
	public function setContent($content){
		$this->content = $content;
	}
	
	public function setPostTime($post_time){
		$this->post_time = $post_time;
	}
}