<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/home.controller.php');

/*if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='../index.php?message=Not logged in';</script>";
} else {
    require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Models/Content.php');

    $content = Content::GetMainFeed($_SESSION['user_id']);
}*/



?>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/header.php'); ?>

<title>Home</title>
<body>

<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navbartop.php'); ?>

		<section class="container">
		<div class="columns">
            <div class="column is-6">
                <div class="card events-card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Events you are managing
                        </p>
                    </header>
                    <div class="card-table">
                        <div class="content">
                            <table class="table is-fullwidth is-striped">
                                 <tbody>
									<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/event_table.php');?>   
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <footer class="card-footer">
                            <a href="event_main.php" class="card-footer-item">View All</a>
                        </footer>
                </div>
            </div>
			<div class="column is-6">
                <div class="card events-card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Events you are a part of
                        </p>
                    </header>
                    <div class="card-table">
                        <div class="content">
                            <table class="table is-fullwidth is-striped">
                                 <tbody>
									<?php require(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/event_table_partic.php');?>   
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <footer class="card-footer">
                            <a href="event_main.php" class="card-footer-item">View All</a>
                        </footer>
                </div>
            </div>
		</div>
		<div class="columns">
			<div class="column is-6">
                <div class="card events-card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Groups you are managing
                        </p>
                    </header>
                	<div class="card-table">
                    	<div class="content">
                        	<table class="table is-fullwidth is-striped">
                            	<tbody>
									<?php require(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/group_table.php');?>
                            	</tbody>
                        	</table>
                    	</div>
                	</div>
                	<footer class="card-footer">
                    	<a href="group.php" class="card-footer-item">View All</a>
                	</footer>
            	</div>
        	</div>
			<div class="column is-6">
                <div class="card events-card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Groups you are a part of
                        </p>
                    </header>
                	<div class="card-table">
                    	<div class="content">
                        	<table class="table is-fullwidth is-striped">
                            	<tbody>
									<?php require(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/group_table_partic.php');?>
                            	</tbody>
                        	</table>
                    	</div>
                	</div>
                	<footer class="card-footer">
                    	<a href="group.php" class="card-footer-item">View All</a>
                	</footer>
            	</div>
        	</div>
		</div>

        <hr>

        <!--- Main feed output --->
        <?php
            if(!empty($content)){
        ?>
       <section class="container">

            <section class="hero is-info">
              <div class="hero-body">
                <div class="container">
                  <h1 class="title">
                    Main Content Feed
                  </h1>
                </div>
              </div>
            </section>

        <div class="box">
        <?php
                //Don't tell xavier I stole his code
                foreach($content as $content_object){

                    $output = 
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
                                <strong>". User::GetUserById($content_object->getUserId())->getUserName() ."</strong>
                                <br>
                                {$content_object->getContent()}
                                <br>
                                <small><a href='../Views/content_comments.php?content_id={$content_object->getId()}'>Reply</a> · {$content_object->getPostTime()}</small>
                            </p>
                            </div>
                        </div>
                    </article>
                    ";

                    echo $output;
                }

        ?>
        </div>

        <?php 
            } else { 
        ?>
                <section class="hero is-warning">
                  <div class="hero-body">
                    <div class="container">
                      <h1 class="title">
                        There is no content to show!
                      </h1>
                    </div>
                  </div>
                </section>
        <?php
            }
        ?>
        </section>
		<script async type="text/javascript" src="../JS/bulma.js"></script>
	</body>
<?php require_once './footer.php' ?>
