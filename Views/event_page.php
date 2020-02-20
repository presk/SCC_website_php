<?php // 

session_start();


//
//
//if (!isset($_SESSION['user_id'])) {
//    echo "<script>location.href='../index.php?message=Not logged in';</script>";
//}

$userID = $_SESSION['user_id'];
$requestEventID = $_POST['row_id'];
$_SESSION['event_id'] = $requestEventID;
?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/user.controller.php'); ?>
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event.controller.php'); ?>
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event_content.controller.php'); ?>
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/header.php'); ?>

<title>Event</title>

<body>
    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/navbartop.php'); ?>

	<section class="section">
        <div class="container">
            <h1 class="title"><?php echo getEventByID($requestEventID)->getName(); ?> ($<?php echo getEventByID($requestEventID)->getFee();?>)</h1>
			<h1 class="subtitle">Time: <?php echo getEventByID($requestEventID)->getLifetime(); ?></h1>
            <h1 class="subtitle"><?php echo getEventByID($requestEventID)->getDescription(); ?></h1>
			
        </div>
    </section>
	
    <section class="section">
        <div class="container">
		

            <tbody>                
                <form action="../Controllers/event.controller.php" method="POST">
                <?php
                    $event = getEventByID($requestEventID);
					
									
			if($event->getStatus() == 1){
					
				$content_array = getAllEventContentByEventId($requestEventID);
					
				if(empty($content_array)){

					echo "No content in event.";

				}else{

                foreach($content_array as $content_object){

                    echo 
                    "
                    <article class='media'>
                        <figure class='media-left'>
                            <p class='image is-64x64'>
                            <img src='https://bulma.io/images/placeholders/128x128.png'>
                            </p>
                        </figure>
                        <div class='media-content'>
                            <div class='content'>
                            <p>
                                <strong>".getUserById($content_object->getUserId())->getUserName()."</strong>
                                <br>
                                {$content_object->getContent()}
                                <br>
                                <small><a href='../Views/content_comments.php?content_id={$content_object->getId()}'>Reply</a> · {$content_object->getPostTime()}</small>
                            </p>
                            </div>
                        </div>";

                    if($userID == $event->getManagerID()){
                        echo"
                        <form method='POST' action='../Controllers/delete_event_content.controller.php'>
                            <button type='submit' class='button is-right' name='delete_post' value='{$content_object->getId()}'>Delete</button>
                        </form>";
                    }
                   echo "</article>";

				}
                }
            }
			else{
				echo '<h1>This event is archived</h1><br>
					
				It was managed by  ' . getUserById($event->getManagerId())->getUserFirstName() . ' <br>

				Fee: ' . $event->getFee();
				
			}

                
                ?>

                </form>
        </div>
        <section class="section">
            <div class="container">
            <form method="POST" action="../Controllers/create_content.controller.php">
                <textarea type="text" class="textarea" name="content" placeholder="content"></textarea>
                <br>
                <input type="submit" class="button" name="event_post" value="New Post">
            </div>
            </form>
        </section>
    </section>

</body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/footer.php');
?>
