<?php

require_once('../Models/User.php');  


//TODO
//Input Validation

    if(isset($_POST['user'])){
        
        $newUser = $_POST['user'];

        $insertUser = new User($newUser['user_name'], 
                            sha1($newUser['user_password']),
                            $newUser['email'],
                            $newUser['first_name'],
                            $newUser['last_name'],
                            $newUser['street_number'],
                            $newUser['apt_number'],
                            $newUser['street_name'],
                            $newUser['city'],
                            $newUser['bday']);

        $insertUser->setRoleID($newUser['role_ID']);

        $insertUser->save();

        //Redirect to login
        echo "<script>location.href='../Views/user_management.php?message=Account%20Creation%20Succesful';</script>";

    }else{
        echo "<script>location.href='../Views/user_management.php?message=Account%20Creation%20Failed';</script>";
    }


?>  