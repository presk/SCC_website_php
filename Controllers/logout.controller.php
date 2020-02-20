<?php

    session_start();

    if(isset($_SESSION['user_id'])){
        if(isset($_POST['logout'])){

            session_unset();

            session_destroy();

            echo "<script>location.href='../index.php';</script>";
        }

    }
?>
