<?php 
        session_start();
    	if (isset($_SESSION['login']))
		{
			require_once('function.php');
			header("Location: ".adresse('index.php'));
			exit;
		}
		include ('includes/header.php'); 
?>
	<section class="fond sect">
		<form method="post" class="form_account" action="send_passwd.php">
		   <div><label for="email">Adresse email : </label><input name="email" type="mail" /></div>
		    <input type="submit" class="input" value="Renvoyer un mot de passe" style="
    width: 220px;"/>
		</form>
	</section>
	    	
		
	<?php include ('includes/footer.php'); ?>