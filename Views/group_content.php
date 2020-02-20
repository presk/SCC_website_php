<?php

if(!isset($_SESSION)){ 
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php');

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/group_content.controller.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/group.controller.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/user.controller.php');

//Bind the Group Id for use in create_content.controller.php
if(isset($_GET['group_id'])){
    $_SESSION['group_id'] = $_GET['group_id'];
}

?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php'); ?>

<title>Group</title>

<body>
    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navbartop.php'); ?>

    <section class="section">
        <div class="container">
            <h1 class="title"><?php echo getGroupByGroupId($_SESSION['group_id'])->getName(); ?></h1>
            <h1 class="subtitle"><?php echo getGroupByGroupId($_SESSION['group_id'])->getDescription(); ?></h1>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h1 class="title">Group Posts</h1>
        <?php


            $content_array = getAllGroupContentByGroupId($_GET['group_id']);


            if(empty($content_array)){

                echo "No content in group.";

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
                    if($userID == getGroupbyGroupId($_GET['group_id'])->getManagerID()){
                        echo"
                        <form method='POST' action='../Controllers/delete_group_content.controller.php'>
                            <button type='submit' class='button is-right' name='delete' value='{$content_object->getId()}'>Delete</button>
                        </form>";
                    }

                    echo "</article>
                    ";

                }
            }

        ?>
        </div>
        </section>

        <section class="section">
            <div class="container">
            <form method="POST" action="../Controllers/create_content.controller.php">
                <textarea type="text" class="textarea" name="content" placeholder="content"></textarea>
                <br>
                <input type="submit" class="button" name="group_post" value="New Post">
            </div>
            </form>
        </section>

</body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/footer.php');
 ?>

 