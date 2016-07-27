<?php 
        include ('includes/header.php'); 
    	if ($_SESSION)
		{
			require_once('function.php');
			header("Location: ".adresse('index.php'));
			exit;
		}
?>
		<form method="post" action="send_passwd.php">
		   <div><label for="email">Adresse email : </label><br /><input name="email" type="mail" /></div>
		    <input type="submit" value="Renvoyer un mot de passe"/>
		</form>
	    	
		
	<?php include ('includes/footer.php'); ?>