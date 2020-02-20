<?php

require_once('../Models/User.php');  

//Note
//Registration for public accounts only
//Role ID is set to 5 being the lowest
//Only admins can make other admins

//TODO
//Input Validation

    if(isset($_POST['user'])){
        
        $newUser = $_POST['user'];

        $insertUser = new User($newUser['user_name'], sha1($newUser['user_password']), $newUser['email'], $newUser['first_name'], $newUser['last_name'], $newUser['street_number'], $newUser['apt_number'], $newUser['street_name'], $newUser['city'], $newUser['bday']);

        $insertUser->setRoleID(5);

        $insertUser->save();

        // echo '<pre>';
        // var_dump($insertUser);
        // echo '</pre>';

        // echo '<pre>';
        // var_dump($newUser);
        // echo '</pre>';

        // exit();

        //Redirect to login
        echo "<script>location.href='../index.php?message=Account%20Creation%20Succesful';</script>";

    }else{
        echo "<script>location.href='../index.php?message=Account%20Creation%20Failed';</script>";
    }


?>  