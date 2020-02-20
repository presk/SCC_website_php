<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    echo "<script>location.href='../index.php?message=You need to login.';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/group.controller.php'); 
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/event.controller.php'); 



?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php');?>


<body>
    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navbartop.php');?>

    <section class="section">
        <form method="POST" action="../Controllers/create_group.controller.php">
            <div class="container">
                <div class="field">
                    <label class="label">Group Name</label>
                    <div class="control">
                        <input name="group[group_name]" type="text" class="input" placeholder="Name your group">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Group Description</label>
                    <div class="control">
                        <input name="group[group_desc]" type="text" class="input" placeholder="">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Event</label>
                    <div class="control">
                        <div class="select">
                            <select name="event">

                                <?php

                            $participated_events = getAllUserParticipatingEvents($_SESSION['user_id']);
			                $managed_events = getAllUserManagedEvents($_SESSION['user_id']);
			                $all_events = array_merge($participated_events, $managed_events);
							
			                usort($all_events, function($a, $b){ return strcmp($a->getId(), $b->getId()); });

                            if(empty($all_events)){
                                
                            }else{
                                foreach($all_events as $event){
                                    echo "<option value='{$event->getId()}'>{$event->getName()}</option>";
                                }
                            }
                        ?>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <input type="submit" class="button is-link" value="Submit">
                    </div>
                    <div class="control">
                        <a class="button is-link is-light" href="./group.php">Cancel</a>
                    </div>
                </div>
            </div>
        </form>

    </section>

</body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/footer.php');?>