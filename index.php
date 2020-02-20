<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo "<script>location.href='../Views/home.php';</script>";
}

?>

<?php require_once './Views/header.php' ?>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-black">Login</h3>
                    <hr class="login-hr">
                    <p class="subtitle has-text-black">Please login to proceed.</p>
                    <?php
                        if (isset($_GET['message'])) {
                            echo "<p class=\"subtitle has-text-danger\">{$_GET['message']}</p>";
                        }
                    ?>
                    <div class="box">
                        <form method="POST" action="./Controllers/login.controller.php">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" type="text" placeholder="User name" autofocus="" name="user_name">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input placeholder="Password" name="user_password" class="input is-large" type="password">
                                </div>
                            </div>
                            
                            <button type="submit" class="button is-block is-info is-large is-fullwidth">Login <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                        </form>
                    </div>
                    <p class="has-text-grey">
                        <a href="Views/register.php">Sign Up</a> &nbsp;·&nbsp;
                        <a href="#">Forgot Password</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <script async type="text/javascript" src="../JS/bulma.js"></script>

</body>
<?php require_once './Views/footer.php' ?>