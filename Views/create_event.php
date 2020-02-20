<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/create_event.controller.php');

?>

<?php require_once './header.php' ?>
<title>Create Event</title>
<body>
<?php require_once './navbartop.php' ?>


<section class="section">
    <form action="../Views/create_event.php" method="POST" name="form">
     	<div class="columns">
	        <div class="column is-4 is-offset-4">
	           		<div class="field">
		           	<label class="label">Manager</label>
			            <div class="control">
			                 <select name="event[manager]" style="padding-right: 100px">
	                                <?php
	                                 			//Don't tell PK I stole his code
	                                 			//Drop-down user list
	                                            //Only populated by Users who are not part of the current event

	                                            $completeUserList = User::GetAllUsers();
	                                            
	                                            //Get all users (All users in the system)
	                                            foreach ($completeUserList as $user) {
	                                                $userName = $user->getUserName();
	                                                $user_ID = $user->getID();
	                                                echo '<option value="' . $user_ID . '"'.'>' . $userName . '</option>';
	                                       		}
	                                ?>
	                        </select>               
		            	</div>
		            </div>
		            <div class="field">
			            <label class="label">Event Name</label>
			            <div class="control">
			                 <input class="input" type="text" name="event[event_name]" required>
			            </div>
			        </div>
			        <div class="field">
			            <label class="label">Fee</label>
			            <div class="control">
			                 <input class="input" type="number" name="event[fee]" required>
			            </div>
			        </div>
			        <div class="field">
			            <label class="label">Description</label>
			            <div class="control">
			                 <input class="input" type="text" name="event[description]" required>
			            </div>
			        </div>
			        <div class="field">
	 					<label class="label">Lifetime</label>
						<div class="control">
						 	<input class="input" type="date" name="event[lifetime]" required>
						</div>
					</div>
		            <div class="field">
						<label class="checkbox">
					      <input type="checkbox" name="event[recur]" value="true">
					      Recurring
					    </label>
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