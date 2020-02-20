<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');

class Group{

	private $id;
	private $event_id;
	private $manager_id;
	private $name;
	private $description;

	public function __construct($event_id, $manager_id, $name, $description){

		$this->event_id = intval($event_id);
		$this->manager_id = intval($manager_id);
		$this->name = $name;
		$this->description = $description;
	
	}

    public function getId(){
    	return $this->id;
    }

    public function getEventId(){
    	return $this->event_id;
    }

    public function getManagerId(){
    	return $this->manager_id;
    }

    public function getName(){
    	return $this->name;
    }

    public function getDescription(){
    	return $this->description;
	}



	public function save(){

		$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO user_groups (event_id, manager_id, group_name, group_description) VALUES (?, ?, ?, ?)");

        $stmt->execute(array($this->event_id, $this->manager_id, $this->name, $this->description));
		
	}

	public static function GetGroupById($groupID){

		$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user_groups WHERE id = ?");

        $stmt->execute(array($groupID));

		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$returnGroup = new Group($results['event_id'], $results['manager_id'], $results['group_name'], $results['group_description']);
		
		$returnGroup->setId($results['id']);

		return $returnGroup;
	}
	
	public static function GetAllGroups(){

        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user_groups");

        $stmt->execute();

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$groupArry = [];
		
		foreach($results as $value){

			$groupToInsert = new Group($value['event_id'], $value['manager_id'], $value['group_name'], $value['group_description']);
			$groupToInsert->setId($value['id']);
			$groupArray[] = $groupToInsert;
		}

		return $groupArray;
        
    }
	
    public static function AddUserToGroupById($userId, $groupId){
    	$conn = DB::getInstance()->getConnection();

    	$stmt = $conn->prepare("INSERT INTO group_participants VALUES (?, ?)");

    	$stmt->execute(array($userId, $groupId));
    }


	public function setName($name){
		$this->name = $name;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	/*Returns an array of user_groups that are a part of the passed event*/
	public static function GetGroupByEventID($eventID){
		$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user_groups WHERE event_id = ?");

        $stmt->execute(array($eventID));

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$user_groups = array();
		
		foreach($results as $row){
			$g = new Group($row['event_id'], $row['manager_id'], $row['group_name'], $row['group_description']);
			$g->setId($row['id']);
			array_push($user_groups, $g);
		}

		return $user_groups;
	}

	/*Returns an array of group objects in which the user is participating*/
	public static function GetGroupsByUserId($userID){
       	$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user_groups WHERE user_groups.id IN (SELECT group_id FROM group_participants WHERE user_id = ?)");

        $stmt->execute(array($userID));

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$user_groups = array();
		
		foreach($results as $row){
			$g = new Group($row['event_id'], $row['manager_id'], $row['group_name'], $row['group_description']);
			$g->setId($row['id']);
			array_push($user_groups, $g);
		}

		return $user_groups;
	}

	/*Returns an array of user_groups that the passed userID is managing*/
	public static function GetAllUserManagedGroups($userID){
		$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user_groups WHERE manager_id = ?");

        $stmt->execute(array($userID));

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$user_groups = array();
		
		foreach($results as $row){
			$g = new Group($row['event_id'], $row['manager_id'], $row['group_name'], $row['group_description']);
			$g->setId($row['id']);
			array_push($user_groups, $g);
		}

		return $user_groups;
	}

	public static function LeaveGroup($userID, $groupID){
		$sql = "DELETE FROM group_participants WHERE user_id = ? AND group_id = ?";

		$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->execute([$userID, $groupID]);
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

	public static function DeleteGroupById($group_id){
		Content::DeleteContentByGroupId($group_id);

		$sql = "DELETE FROM user_groups WHERE id = ?";

		$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->execute([$group_id]);

	}

	//
	//Group Content Section
	//
	public static function GetAllGroupContentByGroupId($group_id){
		
		$sql = "SELECT DISTINCT users.username, content.type, content.content, content.post_time FROM users, content, group_content, user_groups WHERE ? = group_content.group_id AND group_content.content_id = content.id AND content.user_id = users.id ORDER BY post_time ASC;";

		$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->execute([$group_id]);

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $results;
	}

	public static function InsertContentByGroupId($user_id, $group_id, $content, $content_type, $content_post_time){
		
		$sql = "INSERT INTO content (user_id, type, content, post_time) VALUES (?, ?, ?, ?)";

		$sql_2 = "INSERT INTO group_content (group_id, content_id) VALUES (?,
					(SELECT id FROM content ORDER BY id DESC LIMIT 1))";

		$conn = DB::getInstance()->getConnection();

		$stmt = $conn->prepare($sql);
		
		$stmt_2 = $conn->prepare($sql_2);

		$stmt->execute([$user_id, $content_type, $content, $content_post_time]);
		
		$stmt_2->execute([$group_id]);

	}
}