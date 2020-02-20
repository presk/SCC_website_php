<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/ContentComments.php');


if(isset($_POST['delete'])){

    deleteCommentByCommentId($_POST['delete']);

    echo "<script>location.href='../Views/content_comments.php?content_id={$_SESSION['content_id']}'</script>";
}


function deleteCommentByCommentId($comment_id){
    ContentComments::DeleteCommentByCommentId($comment_id);
}

?>