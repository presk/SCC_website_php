<?php

if(!isset($_SESSION)) { 
	session_start(); 
} 

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
} else {
    require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');
    require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Group.php');
	require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');

    $content = Content::GetMainFeed($_SESSION['user_id']);
}