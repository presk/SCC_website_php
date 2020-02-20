<?php

if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/ContentComments.php');


function getContentByContentId($content_id){

    return Content::getContentByContentId($content_id);

}

//Function redefinition
/*function getUserById($user_id){

    return User::GetUserById($user_id);

}*/

function getCommentsByContentId($content_id){

    return ContentComments::GetCommentsByContentId($content_id);

}


?>