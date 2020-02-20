<?php

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Group.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');

if(isset($_SESSION['user_id'])){   
	if(isset($_POST['quit_group'])){
		
		Group::LeaveGroup($_SESSION['user_id'], $_POST['quit_group']);

		echo "<script>window.location.href=\"../Views/group.php\"</script>";
	}
}

if (isset($_POST['delete'])) {
    
    deleteGroupById($_POST['delete']);
    
}

//Delete group and redirect to to group.php page
function deleteGroupById($group_id){

    Group::DeleteGroupById($group_id);

    echo "<script>window.location.href=\"../Views/group.php\"</script>";

}

function getAllGroups(){

    return Group::GetAllGroups();

}

function getAllGroupManagedByUserId($user_id){
    return Group::GetAllUserManagedGroups($user_id);
}

function getAllGroupParticipatedByUserId($user_id){
    return Group::GetGroupsByUserId($user_id);
}

function getGroupByGroupId($group_id){
    return Group::GetGroupById($group_id);
}

function getAllUsersByGroupId($group_id){
    return User::GetAllUsersByGroupId($group_id);
}

?>