<?php

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Group.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');



if (isset($_POST['save'])) {
     $id = $_POST['save'];
     $updateData = $_POST[$id];

            $userUpdate = new User(
                                    $updateData['user_name'], 
                                    getUserByID($_POST['save'])->getUserPass(), 
                                    $updateData['email'], 
                                    $updateData['first_name'], 
                                    $updateData['last_name'], 
                                    $updateData['street_number'], 
                                    $updateData['apt_number'],
                                    $updateData['street_name'], 
                                    $updateData['city'], 
                                    $updateData['bday']
                                );
            $userUpdate->setId($_POST['save']);
            $userUpdate->setRoleID($updateData['roleID']);
            $userUpdate->update();
            echo "<script>location.href='./user_management.php?message=Update%20Succesful';</script>";
}
if (isset($_POST['delete'])) {
    deleteUserById($_POST['delete']);
}


function deleteUserById($user_id){

    User::DeleteUserById($user_id);

    echo "<script>window.location.href=\"../Views/user_management.php\"</script>";

}



?>