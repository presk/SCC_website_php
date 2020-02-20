<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Controllers/event.controller.php'); ?>
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/user_controller.controller.php');?>
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/header.php'); ?>

<title>Set Charges</title>
<body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/Views/navbartop.php'); ?>

    <section class="section">
        <div class="container">
            <div class="column is-9">
               

                <?PHP
                
                $eventList = getAllEvents(false);
                
                if(!empty($eventList)){

                    echo "
                    
                    <table class='table' >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Lifetime</th>
                                <th>Recurring</th>
                                <th>Description</th>
                                <th>Fee($)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <form action='' method='POST'>
                    ";
                    foreach($eventList as $event) {
                            $dollarsign = '$';
                            echo '
                                 <div class="content">
                                    <tr>
                                        <form method="POST">
                                        <td>' . $event->getName() . '</td>
                                        <td>' . $event->getID() . '</td>
                                        <td>' . $event->getStatus() . '</td>
                                        <td>' . $event->getLifetime() . '</td>
                                        <td>' . $event->getRecurring() . '</td>
                                        <td>' . $event->getDescription() . '</td>
										<td><input type="text" size="3" name="charge" value='.$event->getFee().'></td>
                                        <td><small><input type="submit" class="button" value="Set Fee"></small></td>
                                            <input type="hidden" value="' . $event->getId() . '" name="row_id">
                                        
                                    </tr>
										 					
								';
                    }
                    echo "  
                        </form>
                        </tbody>
                        </table>
                        ";
                }
                
                ?>
                          
            </div>
        </div>
    </section>

    <script async type="text/javascript" src="../JS/bulma.js"></script>
</body>
</html>