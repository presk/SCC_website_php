<?php


if(!isset($_SESSION)) 
{ 
	session_start(); 
} 


require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Models/Event.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Models/User.php');


if (isset($_POST['delete'])) {
    
    delGroupById($_POST['delete']);
    
}

function delGroupById($group_id){

    Group::DeleteGroupById($group_id);

}

function getAllUserManagedEvents($userID) {
    return Event::GetAllUserManagedEvents($userID);
}

function getAllUserParticipatingEvents($userID) {
    return Event::GetAllUserParticipatingEvents($userID);
}

function getEventByID($id) {
    return Event::GetEventById($id);
}

function getParticipantsByEventId($id){
    return Event::GetParticipantsByEventId($id);
}

function getAllEvents($order){
	return Event::GetAllEvents($order);
}




/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

