<?php
//session_start();
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/account.controller.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/user.controller.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='./index.php';</script>";
}else{
    //Begin passsing account data here.
}
$userID = $_SESSION['user_id'];
$user = getUserbyID($userID);

$apt = $user->getAptNumber();

if($apt === 0){
   $apt = "";
}

?>

<?php require_once './header.php' ?>
<title>My Account</title>
<body>
<?php require_once './navbartop.php' ?>
   

<?php
if(isset($_POST['message'])){
   $message = $_POST['message'];
?>
            <section class="hero is-success">
              <div class="hero-body">
                <div class="container">
                  <h1 class="title">
                    <?=$message?>
                  </h1>
                </div>
              </div>
            </section>
<?php
   }
?>


<section class="section">
        <form action="../Views/account.php" method="POST" name="form">
         <div class="columns">
            <div class="column is-4 is-offset-4">
               <div class="field">
                  <label class="label">First Name</label>
                  <div class="control">
                     <?php echo '<input class="input" type="text" value="'.$user->getUserFirstName().'" name="user[first_name]" required>';?>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Last Name</label>
                  <div class="control">
                     <?php echo '<input class="input" type="text" value="'.$user->getUserLastName().'" name="user[last_name]" required>';?>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Street Number</label>
                  <div class="control">
                     <?php echo '<input class="input" type="text" value="'.$user->getAddrNumber().'" name="user[street_number]" required>';?>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Apt Number</label>
                  <div class="control">
                     <?php echo '<input class="input" type="text" value="'.$apt.'" name="user[apt_number]">';?>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Street Name</label>
                  <div class="control">
                     <?php echo '<input class="input" type="text" value="'.$user->getStreet().'" name="user[street_name]" required>';?>
                  </div>
               </div>
               <div class="field">
                  <label class="label">City</label>
                  <div class="control">
                     <?php echo '<input class="input" type="text" value="'.$user->getCity().'" name="user[city]" required>';?>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Date of Birth</label>
                  <div class="control">
                     <?php echo '<input class="input" type="date" value="'.$user->getUserBday().'" name="user[bday]" required>';?>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Email</label>
                  <div class="control has-icons-left has-icons-right">
                     <?php echo '<input class="input" type="email" value="'.$user->getUserEmail().'" name="user[email]" required>';?>
                     <span class="icon is-small is-left">
                     <i class="fa fa-envelope"></i>
                     </span>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Username</label>
                  <div class="control has-icons-left has-icons-right">
                     <?php echo '<input class="input" type="text" value="'.$user->getUsername().'" name="user[user_name]" required>';?>   
                     <span class="icon is-small is-left">
                     <i class="fa fa-user"></i>
                     </span>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Password</label>
                  <div class="control">
                     <input class="input" type="password" placeholder="" name="user[user_password]" required>
                  </div>
               </div>
               <div class="field is-grouped">
                  <div class="control">
                     <button class="button is-link">Submit</button>
                  </div>
               </div>
            </div>
         </div>
        </form>
      </section>
    
<script async type="text/javascript" src="../JS/bulma.js"></script>
<script async type="text/javascript" src="../JS/formValidation.js"></script>

</body>
<?php require_once './footer.php' ?>