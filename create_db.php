<?php 
	session_start();
	if (isset($_SESSION['login']) || file_exists("config/db_info"))
	{
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
	include ('includes/header.php'); 
?>

		<section class="fond sect compte">
			<h2>Configuration de la base de donnée</h2>
			<form id="createDb" class="form_account" method="post" action="validate_db.php">
	
					
					<div><label for="hostName">Host : </label><input name="hostName" class="box" type="text" id="hostName" value="localhost"></div>
					
					<div><label for="dbName">Database : </label><input name="dbName" class="box" type="text" id="dbName" value="camagru"></div>
	
					<div><label for="user">User : </label><input name="user" class="box" type="text" id="user" value="root">
					</div>
		
					<div><label for="passwd">Password : </label><input name="passwd" class="box" type="password" id="passwd" value="root"></div>

					<div><input onclick="checkDb();" id="db_create" type="button" class="input" name="OK" value="OK"></div>
				
			</form>
			<?php 
				if (isset($_GET['error'])) {
					echo "<div class='error'>".htmlentities($_GET['error'])."</div>";
				}
			?>
		</section>
		
		<?php include ('includes/footer.php'); ?>