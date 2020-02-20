<?php

if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/inbox.controller.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/user.controller.php');


?>
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php'); ?>

<title>Inbox</title>

<body>
    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navbartop.php'); ?>

    <section class="section">
        <div class="container">
            <p class="title">Your Messages</p>

            <form action="../Controllers/inbox.controller.php" method="POST">

                <?php

        $messages = getMessagesByUserId($_SESSION['user_id']);

        if(empty($messages)){
            echo "<p class='subtitle'>Inbox empty. You have no messages.</p>";
        }else{

            echo "        
                <table class='table'>
                    <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Message</th>
                        <th>Time Sent</th>
                        <th>Delete</th>

                    </tr>
                    </thead>
                    <tbody>
            ";

            foreach($messages as $message){

                if(!$message->getSoftDelete()){
                    echo "
                    <tr>
                        <td>".getUserByUserId($message->getSourceId())->getUserName()."</td>
                        <td>{$message->getText()}</td>
                        <td>{$message->getSentTime()}</td>
                        <td><button class='button' type='submit' name='delete' value='{$message->getId()}'>Delete Message</button></td>
                    </tr>
                    ";

                }

            }

            echo "
                    </tbody>
                </table>
            ";
        }


    ?>
            </form>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <p class="title">Sent Messages</p>
            <form action="../Controllers/inbox.controller.php" method="POST">

                <?php

                $sent_messages = getSentMessagesByUserId($_SESSION['user_id']);

                if(empty($sent_messages)){
                    echo "<p class='subtitle'>Outbox is empty</p>";
                }else{

                    echo "        
                        <table class='table'>
                            <thead>
                            <tr>
                                <th>Sent to</th>
                                <th>Message</th>
                                <th>Time Sent</th>
                                <th>Archive</th>
                            </tr>
                            </thead>
                            <tbody>
                    ";

                    
                    foreach($sent_messages as $message){

                        if(!$message->getArchiveDelete()){
                            echo "
                            <tr>
                                <td>".getUserByUserId($message->getDestId())->getUserName()."</td>
                                <td>{$message->getText()}</td>
                                <td>{$message->getSentTime()}</td>
                                <td><button class='button' type='submit' name='archive' value='{$message->getId()}'>Archive Message</button></td>
                            </tr>
                            ";
                        
                        }

                    }

                    echo "
                            </tbody>
                        </table>
                    ";
                }


            ?>
            </form>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <p class="title">Send Message</p>

            <form action="../Controllers/inbox.controller.php" method="POST">
                <div class="field">
                    <label class="label">Recipient Username</label>
                    <div class="select">
                        <select name="recipient">

                            <?php

                                $all_users = getAllUsers();

                                if(empty($all_users)){

                                }else{
                                    foreach($all_users as $user){
                                        echo "<option value='{$user->getID()}'>{$user->getUserName()}</option>";
                                    }
                                }
                            ?>

                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Message</label>
                    <div class="control">
                        <textarea name="message" class="textarea" placeholder="Textarea"></textarea>
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-link">Submit</button>
                    </div>
                    <div class="control">
                        <button type="reset" class="button is-link is-light">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

</body>

<?php require_once './footer.php' ?>