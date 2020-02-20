<?php

session_start();

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Group.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Event.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

if(isset($_POST['group_post']) && isset($_SESSION['group_id'])){

    $datetime = date_create()->format('Y-m-d H:i:s');

    Group::InsertContentByGroupId($_SESSION['user_id'], $_SESSION['group_id'], $_POST['content'], 0, $datetime);

    echo "<script>location.href='../Views/group_content.php?group_id={$_SESSION['group_id']}';</script>";


}

if(isset($_POST['event_post']) && isset($_SESSION['event_id'])){

    $datetime = date_create()->format('Y-m-d H:i:s');

    Event::InsertContentByEventId($_SESSION['user_id'], $_SESSION['event_id'], $_POST['content'], 0, $datetime);

    echo "<script>location.href='../Views/event_page.php?';</script>";


}


?>