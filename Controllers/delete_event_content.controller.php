<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/ContentComments.php');


if(isset($_POST['delete_post'])){
    deleteContentByContentId($_POST['delete_post']);

    echo "<script>location.href='../Views/event_page.php'</script>";
}


function deleteContentByContentId($content_id){
    Content::DeleteContentByContentId($content_id);
}

?>