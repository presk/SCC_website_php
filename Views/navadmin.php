<?php
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/user.controller.php');
$userID = $_SESSION['user_id'];
$user = getUserbyID($userID);
if($user->getRoleID() == 1){
    echo 
    '<a class="navbar-item" href="event_management.php"><b>Event Management</b></a>
    <a class="navbar-item" href="user_management.php"><b>User Management</b></a>';
}
else if($user->getRoleID() == 2){
    echo 
    '<a class="navbar-item" href="user_controller.php"><b>Set Charges</b></a>';
}
?>
