<?php

//Note id and roleID must be set manually via the setters at the bottom
/*
#Roles
('sysadmin', 1),
('controller', 2),
('event_manager', 3),
('group_manager', 4),
('participant', 5);
*/

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Model.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');

class User extends Model{
    
    private $id;
    private $roleID;
    private $userName;
    private $userPass;
    private $email;
    private $firstName;
    private $lastName;
    private $addrNumber;
    private $aptNumber;
    private $street;
    private $city;
    private $bDay;

    
    public function __construct($userName, $userPass, $email, $firstName, $lastName, $addrNumber, $aptNumber,  $street, $city, $bDay){
        $this->userName = $userName;
        $this->userPass = $userPass;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->addrNumber = $addrNumber;
        $this->aptNumber = intval($aptNumber);
        $this->street = $street;
        $this->city = $city;
        $this->bDay = $bDay;
    }
    public function getID(){
        return $this->id;
    }
    public function getRoleID(){
        return $this->roleID;
    }
    public function getUserName(){
        return $this->userName;
    }
    
    public function getUserPass(){
        return $this->userPass;
    }
    public function getUserEmail(){
        return $this->email;
    }
    public function getUserFirstName(){
        return $this->firstName;
    }
    public function getUserLastName(){
        return $this->lastName;
    }
    public function getUserBday(){
        return $this->bDay;
    }
    public function save(){
        $conn = DB::getInstance()->getConnection();
        $sql = "INSERT INTO users (role_id, username, user_password, email, first_name, last_name, adr_number, apt_number, street, city, dob) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($this->roleID, $this->userName, $this->userPass, $this->email, $this->firstName, $this->lastName, $this->addrNumber, $this->aptNumber, $this->street, $this->city, $this->bDay));
    }

    
    public static function AddEventParticipant($user_id, $event_id) {
        $conn = DB::getInstance()->getConnection();
        $sql = "INSERT INTO event_participants (user_id, event_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($user_id, $event_id));
        
    }
    
    public static function RemoveEventParticipant($user_id, $event_id) {
        $conn = DB::getInstance()->getConnection();
        $sql = "DELETE FROM event_participants WHERE user_id = ?  AND event_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($user_id, $event_id));
        
    }
    
    

    public function update(){
        $apt = $this->aptNumber;

        if($apt === 0){
            $apt = NULL;
        }

        $conn = DB::getInstance()->getConnection();
        
        $stmt = $conn->prepare("UPDATE users SET
            role_id = ?,
            username = ?, 
            user_password = ?,
            email = ?, 
            first_name = ?, 
            last_name = ?,
            adr_number = ?,
            apt_number = ?, 
            street = ?, 
            city = ?, 
            dob = ? 
            WHERE id = ?");
        
        $stmt->execute(array(
            $this->roleID,
            $this->userName, 
            $this->userPass, 
            $this->email, 
            $this->firstName, 
            $this->lastName, 
            $this->addrNumber,
            $apt,
            $this->street, 
            $this->city, 
            $this->bDay, 
            $this->id
        ));
    
    }
    public static function GetAllUsers(){
        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare('SELECT * FROM users');
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $user_array = [];

        foreach($results as $user){

            $user_to_insert = new User($user['username'], $user['user_password'], $user['email'], $user['first_name'], $user['last_name'], $user['adr_number'], $user['apt_number'], $user['street'], $user['city'], $user['dob']);
            $user_to_insert->setId($user['id']);
            $user_to_insert->setRoleID($user['role_id']);
            
            $user_array[] = $user_to_insert;
        }

        return $user_array;
    }
    public static function GetUserByUserName($userName){
        
        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute(array($userName));
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $returnUser = new User($results['username'], $results['user_password'], $results['email'], $results['first_name'], $results['last_name'], $results['adr_number'], $results['apt_number'], $results['street'], $results['city'], $results['dob']);
        $returnUser->setId($results['id']);
        $returnUser->setRoleID($results['role_id']);
        return $returnUser;
    }
    public static function GetUserById($id){
        
        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute(array($id));
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $returnUser = new User($results['username'], $results['user_password'], $results['email'], $results['first_name'], $results['last_name'], $results['adr_number'], $results['apt_number'], $results['street'], $results['city'], $results['dob']);
        $returnUser->setId($results['id']);
        $returnUser->setRoleID($results['role_id']);
        return $returnUser;
    }

    public static function GetAllUsersByGroupId($group_id){

        $sql = "SELECT * FROM users, group_participants WHERE group_participants.user_id = users.id AND group_participants.group_id = ?";
        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($group_id));

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $user_array = [];

        foreach($results as $user){

            $user_to_insert = new User($user['username'], $user['user_password'], $user['email'], $user['first_name'], $user['last_name'], $user['adr_number'], $user['apt_number'], $user['street'], $user['city'], $user['dob']);
            $user_to_insert->setId($user['id']);
            $user_to_insert->setRoleID($user['role_id']);
            
            $user_array[] = $user_to_insert;
        }

        return $user_array;
    }

    /*Cascade catches all of the FKs.*/
    public static function DeleteUserById($user_id){
        $sql = "DELETE FROM users WHERE id = ?";

        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->execute([$user_id]);

    }

    public static function SetRoleByName($roleName, $userID){
        $sql = "UPDATE users SET role_id = (SELECT id FROM roles where user_role = ?) WHERE users.id = ?";

        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->execute([$roleName, $userID]);
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * Set the value of roleID
     *
     * @return  self
     */ 
    public function setRoleID($roleID)
    {
        $this->roleID = $roleID;
    }
    /**
     * Set the value of userName
     *
     * @return  self
     */ 
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
    /**
     * Get the value of addrNumber
     */ 
    public function getAddrNumber()
    {
        return $this->addrNumber;
    }
    /**
     * Get the value of aptNumber
     */ 
    public function getAptNumber()
    {
        return $this->aptNumber;
    }
    /**
     * Get the value of street
     */ 
    public function getStreet()
    {
        return $this->street;
    }
    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }
}