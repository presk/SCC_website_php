<?php

if(!isset($_SESSION))
    session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Message.php');


//Check to seee if a Post method was launched pretty hand to reduce amount of controllers
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['recipient'])){
        sendMessage($_SESSION['user_id'], $_POST['recipient'], $_POST['message']);
        echo "<script>location.href='../Views/inbox.php';</script>";
    }

    if(isset($_POST['archive'])){
        archiveDelete($_POST['archive']);
        echo "<script>location.href='../Views/inbox.php';</script>";
    }

    if(isset($_POST['delete'])){
        softDelete($_POST['delete']);
        echo "<script>location.href='../Views/inbox.php';</script>";
    }
}

function softDelete($message_id){
    Message::SoftDelete($message_id);
}

function archiveDelete($message_id){
    Message::ArchiveDelete($message_id);
}

function sendMessage($source_id, $destination_id, $message){
    Message::InsertMessage($source_id, $destination_id, $message);
}


function getUserByUserId($user_id){
    return User::GetUserById($user_id);
}

function getMessagesByUserId($user_id){
    return Message::GetReceivedMessagesByUserId($user_id);
}

function getSentMessagesByUserId($user_id){
    return Message::GetSentMessagesByUserId($user_id);
}



?>

