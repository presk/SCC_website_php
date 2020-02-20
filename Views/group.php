<?php 


if(!isset($_SESSION)){
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/group.controller.php'); 


?>



<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php'); ?>

<title>Group OverView Page</title>

<body>

    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navbartop.php'); ?>

    <section class="section">
        <div class="container">
            <h1 class="title">Groups you are managing</h1>

            <?php

                $groupList = getAllGroupManagedByUserId($_SESSION['user_id']);

                if(!empty($groupList)){
                    echo "
                        <table class='table'>
                        <thead>
                            <tr>
                                <th>Group ID</th>
                                <th>Event ID</th>
                                <th>Manager ID</th>
                                <th>Group Name</th>
                                <th>Group Description</th>
                                <th>Delete Group</th>
                            </tr>
                        </thead>
                        <tbody>
                        <form action='../Controllers/group.controller.php' method='POST'>
                    ";
    
                    foreach($groupList as $group){
    
                        echo 
                        "<tr>
                            <td>{$group->getId()}</td>
                            <td>{$group->getEventId()}</td>
                            <td>{$group->getManagerId()}</td>
                            <td><a href=\"../Views/group_manage.php?group_id={$group->getId()}\">{$group->getName()}</a></td>
                            <td>{$group->getDescription()}</td>
                            <td><button type=\"submit\" class=\"button\" name=\"delete\" value=\"{$group->getId()}\">Delete</button></td>
                        </tr>";
    
                    }

                    echo "
                        <form>
                        </tbody>
                        </table>
                    ";
                    
                }else{
                    echo "<h2 class='subtitle'>You are currently not managing any groups.</h2>";
                }

            ?>
        </div>

        <section class="section">
            <div class="container">
                <a class="button" href="create_group.php">Create New Group to Manage</a>
            </div>
        </section>
    </section>

    <section class="section">
        <div class="container">
            <h1 class="title">Groups you are part of</h1>

            <?php

                $participant_group_list = getAllGroupParticipatedByUserId($_SESSION['user_id']);

                if(!empty($participant_group_list)){
                    echo "
                        <table class='table'>
                        <thead>
                            <tr>
                                <th>Group ID</th>
                                <th>Event ID</th>
                                <th>Manager ID</th>
                                <th>Group Name</th>
                                <th>Group Description</th>
                                <th>Leave Group</th>
                            </tr>
                        </thead>
                        <tbody>
                        <form action='../Controllers/group.controller.php' method='POST'>
                    ";

                    foreach($participant_group_list as $group){

                        echo 
                        "<tr>
                            <td>{$group->getId()}</td>
                            <td>{$group->getEventId()}</td>
                            <td>{$group->getManagerId()}</td>
                            <td><a href=\"../Views/group_content.php?group_id={$group->getId()}\">{$group->getName()}</a></td>
                            <td>{$group->getDescription()}</td>
                            <td><button class='button is-small is-danger is-outlined' type='submit' name='quit_group' value={$group->getId()}>quit</button></td>
                        </tr>";

                    }

                    echo "
                        <form>
                        </tbody>
                        </table>
                    ";
                    
                }else{
                    echo "<h2 class='subtitle'>You are currently not participating in any groups.</h2>";
                }
                
            ?>

        </div>
    </section>

</body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/footer.php');
 ?>
