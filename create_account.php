
		<?php include ('includes/header.php'); 
			if ($_SESSION)
			{
				require_once('redir.php');
				header("Location: ".adresse('index.php'));
				exit;
			}
		?>
		
		<section class="create-container">
			<form id="createAccount" class="wind create" method="post" action="validate_account.php">
	
					<h2>Création de compte</h2>
	
					<div><?php echo $doublon; ?></div>
					<div><label for="login">Login : </label><br /><input name="login" class="box" type="text" id="createLogin" /></div>
					
					<div><label for="email">Adresse email : </label><br /><input name="email" class="box" type="mail" id="createMail" /></div>
	
					<div><label for="passwd">Mot de passe : </label><br /><input name="passwd" class="box" type="password" id="createPasswd" />
					<img name="helpIco" src="img/oxy.ico" height=20 width=20 title="Votre mot de passe doit comporter au minimum 6 caractères avec au moins un chiffre et une lettre."/></br></div>
		
					<div><label for="confpasswd">Confirmation mot de passe : </label><br /><input class="box" type="password" id="createConfPasswd" /></div>

					<div><input onclick="checkAccount()" type="button" name="OK" value="OK" />
				
			</form>
		</section>
		
		<?php include ('includes/footer.php'); ?>