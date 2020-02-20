<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/ContentComments.php');


if(isset($_POST['comment']) && isset($_SESSION['user_id']) && isset($_SESSION['content_id'])){
    
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];
    $content_id = $_SESSION['content_id'];
    insertComment($content_id, $user_id, $comment);

    //bring the user back to the comment page
    echo "<script>location.href='../Views/content_comments.php?content_id={$content_id}';</script>";


}

function insertComment($content_id, $user_id, $comment){
    ContentComments::InsertComment($content_id, $user_id, $comment);
}

?>