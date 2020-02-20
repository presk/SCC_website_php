<?php

if(!isset($_SESSION)){ 
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

//Bind the Group Id for use in create_content.controller.php
if(isset($_GET['group_id'])){
    $_SESSION['group_id'] = $_GET['group_id'];
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/group_content.controller.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/group.controller.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php');

?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php'); ?>

<title>Group</title>

<body>
    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navbartop.php'); ?>

    <section class="section">
        <div class="container">
            <h1 class="title"><?php echo getGroupByGroupId($_SESSION['group_id'])->getName(); ?></h1>
            <h1 class="subtitle"><?php echo getGroupByGroupId($_SESSION['group_id'])->getDescription(); ?></h1>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h1 class="title">Group Members</h1>
        <?php


            $user_array = getAllUsersByGroupId($_GET['group_id']);

            if(empty($user_array)){
                echo "No members in group.";
            }else{
                echo "
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Delete Member</th>
                        </tr>
                    </thead>
                    <tbody>
                    <form action='' method='POST'>
                ";
                foreach($user_array as $user){
                    echo 
                    "<tr>
                        <td>{$user->getUserName()}</td>
                        <td>{$user->getUserFirstName()}</td>
                        <td>{$user->getUserLastName()}</td>
                        <td><button type=\"submit\" class=\"button\" name=\"delete\" value=\"{$user->getId()}\">Delete</button></td>
                    </tr>";
                }

                echo "
                <form>
                </tbody>
                </table>
            ";
            }
        ?>
        </div>
        </section>

</body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/footer.php');
 ?>

 