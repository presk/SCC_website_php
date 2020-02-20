<?php

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Event.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/event.controller.php');

if(isset($_POST["charge"]))
{
	$eventID = $_POST['row_id'];
	GetEventById($eventID)->updateFee($eventID, $_POST['charge']);
}


?>