<?php
//session_start();

require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event.controller.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event_management.controller.php');
$userID = $_SESSION['user_id'];
?>


<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/header.php'); ?>

<title>Events</title>
<body>

    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/navbartop.php'); ?>

    <section class="section">
        <div class="container">
               
              <?php
              
              $eventList = getAllEvents(false);
                
                if(!empty($eventList)){
                    echo "
                    
                    <table class='table' >
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Lifetime</th>
                                <th>Recurring</th>
                                <th>Description</th>
                                <th>Fee($)</th>
                                <th>Manager</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <form action='' method='POST'>
                    ";

                    foreach($eventList as $event) {
                        echo '
                                 <div class="content">
                                    <tr>
                                        <td><figure class="media-left">
                                                <p class="image is-64x64">
                                                    <img src="https://bulma.io/images/placeholders/128x128.png">
                                                </p>
                                            </figure>
                                        </td>
                                        <td>' . $event->getID() . '</td>
                                        <td>' . $event->getName() . '</td>
                                        <td>' . $event->getLifetime() . '</td>
                                        <td>' . $event->getStatus() . '</td>
                                        <td>' . $event->getRecurring() . '</td>
                                        <td>' . $event->getDescription() . '</td>
                                        <td>' . $event->getFee() . ' </td>
                                        <td><select name="manager" value="guile" style="padding-right: 100px">';
                                            //Drop-down user list
                                            //Only populated by Users who are not part of the current event

                                            $completeUserList = getAllUsers();

                                            //Get all users (All users in the system)
                                            foreach ($completeUserList as $user) {

                                                $uID = $user->getID();
                                                if($uID == $event->getManagerID()){
                                                    $sel = 'selected = "selected"';
                                                }
                                                else{
                                                    $sel = '';
                                                }

                                                $userName = $user->getUserName();
                                                $user_ID = $user->getID();
                                                echo '<option value="' . $user_ID . '"'.$sel.'>' . $userName . '</option>';

                                        }
                                        echo'
                                        </select>
                                        </td>
                                        <td><button type="submit" class="button" name="save" value="'.$event->getId().'">Save</button></td>
                                        <td><button type="submit" class="button" name="delete" value="'.$event->getId().'">Delete</button></td>
                                    </tr>
										 					
								';
                        }
                        echo "  
                        </form>
                        </tbody>
                        </table>
                        ";
                }else{

                    echo "<h2 class='subtitle'>No events</h2>";
                }
              
                ?>       
        
            <a class="button" href="create_event.php">Create New Event</a>
            </div>
    </section>
    
           

<script async type="text/javascript" src="../JS/bulma.js"></script>
</body>
<?php require_once './footer.php' ?>
