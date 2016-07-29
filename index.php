
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
			<article>
				<form id="montage" action="save_picture.php" method="post">
					<div id="calque">
						<?php
							$liste_img = array_splice(scandir('img/calque'), 2);
							foreach ($liste_img as $file) {
								$name = strstr($file, '.', true);
								echo "<img src='img/calque/".$file."' id='".$name."' name='calque_png' class='ajout' alt='".$name."'>";
							}
						?>	
					</div>
					<input type="hidden" id="hid_calque" name="calque">
					<input type="hidden" id="hid_data" name="data">
					<div id="superpos"><video id="video"></video></div>
					<button id="button" style="display: none;">Prendre une photo</button>	
					<script type="text/javascript" src="montage.js"></script>
					<canvas id="canvas"></canvas>
				</form>
			</article>
			<script type="text/javascript" src="webcam.js"></script>
			<aside class="nav">
				<h2>Mes photos</h2>
				<?php
					require('connec_db.php');
    
				    try {
					    $rep = $db->prepare('SELECT id, image FROM picture WHERE id_user = ? ORDER BY date_de_creation DESC;');
					    $rep->execute(array($_SESSION['id_user']));
					    while ($donnees = $rep->fetch()) {
					    	echo "<a href='image.php?id_pic=".$donnees['id']."'><img src='data:image/png;base64,".$donnees['image']."' class='pic_galerie' alt='".$donnees['id']."'></a>";
					    }
					}
					catch(PDOException $e) {
						echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
					}
				?>	
			</aside>

			
			<?php 	}	?>

		</section>
		
		<?php include ('includes/footer.php'); ?>