
		<?php include ('includes/header.php'); ?>
		
		<section>
			<?php
				if (!isset($_SESSION['login'])){
			?>
				<article>
					<form method="post" action="connect_account.php">
						<a href="create_account.php">Création de compte</a>
						<div>
							<label for="login">Login : </label><input name="login" type="text" id="connectLogin" />
							<label for="passwd">Mot de passe : </label><input name="passwd" type="password" id="connectPasswd" />
							<a href="forgot_passwd.php">Mot de passe oublié</a>
							<input type="submit" name="OK" value="OK" />
						</div>
					</form>
				</article>

			<?php	} else {	?>
			
			<form action="upload.php" method="post" enctype="multipart/form-data">
				<input type="file" name="file">
				<input type="submit" name="upload" value="Valider">
			<?php
				if (isset($_SESSION['file_error']) && !empty($_SESSION['file_error'])) {
					echo "<div class='error'>".$_SESSION['file_error']."</div>";
					$_SESSION['file_error'] = "";
				}
			?>
			</form>
		</section>
		<section>
			<article>
				<form id="montage" action="save_picture.php" method="post">
					<div id="calque">
						<?php
							$liste_img = array_splice(scandir('img/calque'), 2);
							foreach ($liste_img as $file) {
								$name = strstr($file, '.', true);
								echo "<img src='img/calque/".$file."' id='".$name."' name='calque_png' class='ajout' alt='".$name."'>";
							}
							echo '</div>';
							echo '<input type="hidden" id="hid_calque" name="calque">';
							echo '<input type="hidden" id="hid_data" name="data">';
							echo '<div id="superpos">';
							if (isset($_SESSION['img_up']) && !empty($_SESSION['img_up'])){
								echo '<img src='.$_SESSION['img_up'].'>';
								$_SESSION['img_up'] = "";
							} else {
								echo '<video id="video"></video>';
							}
						?>
					</div>
					<button id="button" style="display: none;">Prendre une photo</button>	
					<script type="text/javascript" src="montage.js"></script>
					<canvas id="canvas"></canvas>
				</form>
			</article>
			<script type="text/javascript" src="webcam.js"></script>
			<aside id="nav">
				<h2>Mes photos</h2>
				<div id="photos">
				<img src='img/download.gif' id='gif' class='pic_galerie' alt='download' style='display: none;'>
				<?php
					
					require('connec_db.php');
				    try {
					    $rep = $db->prepare('SELECT id, image FROM picture WHERE id_user = ? ORDER BY date_de_creation DESC;');
					    $rep->execute(array($_SESSION['id_user']));
					    while ($donnees = $rep->fetch()) {
					    	echo "<div class='pic_nav'><a href='image.php?id_pic=".$donnees['id']."'><img src='data:image/png;base64,".$donnees['image']."' class='pic_galerie' alt='".$donnees['id']."'></a></div>";
					    }
					}
					catch(PDOException $e) {
						echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
					}
				?>
				</div>
			</aside>

			
			<?php 	}	?>

		</section>
		
		<?php include ('includes/footer.php'); ?>