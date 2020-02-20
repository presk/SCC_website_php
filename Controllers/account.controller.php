<?php

//TODO account modification
    require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Role.php');
    session_start();

    require_once('../Models/User.php');
    require_once('../Classes/DB.php');

    if (!isset($_SESSION['user_id'])) {
        echo "<script>location.href='../index.php';</script>";
    }else{   
        if(isset($_POST['user'])){
            $updateData = $_POST['user'];

            $userUpdate = new User(
                                    $updateData['user_name'], 
                                    sha1($updateData['user_password']), 
                                    $updateData['email'], 
                                    $updateData['first_name'], 
                                    $updateData['last_name'], 
                                    $updateData['street_number'], 
                                    $updateData['apt_number'],
                                    $updateData['street_name'], 
                                    $updateData['city'], 
                                    $updateData['bday']
                                );
            $userUpdate->setId($_SESSION['user_id']);
            $userUpdate->setRoleID($_SESSION['role_id']);
            $userUpdate->update();

            $_POST['message'] = "Account information updated";
        }
    }