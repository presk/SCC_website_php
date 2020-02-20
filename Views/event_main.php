<?php
//session_start();

require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event.controller.php');

$userID = $_SESSION['user_id'];
?>


<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/header.php'); ?>

<title>Events</title>
<body>

    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/navbartop.php'); ?>

    <section class="section">
        <div class="container">
                <h1 class="title">Events you are managing</h1>

                <?PHP
                $eventList = getAllUserManagedEvents($userID);
                
                if(!empty($eventList)){
                    echo "
                    
                    <table class='table' >
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Lifetime</th>
                                <th>Recurring</th>
                                <th>Description</th>
                                <th>Fee($)</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    ";

                    foreach($eventList as $event) {
                        $rec = 'no';
                        if($event->getRecurring() == 1){
                            $rec = 'yes';
                        }
                    echo '
                                    <tr>
                                        <td><figure class="media-left">
                                                <p class="image is-64x64">
                                                    <img src="https://bulma.io/images/placeholders/128x128.png">
                                                </p>
                                            </figure>
                                        </td>
                                        <form action="/Views/event_page.php" method="POST">
                                        <td>' . $event->getName() . '</td>
                                        <td>' . $event->getLifetime() . '</td>
                                        <td>' . $rec. '</td>
                                        <td>' . $event->getDescription() . '</td>
										<td>' .$event->getFee(). ' </td>
                                        <td><input type="submit" class="button" value="View"></td>
                                            <input type="hidden" value="' . $event->getId() . '" name="row_id">
                                        </form>
                                        <td><form action="/Views/event_edit.php" method="POST">
                                        <input type="submit" class="button" value="Edit">
                                            <input type="hidden" value="' . $event->getId() . '" name="row_id">
                                        </form></td>
                                    </tr>
										 					
								';
                            /*echo'
                                <article class="media">
                                    <figure class="media-left">
                                        <p class="image is-64x64">
                                        <img src="https://bulma.io/images/placeholders/128x128.png">
                                        </p>
                                    </figure>
                                    <div class="media-content">
                                        <div class="content">
                                         <p>
                                            
                                                <strong> Event Name: </strong>' . $event->getName() . '
                                                <br>
                                                <strong> Event Description: </strong>' . $event->getDescription() . '
                                                <br>
                                            <form action="/Views/event_page.php" method="POST" style="display: inline-block">
                                                <button class="button is-primary control"  type="submit" >View</button>
                                                <input type="hidden" value="' . $event->getId() . '" name="row_id">
                                            </form>
    
                                            <form action="/Views/event_edit.php" method="POST" style="display: inline-block">
                                                <button class="button is-primary control"  type="submit" >Edit</button>
                                                <input type="hidden" value="' . $event->getId() . '" name="row_id">
                                            </form>
                                        </p>
                                    </div>
                                </article>
                            ';*/
                        }
                        echo "  
                        </form>
                        </tbody>
                        </table>
                        ";
                }else{

                    echo "<h2 class='subtitle'>You are currently not managing any events.</h2>";
                }
                ?>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h1 class="title">Events you are part of</h1>
               
              <?php
              
              $eventList = getAllUserParticipatingEvents($userID);
              if(!empty($eventList)){
                echo "
                
                <table class='table' >
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Lifetime</th>
                            <th>Recurring</th>
                            <th>Description</th>
                            <th>Fee($)</th>
                            <th></th>
                        </tr>
                    </thead>
                ";

                foreach($eventList as $event) {
                    $rec = 'no';
                    if($event->getRecurring() == 1){
                        $rec = 'yes';
                    }
                echo '
                                <tr>
                                    <td><figure class="media-left">
                                            <p class="image is-64x64">
                                                <img src="https://bulma.io/images/placeholders/128x128.png">
                                            </p>
                                        </figure>
                                    </td>
                                    <form action="/Views/event_page.php" method="POST">
                                    <td>' . $event->getName() . '</td>
                                    <td>' . $event->getLifetime() . '</td>
                                    <td>' . $rec. '</td>
                                    <td>' . $event->getDescription() . '</td>
                                    <td>' .$event->getFee(). ' </td>
                                    <td><input type="submit" class="button" value="View"></td>
                                        <input type="hidden" value="' . $event->getId() . '" name="row_id">
                                    </form>
                                </tr>
                                                         
                            ';
                    }
                    echo "  
                    </form>
                    </tbody>
                    </table>
                    ";
            }else{

                    echo "<h2 class='subtitle'>You are currently not participating in any events.</h2>";
                }
              
                ?>       
        </div>
    </section>
    
           

<script async type="text/javascript" src="../JS/bulma.js"></script>
</body>
<?php require_once './footer.php' ?>
