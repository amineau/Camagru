<?php
	session_start();
	$website_name = "Instagru";
?>

<html>
	<head>
		<title><?php echo $website_name; ?></title>
		<meta charset="utf-8" />
		<script type="text/javascript" src="script.js"></script>
		<link rel="stylesheet" type="text/css" href="index.css">
	</head>
	<body>
		<header>
			<?php 
			echo '<div><a href="index.php"><img src="img/instagru.gif" alt="logo instagru"/></a></div>';
			if (isset($_GET['ret_connect'])) {
				echo '<div>'.$_GET['ret_connect'].'</div>';
			}
			if (!isset($_SESSION['login'])){
				echo '<form method="post" action="connect_account.php">';
				echo '<a href="create_account.php">Création de compte</a>';
				echo '<div><label for="login">Login : </label><input name="login" type="text" id="connectLogin" />';
				echo '<label for="passwd">Mot de passe : </label><input name="passwd" type="password" id="connectPasswd" />';
				echo '<a href="forgot_passwd.php">Mot de passe oublié</a>';
				echo '<input type="submit" name="OK" value="OK" /></div>';
				echo '</form>';
			} else { 
				echo '<div>Bonjour '.$_SESSION['login'].'</div>';
				echo '<div><a href="update_passwd.php">Changer de mot de passe</a></div>';
				// echo '<div><a href="remove_account.php">Supprimer le compte</a></div>';
				echo '<div><a href="disconnect.php">Deconnexion</a></div>';
			}
			
			?>

		</header>
		