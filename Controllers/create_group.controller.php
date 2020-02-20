<?php

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Group.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

if(isset($_POST['group'])){

    $postData = $_POST['group'];

    $newGroup = new Group($_POST['event'] , $_SESSION['user_id'], $postData['group_name'], $postData['group_desc']);

    $newGroup->save();

    echo "<script>location.href='../Views/group.php';</script>";

}

?>