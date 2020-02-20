<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}

if(!isset($_SESSION['user_id'])){
    //boot scripts
}

?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/group.controller.php'); 


if(isset($_SESSION['user_id'])){
    
    $userID = $_SESSION['user_id'];

    $groupList = getAllGroupParticipatedByUserId($userID);

    if(!empty($groupList)){

            foreach($groupList as $group){

                echo 
                    "<tr>
                        <td><a href=\"../Views/group_content.php?group_id={$group->getId()}\">{$group->getName()}</a></td>
                        <td>{$group->getDescription()}</td>
                            
                    </tr>";

            }
    }else{
        echo
            "<tr>
                <td>You are currently not participating in any groups.</td>
            </tr>";
    }
}

?>
