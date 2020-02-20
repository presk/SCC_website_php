<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');

class Organization{
	private $id;
	private $user_id;
	private $name;
	private $type;

	public function __construct($user_id, $name, $type){
		$this->user_id = $user_id;
		$this->name = $name;
		$this->type = $type;
    }

    /*Send the instance of the object to the DB*/
    public function save(){
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO organizations(user_id, org_name, org_type) VALUES (?, ?, ?)");

        $stmt->execute(array($this->user_id, $this->name, $this->type));
    }

    /*Returns any organization affiliated with the user id passed*/
    public static function GetOrganizationByUserId($id){
    	$conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM organizations WHERE user_id = ?";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $organizations = array();

        foreach ($queryResult as $row) {
            $o = new Organization(
                $row['user_id'], 
                $row['org_name'], 
                $row['org_type']
            );

            $o->setId($row['id']);

            array_push($organizations, $o);
        }

        return $organizations;
    }

    /*Returns any organization with the name passed
    WARNING: we didn't make the org_name field unique.*/
    public static function GetOrganizationByName($name){
    	$conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM organizations WHERE org_name = ?";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($name));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $organizations = array();

        foreach ($queryResult as $row) {
            $o = new Organization(
                $row['user_id'], 
                $row['org_name'], 
                $row['org_type']
            );

            $o->setId($row['id']);

            array_push($organizations, $o);
        }

        return $organizations;
    }

    /*Add an organization to the db, without instancing an object*/
    public static function InsertOrganization($user_id, $name, $type){
    	$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO organizations(user_id, org_name, org_type) VALUES (?, ?, ?)");

        $stmt->execute(array($user_id, $name, $type));
    }

    public function getId(){
    	return $this->id;
    }

    public function getUserId(){
    	return $this->user_id;
    }

    public function getName(){
    	return $this->name;
    }

    public function getTypeOrg(){
    	return $this->type;
    }
	
    public function setId($id){
    	$this->id = $id;
    }

	public function setName($name){
		$this->name = $name;
	}
	
	public function setTypeOrg($type){
		$this->type = $type;
	}
}