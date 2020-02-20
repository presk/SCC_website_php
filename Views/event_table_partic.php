<?php
                require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event.controller.php');
                $userID = $_SESSION['user_id'];
                $eventList = getAllUserParticipatingEvents($userID);
                
                if(!empty($eventList)){
                    //echo "<br>" . "=====EVENTS USER: " . $userID . " IS MANAGING=====" . "<br>" . "<br>";

                    foreach($eventList as $event) {
                    
                            echo
                            "<tr>
                                <td>{$event->getName()}</td>
                                <td>{$event->getDescription()}</td>
                            </tr>";
                            
                        }
                }else{

                    echo "<br>You are currently not participating in any events<br>";
                }
                
?>