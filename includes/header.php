<?php
	session_start();
	$website_name = "Instagru";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $website_name; ?></title>
		<meta charset="utf-8" />
		<script type="text/javascript" src="functions.js"></script>
		<link rel="stylesheet" type="text/css" href="index.css">
	</head>
	<body>
		<header>
			<?php 
			echo '<div><a href="index.php"><img src="img/instagru.gif" alt="logo instagru"/></a></div>';
			if (isset($_GET['ret_connect'])) {
				echo '<div>'.$_GET['ret_connect'].'</div>';
			}
			if (isset($_SESSION['login'])) { 
				echo '<div>Bonjour '.$_SESSION['login'].'</div>';
				echo '<div><a href="update_passwd.php">Changer de mot de passe</a></div>';
				// echo '<div><a href="remove_account.php">Supprimer le compte</a></div>';
				echo '<div><a href="disconnect.php">Deconnexion</a></div>';
				echo '<nav><ul>';
				echo '<li><a href="galerie.php">Galerie</a></li>';
				echo '<li><a href="index.php">Montage</a></li>';
				echo '</ul></nav>';
			}
			
			?>

		</header>
		