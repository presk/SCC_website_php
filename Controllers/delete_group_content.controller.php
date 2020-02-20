<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/ContentComments.php');


if(isset($_POST['delete'])){
    deleteContentByContentId($_POST['delete']);

    echo "<script>location.href='../Views/group_content.php?group_id={$_SESSION['group_id']}'</script>";
}


function deleteContentByContentId($content_id){
    Content::DeleteContentByContentId($content_id);
}

?>