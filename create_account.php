<!DOCTYPE html>
<html>

	<?php include ('head.php'); ?>
	
	<body>
		
		<?php //include ('header.php'); ?>
		
		<section class="create-container">
			<form id="createAccount" class="wind create" method="post">
	
					<h2>Création de compte</h2>
	
					<div class="mesbox"><label for="login">Pseudo : </label><br /><input type="text" id="createLogin" /></div>
					
					<div class="mesbox"><label for="mail">Adresse email : </label><br /><input type="mail" id="createMail" /></div>
					
					<div class="mesbox"><label for="mail">Confirmation adresse email : </label><br /><input type="mail" id="createConfMail" /></div>
	
					<div class="mesbox"><label for="passwd">Mot de passe : </label><br /><input type="password" id="createPasswd" />
					<img name="helpIco" src="img/oxy.ico" height=20 width=20 title="Votre mot de passe doit comporter au minimum 8 caractères avec au moins un chiffre et une lettre."/></br></div>
		
					<div class="mesbox"><label for="confpasswd">Confirmation mot de passe : </label><br /><input type="password" name="createConfPasswd" /></div>
	
					<div><input onclick="checkAccount()" type="button" name="OK" value="OK" />
				
			</form>
		</section>
		
		<?php //include ('footer.php'); ?>
	</body>
</html>