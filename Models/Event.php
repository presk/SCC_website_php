<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Group.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');

class Event {

    private $id;
    private $manager_id;
    private $name;
    private $status;
    private $lifetime;
    private $recurring;
    private $fee;
    private $description;

    public function __construct($manager_id, $name, $status, $lifetime, $recurring, $fee, $description) {
        $this->manager_id = $manager_id;
        $this->name = $name;
        $this->status = $status;
        $this->lifetime = $lifetime;
        $this->recurring = $recurring;
        $this->fee = $fee;
        $this->description = $description;
    }

    /* Save the current instance of the object to the database. */

    public function save() {
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO events(manager_id, event_name, event_status, lifetime, recurring, fee, event_description) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute(array($this->manager_id, $this->name, $this->status, $this->lifetime, $this->recurring, $this->fee, $this->description));
    }
    public static function updateFee($event_id, $new_fee) {
        $fee = $new_fee;
        $conn = DB::getInstance()->getConnection();
        $sql = "UPDATE events SET fee = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($new_fee, $event_id));
        
    }
    public static function updateManager($event_id, $new_managerID) {
        $manager_id = $new_managerID;
        $conn = DB::getInstance()->getConnection();
        $sql = "UPDATE events SET manager_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($new_managerID, $event_id));
        
    }

    public static function GetEventById($id) {
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");

        $stmt->execute(array($id));

        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $returnEvent = new Event(
                $results['manager_id'], $results['event_name'], $results['event_status'], $results['lifetime'], $results['recurring'], $results['fee'], $results['event_description']
        );

        $returnEvent->setId($results['id']);

        return $returnEvent;
    }

    /* Returns an array of Events. Same as SELECT *
      if 'true' is passed, will return events ordered by name. */

    public static function GetAllEvents($order = false) {
        $conn = DB::getInstance()->getConnection();

        $queryStr = "SELECT * FROM events";

        if ($order) {
            $queryStr .= " ORDER BY event_name DESC";
        }

        $stmt = $conn->prepare($queryStr);

        $stmt->execute();

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = array();

        foreach ($queryResult as $event) {
            $e = new Event(
                    $event['manager_id'], $event['event_name'], $event['event_status'], $event['lifetime'], $event['recurring'], $event['fee'], $event['event_description']
            );

            $e->setId($event['id']);

            array_push($events, $e);
        }

        return $events;
    }

    /* Returns an array made of id and username of every participant of the event passed
      Could very well make User objects out of this. */

    public static function GetParticipantsByEventId($id) {
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * from users WHERE users.id IN (SELECT user_id FROM event_participants WHERE event_id = ?)");

        $stmt->execute(array($id));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $allParticipants = array();

        foreach ($queryResult as $participant) {

            $p = new User($participant['username'], $participant['user_password'], $participant['email'], $participant['first_name'], $participant['last_name'],  $participant['adr_number'], $participant['apt_number'], $participant['street'], $participant['city'], $participant['dob']);
            $p->setId($participant['id']);
            array_push($allParticipants, $p);
        }

        return $allParticipants;
    }

    /* Inserts an event with the specified parameters into the database */

    public static function InsertEvent($manager_id, $name, $status, $lifetime, $recurring, $fee, $description) {
        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO events(manager_id, event_name, event_status, lifetime, recurring, fee, event_description) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute(array($manager_id, $name, $status, $lifetime, $recurring, $fee, $description));
    }

    public static function GetAllUserManagedEvents($userID) {

        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM events WHERE manager_id = ?");
        $stmt->execute(array($userID));
        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $managedEvents = array();

        foreach ($queryResult as $event) {

            $e = new Event(
                    $event['manager_id'], $event['event_name'], $event['event_status'], $event['lifetime'], $event['recurring'], $event['fee'], $event['event_description']
            );

            $e->setId($event['id']);

            array_push($managedEvents, $e);
        }

        return $managedEvents;
    }

    public static function GetAllUserParticipatingEvents($userID) {

        $conn = DB::getInstance()->getConnection();
        $stmt = $conn->prepare("SELECT manager_id, event_name, event_status, lifetime, recurring, fee, event_description, id FROM events x INNER JOIN event_participants y ON x.id = y.event_id WHERE y.user_id = ?");
        $stmt->execute(array($userID));
        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $participatingEvents = array();
        foreach ($queryResult as $event) {

            $e = new Event(
                    $event['manager_id'], $event['event_name'], $event['event_status'], $event['lifetime'], $event['recurring'], $event['fee'], $event['event_description']
            );

            $e->setId($event['id']);

            array_push($participatingEvents, $e);
        }

        return $participatingEvents;
        

    }

    /*Deletes the passed event along with any content associated with it and the groups that belong to it*/
    public static function DeleteEventById($event_id){
        $groups = Group::GetGroupByEventID($event_id);

        foreach ($groups as $g) {
            Content::DeleteContentByGroupId($g->getId());
        }

        Content::DeleteContentByEventId($event_id);

        $sql = "DELETE FROM events WHERE id = ?";

        $conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->execute([$event_id]);

    }
	
	public static function InsertContentByEventId($user_id, $event_id, $content, $content_type, $content_post_time){
		
		$sql = "INSERT INTO content (user_id, type, content, post_time) VALUES (?, ?, ?, ?)";

		$sql_2 = "INSERT INTO event_content (event_id, content_id) VALUES (?,
					(SELECT id FROM content ORDER BY id DESC LIMIT 1))";

		$conn = DB::getInstance()->getConnection();

		$stmt = $conn->prepare($sql);
		
		$stmt_2 = $conn->prepare($sql_2);

		$stmt->execute([$user_id, $content_type, $content, $content_post_time]);
		
		$stmt_2->execute([$event_id]);

	}

    /* Getters and setters */

    public function getId() {
        return $this->id;
    }

    public function getManagerId() {
        return $this->manager_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getLifetime() {
        return $this->lifetime;
    }

    public function getRecurring() {
        return $this->recurring;
    }

    public function getFee() {
        return $this->fee;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getContent() {
        return $this->content;
    }

    public function getParticipants() {
        return $this->participants;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setManagerId($id) {
        $this->manager_id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setLifetime($lifetime) {
        $this->lifetime = $lifetime;
    }

    public function setRecurring($recurring) {
        $this->recurring = $recurring;
    }

    public function setFee($fee) {
        $this->fee = $fee;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setParticipants($parts) {
        $this->participants = $parts;
    }

}
