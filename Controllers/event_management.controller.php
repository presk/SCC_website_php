<?php

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Event.php');




if (isset($_POST['save'])) {
    $eventID = $_POST['save'];
    $managerID = $_POST['manager'];
    GetEventById($eventID)->updateManager($eventID, $managerID);
    echo "<script>location.href='./event_management.php?message=Update%20Succesful';</script>";
}

if (isset($_POST['delete'])) {
    deleteEventById($_POST['delete']);
}


function deleteUserById($user_id){

    User::DeleteUserById($user_id);

    echo "<script>window.location.href=\"../Views/user_management.php\"</script>";

}
function deleteEventById($eventID){

    Event::deleteEventById($eventID);

    echo "<script>location.href='./event_management.php?message=Deletion%20Succesful';</script>";
}
?>