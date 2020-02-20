

<?php require_once './header.php' ?>
<title>Register</title>


<body>
      <section class="section">
        <form action="../Controllers/register.controller.php" method="POST" name="registerForm">
         <div class="columns">
            <div class="column is-4 is-offset-4">
               <div class="field">
                  <label class="label">First Name</label>
                  <div class="control">
                     <input class="input" type="text" placeholder="" name="user[first_name]">
                  </div>
               </div>
               <div class="field">
                  <label class="label">Last Name</label>
                  <div class="control">
                     <input class="input" type="text" placeholder="" name="user[last_name]">
                  </div>
               </div>
               <div class="field">
                  <label class="label">Street Number</label>
                  <div class="control">
                     <input class="input" type="text" placeholder="Number" name="user[street_number]">
                  </div>
               </div>
               <div class="field">
                  <label class="label">Apt Number</label>
                  <div class="control">
                     <input class="input" type="text" placeholder="Apt Number" name="user[apt_number]">
                  </div>
               </div>
               <div class="field">
                  <label class="label">Street Name</label>
                  <div class="control">
                     <input class="input" type="text" placeholder="Street Name" name="user[street_name]">
                  </div>
               </div>
               <div class="field">
                  <label class="label">City</label>
                  <div class="control">
                     <input class="input" type="text" placeholder="City" name="user[city]">
                  </div>
               </div>
               <div class="field">
                  <label class="label">Date of Birth</label>
                  <div class="control">
                     <input class="input" type="date" name="user[bday]">
                  </div>
               </div>
               <div class="field">
                  <label class="label">Email</label>
                  <div class="control has-icons-left has-icons-right">
                     <input class="input is-success" type="email" placeholder="Email input" value="address@email.com" name="user[email]">
                     <span class="icon is-small is-left">
                     <i class="fa fa-envelope"></i>
                     </span>
                  </div>
                  
               </div>
               <div class="field">
                  <label class="label">Username</label>
                  <div class="control has-icons-left has-icons-right">
                     <input class="input is-success" type="text" placeholder="username" name="user[user_name]">
                     <span class="icon is-small is-left">
                     <i class="fa fa-user"></i>
                     </span>
                  </div>
               </div>
               <div class="field">
                  <label class="label">Password</label>
                  <div class="control">
                     <input class="input" type="password" placeholder="" name="user[user_password]">
                  </div>
               </div>
               <div class="field">
                    <div class="control">
                        <label class="checkbox">
                            <input type="checkbox">
                                I agree to the <a href="javascript:NewTab()">Terms and Conditions</a>
                        </label>
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
      <script> 
        function NewTab() { 
            window.open( 
              "terms.php", "_blank"); 
        } 
    </script> 
   </body>

<script async type="text/javascript" src="../JS/bulma.js"></script>
<script async type="text/javascript" src="../JS/formValidation.js"></script>
<?php require_once './footer.php' ?>

<!-- doc: https://bulma.io/documentation/form/general/# -->
