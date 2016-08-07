<?php
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
			echo '<a href="index.php" class="logo"><img src="img/Instagru.png" id="ico" alt="logo instagru">';
			echo '<h1>Instagru</h1></a>';
			if (isset($_SESSION['login'])) { 
			?>
				<nav class="fond">
					<ul id="menu">
						<li><a href="#" class="button">Mon compte</a>
							<ul class ="fond">
								<li><a href="update_passwd.php" class="button" >Changer de mot de passe</a></li>
								<li><a href="disconnect.php" class="button" >Deconnexion</a></li>
							</ul>
						</li>
						<li><a href="index.php" class="button">Montage</a></li>
						<li><a href="galerie.php" class="button">Galerie</a></li>
					</ul>
				</nav>
				<script type="text/javascript">
					(function(){
						var menu = document.getElementById("menu").firstChild;

						menu.onmouseover = function(){
							this.className += "agran";
						}
						menu.onmouseout = function(){
							this.className = this.className.replace(new RegExp(" sfhover\b"), "");
						}
					})();
				</script>
		<?php	}	?>

		</header>
		