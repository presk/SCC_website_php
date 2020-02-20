<?php

session_start();

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Role.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Event.php');

if(isset($_SESSION['user_id'])){

	if(isset($_POST['event'])){
		$event = $_POST['event'];

		$recur = (isset($event['recur'])) ? 1 : 0;

		Event::InsertEvent($event['manager'], $event['event_name'], 1, $event['lifetime'], $recur, $event['fee'], $event['description']);

		$manaRole = Role::GetRoleByUserId($event['manager']);

		/*Only update the select user's role if his role wasn't greater than event manager. We don't want the sysadmin to be demoted to event manager!*/
		if($manaRole->getAuthLvl() > 3){
			User::SetRoleByName("event_manager", $event['manager']);
		}
	}
}