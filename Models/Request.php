<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Group.php');

class Request{
	private $id;
	private $source_id;
	private $dest_id;
	private $group_id;
	private $type;
	private $status;


	public function __construct($source_id, $dest_id, $group_id, $type, $status){
		$this->source_id = $source_id;
		$this->dest_id = $dest_id;
		$this->group_id = $group_id;
		$this->type = $type;
		$this->status = $status;
    }

    /*Send the instance of the object to the DB*/
    public function save(){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO requests(source_id, dest_id, group_id, request_type, request_status) VALUES (?, ?, ?, ?, ?)");

        $stmt->execute(array($this->source_id, $this->dest_id, $this->group_id, $this->type, $this->status));
    }


    /*Set request status to 1 and user to the group*/
    public function accept(){
        $conn = DB::getInstance()->getConnection();

        $userId = $this->source_id;
        $query = "UPDATE requests SET request_status = ? WHERE source_id = ?";

        if($this->type === "invite"){
            $userId = $this->dest_id;
            $query = "UPDATE requests SET request_status = ? WHERE dest_id = ?";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute(array(1, $userId));

        Group::AddUserToGroupById($userId, $this->group_id);
    }

    /*Get unhandled sent requests*/
    public static function GetRequestsBySourceId($id){
        $conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM requests WHERE source_id = ? AND request_status = 0";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $requests = array();

        foreach ($queryResult as $row) {
            $r = new Request(
                $row['source_id'], 
                $row['dest_id'], 
                $row['group_id'],
                $row['request_type'],
                $row['request_status']
            );

            $r->setId($row['id']);

            array_push($requests, $r);
        }

        return $requests;
    }

    /*Get unhandled received requests*/
    public static function GetRequestByDestId($id){
        $conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM requests WHERE dest_id = ? AND request_status = 0";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $requests = array();

        foreach ($queryResult as $row) {
            $r = new Request(
                $row['source_id'], 
                $row['dest_id'], 
                $row['group_id'],
                $row['request_type'],
                $row['request_status']
            );

            $r->setId($row['id']);

            array_push($requests, $r);
        }

        return $requests;
    }

    /*Static insert*/
    public static function InsertRequest($source_id, $dest_id, $group_id, $type, $status){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO requests(source_id, dest_id, group_id, request_type, request_status) VALUES (?, ?, ?, ?, ?)");

        $stmt->execute(array($source_id, $dest_id, $group_id, $type, $status));
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

    public function getGroupId(){
    	return $this->group_id;
    }

    public function getType(){
    	return $this->type;
    }

    public function getStatus(){
    	return $this->status;
    }
	
    public function setId($id){
        $this->id = $id;
    }

	public function setStatus($status){
		$this->status = $status;
	}
}