 <!-- START NAV -->
 <nav class="navbar is-white topNav">
			<div class="container">
				<div class="navbar-brand">
					<a class="navbar-item" href="../">
						<img src="/Images/Concordia.jpg" width="112" height="28"><!--FIX PATH-->
					</a>
					<div class="navbar-burger burger" data-target="topNav">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>
				<div id="topNav" class="navbar-menu">
					<div class="navbar-start">
						<a class="navbar-item" href="home.php">Home</a>
						<a class="navbar-item" href="event_main.php">Events</a>
						<a class="navbar-item" href="group.php">Groups</a>
						<a class="navbar-item" href="inbox.php">Inbox</a>
						<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navadmin.php'); ?>
					</div>
					<div class="navbar-end">
						<div class="navbar-item">
							<div class="field is-grouped">
								<p class="control">
									<a href="account.php" class="button is-small is-info is-outlined">My Account</a>
									<form method="POST" action="../Controllers/logout.controller.php">
										<input class="button is-small is-info is-outlined" type="submit" name="logout" value="Logout">
									</form>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
	</nav>
	<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Views/navadmin.php'); ?>
    <!-- END NAV -->