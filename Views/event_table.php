<?php
                require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event.controller.php');
                $userID = $_SESSION['user_id'];
                $eventList = getAllUserManagedEvents($userID);
                
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

                    echo "<tr>
                                <td>You are currently not managing any events.</td>
                            </tr>";
                }
                
?>