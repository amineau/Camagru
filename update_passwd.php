<?php 
        include ('includes/header.php'); 
    	if (!$_SESSION)
		{
			require_once('function.php');
			header("Location: ".adresse('index.php'));
			exit;
		}
?>
		<form id="updateAccount" method="post" action="update_verif.php">
		    <div><label for="old_passwd">Ancien mot de passe : </label><br /><input class="box" name="old_passwd" id="old_passwd" type="password" /></div>
		    <div><label for="new_passwd">Nouveau mot de passe : </label><br /><input class="box" name="new_passwd" id="new_passwd"type="password" /></div>
		    <div><label for="conf_passwd">Confirmation mot de passe : </label><br /><input class="box" name="conf_passwd" id="conf_passwd"type="password" /></div>
		    <div><input onclick="checkUpdate()" type="button" name="OK" value="OK" />
		</form>
	    	
		
	<?php include ('includes/footer.php'); ?>