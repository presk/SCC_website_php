<?php

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Group.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/ContentComments.php');



function getAllGroupContentByGroupId($group_id){

    return Content::GetContentByGroupId($group_id, true);

}



?>