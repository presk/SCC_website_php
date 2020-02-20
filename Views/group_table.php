<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/group.controller.php'); ?>
 
 <?php

    $userID = '';

    if(isset($_SESSION['user_id'])){
        $userID = $_SESSION['user_id']; 
    }

    $groupList = getAllGroupManagedByUserId($userID);

    if(!empty($groupList)){
        foreach($groupList as $group){

            echo 
                "<tr>
                    <td><a href=\"../Views/group_manage.php?group_id={$group->getId()}\">{$group->getName()}</a></td>
                    <td>{$group->getDescription()}</td>
                        
                </tr>";

        }
    }else{
        echo
            "<tr>
                <td>You are currently not managing any groups.</td>
            </tr>";
    }

?>
