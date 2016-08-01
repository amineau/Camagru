<?php 
        include ('includes/header.php'); 
    	if (!isset($_SESSION['login']))
		{
			require_once('function.php');
			header("Location: ".adresse('index.php'));
			exit;
		}
?>
	<section class="fond sect">
		<form class="form_account" id="updateAccount" method="post" action="update_verif.php">
		    <div><label for="old_passwd">Ancien mot de passe : </label><input class="box" name="old_passwd" id="old_passwd" type="password" /></div>
		    <div><img name="helpIco" src="img/oxy.ico" height=15 title="Votre mot de passe doit comporter au minimum 6 caractères avec au moins un chiffre et une lettre."><label for="new_passwd"> Nouveau mot de passe : </label><input class="box" name="new_passwd" id="new_passwd"type="password" /></div>
		    <div><label for="conf_passwd">Confirmation mot de passe : </label><input class="box" name="conf_passwd" id="conf_passwd"type="password" /></div>
		    <div><input onclick="checkUpdate()" type="button" class="input" name="OK" value="OK" /></div>
		</form>
	   </section>
		
	<?php include ('includes/footer.php'); ?>