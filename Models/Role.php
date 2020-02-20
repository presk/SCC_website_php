<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');

class Role{
	
	private $id;
	private $user_role;
	private $auth_lvl;


	public function __construct($id, $user_role, $auth_lvl){
		$this->id = $id;
		$this->user_role = $user_role;
		$this->auth_lvl = $auth_lvl;
    }

    /*Not sure we need to make insert methods for roles since they don't change. Read-only.*/

    /*Returns an array of Roles*/
    public static function GetAllRoles(){
        $conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM roles";

        $stmt = $conn->prepare($query);

        $stmt->execute();

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $roles = array();

        foreach ($queryResult as $row) {
            $r = new Role(
                $row['id'], 
                $row['user_role'], 
                $row['auth_lvl']
            );

            array_push($roles, $r);
        }

        return $roles;
    }

    /*Returns a single role. If Somehow there are multiple returns from the query, only the first result is returned.*/
    public static function GetRoleByUserId($id){
        $conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM roles WHERE roles.id in (SELECT role_id FROM users WHERE users.id = ?)";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

        $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);

        $role = new Role($queryResult['id'], $queryResult['user_role'], $queryResult['auth_lvl']);

        return $role;
    }

    public function getId(){
    	return $this->id;
    }

    public function getUserRole(){
    	return $this->user_role;
    }

    public function getAuthLvl(){
    	return $this->auth_lvl;
    }
}