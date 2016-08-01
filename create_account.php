<?php include ('includes/header.php'); 
			if (isset($_SESSION['login']))
			{
				require_once('function.php');
				header("Location: ".adresse('index.php'));
				exit;
			}
		?>
		
		<section class="fond sect compte">
			<h2>Création de compte</h2>
			<form id="createAccount" class="form_account" method="post" action="validate_account.php">
	
					
					<div><label for="login">Login : </label><input name="login" class="box" type="text" id="createLogin"></div>
					
					<div><label for="email">Adresse email : </label><input name="email" class="box" type="mail" id="createMail"></div>
	
					<div><img name="helpIco" src="img/oxy.ico" height=15 title="Votre mot de passe doit comporter au minimum 6 caractères avec au moins un chiffre et une lettre."><label for="passwd"> Mot de passe : </label><input name="passwd" class="box" type="password" id="createPasswd">
					</div>
		
					<div><label for="confpasswd">Confirmation mot de passe : </label><input class="box" type="password" id="createConfPasswd"></div>

					<div><input onclick="checkAccount();" id="conf_create" type="button" class="input" name="OK" value="OK">
				
			</form>
			<?php 
						if (isset($_GET['doublon'])) {
							echo "<div class='error'>".$_GET['doublon']."</div>";
						}
			?>
		</section>
		
		<?php include ('includes/footer.php'); ?>