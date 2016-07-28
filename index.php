
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
				<form>
					<div id="calque">
						<?php
							$liste_img = array_splice(scandir('img/calque'), 2);
							foreach ($liste_img as $file) {
								$name = strstr($file, '.', true);
								echo "<img src='img/calque/".$file."' id='".$name."' name='calque_png' alt='".$name."' width='100'>";
							}
						?>	
					</div>
					<input type="hidden" id="hid_calque" name="calque">
					<div id="superpos"><video id="video"></video></div>
					<script type="text/javascript" src="montage.js"></script>
					<button id="button" name="data" formaction="pic_picture.php" formmethod="post">Souriez</button>
					
					<canvas id="canvas"></canvas>
					<?php
						if (isset($previsual)) {
							echo "<img src='data:image/png;base64,".base64_encode($previsual)."' id='photo' alt='photo'>";
						}
					?>
					<button id="save" name="data" formaction="save_picture.php" formmethod="post">Sauvegarder</button>
					<script type="text/javascript" src="webcam.js"></script>
				</form>
			</article>
			<aside>
				<h2>Mes photos</h2>
				<?php
					require('connec_db.php');
    
				    try {
					    $rep = $db->prepare('SELECT id, image FROM picture WHERE id_user = ? ORDER BY date_de_creation DESC LIMIT 8;');
					    $rep->execute(array($_SESSION['id_user']));
					    while ($donnees = $rep->fetch()) {
					    	echo "<img src='data:image/png;base64,".$donnees['image']."' width='200' id='new_pic' alt='".$donnees['id']."'>";
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