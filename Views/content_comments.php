<?php

if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
}

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/content_comments.controller.php');


if(isset($_GET['content_id'])){
    
    $_SESSION['content_id'] = $_GET['content_id'];


}

?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php');  ?>


<body>
    <?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navbartop.php'); ?>


    <section class="section">
        <div class="container">
            <?php
            
                $content = getContentByContentId($_GET['content_id']);

                $comment_array = getCommentsByContentId($_GET['content_id']);

                $content_output =
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
                            <strong>".User::GetUserById($content->getUserId())->getUserName()."</strong>
                            <br>
                            {$content->getContent()}
                            <br>
                        </p>
                        </div>
                ";

                echo $content_output;

                foreach($comment_array as $comment){

                    $comment_output = 
                    "
                            <article class='media'>
                                <figure class='media-left'>
                                    <p class='image is-48x48'>
                                    <img src='https://bulma.io/images/placeholders/96x96.png'>
                                    </p>
                                </figure>
                                <div class='media-content'>
                                    <div class='content'>
                                    <p>
                                        <strong>".User::GetUserById($comment->getUser_id())->getUserName()."</strong>
                                        <br>
                                        {$comment->getComment_text()}
                                        <br>
                                        <small>{$comment->getCommentPostTime()}</small>
                                    </p>
                                    </div>
                                </div>
                                <form method='POST' action='../Controllers/delete_content_comment.controller.php'>
                                    <button type='submit' class='button is-right' name='delete' value='{$comment->getId()}'>Delete</button>
                                </form>
                            </article>
                   ";

                   echo $comment_output;
                }
                
                echo '</article>';
            ?>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <form method="POST" action="../Controllers/create_comment.controller.php">
                <div class='media-content'>
                    <div class='field'>
                        <p class='control'>
                            <textarea class='textarea' name="comment" placeholder='Add a comment...'></textarea>
                        </p>
                    </div>
                    <div class='field'>
                        <p class='control'>
                            <button class='button'>Post comment</button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </section>


</body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/footer.php'); ?>