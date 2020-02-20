<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Classes/DB.php');



$userID = $_SESSION['user_id'];
$requestEventID = $_POST["row_id"];

if (!isset($requestEventID)) {
    $requestEventID = $_SERVER["id"];
}
?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event.controller.php'); ?>
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/user.controller.php'); ?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/header.php'); ?>


<body>
    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/navbartop.php'); ?>

    <section class="section">
        <div class="container">

            <?php
            $event = getEventByID($requestEventID);


            ?>
            <h1 class="title">Users currently participating in this event</h1>
        </div>
        <section class="section">
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Username:</th>
                            <th>First Name:</th>
                            <th>Last Name:</th>
                            <th>Email:</th>
                            <th>City:</th>
                            <th>Delete User</th>
                        </tr>
                    </thead>
                    <tbody>
                    <form action="../Controllers/user.controller.php" method="POST">
                        <?php
                        $participantList = getParticipantsByEventId($requestEventID);

                        foreach ($participantList as $user) {

                            echo
                            "<tr>
                        <td>{$user->getUserName()}</td>
                        <td>{$user->getUserFirstName()}</td>
                        <td>{$user->getUserLastName()}</td>
                        <td>{$user->getUserEmail()}</td>
                        <td>{$user->getCity()}</td>
                        <td><button type=\"submit\" class=\"button\" name=\"deleteParticipant\" value=\"{$user->getId()}\">Delete</button></td>
                    </tr>";
                        }
                        ?>
                        <input type="hidden" value="<?php echo $requestEventID; ?>" name="row_id">
                    </form>
                    </tbody>
                </table>

                <h1 class="title">Add other participants to this event</h1>
                <div class="control">
                    <div class="select">
                        <form action="../Controllers/user.controller.php" method="POST" id="addParti"> 
                            <select name="addParticipant" form="addParti" style="padding-right: 100px">

                                <?php
                                //Drop-down user list
                                //Only populated by Users who are not part of the current event

                                $completeUserList = getAllUsers();
                                $match = false;

                                //Get all users (All users in the system)
                                foreach ($completeUserList as $user) {

                                    $uID = $user->getID();
                                    //Foreach user, check against current list of event participants
                                    //to see if there is an ID match
                                    //(Users currently participating in this event)
                                    foreach ($participantList as $participant) {

                                        //If there is a match, break out of the participant loop and check next userID
                                        //First condition is checking against the user that is currently logged-in
                                        if ($uID == $userID || $uID == $participant->getID()) {
                                            //User is already participating in this event
                                            $match = true;
                                            break;
                                        } else {
                                            //User is not participating in this event and can be added
                                            $match = false;
                                        }
                                    }

                                    //If there is no match, add selection to drop-down list
                                    if (!$match) {
                                        $userName = $user->getUserName();
                                        $user_ID = $user->getID();
                                        echo '<option value="' . $user_ID . '">' . $userName . '</option>';
                                    }
                                }
                                ?>
                            </select>
                    </div>
                    <input type="hidden" value="<?php echo $requestEventID; ?>" name="row_id">
                    <button class="button is-primary control"  type="submit" >Add</button>
                </div>


                </form>
            </div>
        </section>
    </section>

</body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/footer.php');
?>
