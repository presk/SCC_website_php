<?php
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
if(isset($_SESSION['user_id'])){
    
}

if (isset($_POST['addParticipant'])) {
    
    addEventParticipant($_POST['addParticipant'],$_POST["row_id"]);
    //echo "<script>window.location.href=\"../Views/event_edit.php?id=" . $_POST["row_id"]  ."\"</script>";
}

if (isset($_POST['deleteParticipant'])) {

    removeEventParticipant( $_POST['deleteParticipant'], $_POST["row_id"]);
    //echo "<script>window.location.href=\"../Views/event_edit.php?id=" . $_POST["row_id"]  ."\"</script>";
}

function addEventParticipant($user_id, $event_id) {
    
    User::AddEventParticipant($user_id, $event_id);
}

function removeEventParticipant($user_id, $event_id)  {

    User::RemoveEventParticipant($user_id, $event_id); 
}
/*if (isset($_POST['delete'])) {
    
    deleteGroupById($_POST['delete']);
    
}*/

function getUserbyID($user_id){

    return User::GetUserbyID($user_id);
}

//Required for events
function getAllUsers() {
    
    return User::GetAllUsers();
}

?>