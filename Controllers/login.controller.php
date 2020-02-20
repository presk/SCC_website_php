<?php

//Start this first
session_start();

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/User.php');


    //Using User Model Active Record Pattern
    if(!isset($_SESSION['user_id'])){

        if(isset($_POST['user_name'], $_POST['user_password'])){

            //Get the User using a Static Method that lives in the Model

            $newUser = User::GetUserByUserName($_POST['user_name']);

                if(sha1($_POST['user_password']) === $newUser->getUserPass()){

                    $_SESSION['user_id'] = $newUser->getID();
                    $_SESSION['role_id'] = $newUser->getRoleID();

                    echo "<script>location.href='../Views/home.php';</script>";

                }else{
                    echo "<script>location.href='../index.php?message=Invalid%20Credentials'</script>";
                }
        }else{
            echo "<script>location.href='../index.php';</script>";
        }


    }




?>