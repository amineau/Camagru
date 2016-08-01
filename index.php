<?php include ('includes/header.php'); ?>
		
		<section class="fond sect">
			<?php
				if (!isset($_SESSION['login'])){
			?>
				<article>
				<div id="create"><a href="create_account.php" >Création de compte</a></div>
					<form class="form_account" method="post" action="connect_account.php">
							<div><label for="login">Login : </label><input name="login" type="text" id="connectLogin" /></div>
							<div><label for="passwd">Mot de passe : </label><input name="passwd" type="password" id="connectPasswd" /></div>
							<a href="forgot_passwd.php">Mot de passe oublié ?</a>
							<input type="submit" class="input" name="OK" value="OK" />
							<?php
							if (isset($_GET['ret_connect'])) {
								echo '<div class="error">'.htmlentities($_GET['ret_connect']).'</div>';
							} ?>
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
							echo '</div>';
							echo '<input type="hidden" id="hid_calque" name="calque">';
							echo '<input type="hidden" id="hid_data" name="data">';
							echo '<div id="ens_video">';
							echo '<div id="superpos">';
							if (isset($_SESSION['img_up']) && !empty($_SESSION['img_up'])){
								echo '<img src='.$_SESSION['img_up'].'>';
								$_SESSION['img_up'] = "";
							} else {
								echo '<video id="video"></video>';
							}
						?>
						</div>
					</div>
					<input type="button" id="button" class="fail" value="Prendre une photo">	
					
					<canvas id="canvas"></canvas>
				</form>
					<form id="file" action="upload.php" method="post" enctype="multipart/form-data">
						<p>Pas de webcam ?<br />Vous pouvez faire un montage avec la photo de votre choix :</p>
					<?php
						if (isset($_SESSION['file_error']) && !empty($_SESSION['file_error'])) {
							echo "<p class='error'>".$_SESSION['file_error']."</p>";
							$_SESSION['file_error'] = "";
						}
					?>
						<input type="file" name="file">
						<input type="submit" class="input" name="upload" value="Valider">
					</form>
			</article>
			<script type="text/javascript" src="webcam.js"></script>
			<aside id="nav">
				<h2>Mes photos</h2>
				<div class="pic_nav">
					<div id="photos">
					<img src='img/download.gif' id='gif' class='pic_galerie' alt='download' style='display: none;'>
					<?php
						
						require('connec_db.php');
					    try {
						    $rep = $db->prepare('SELECT id, image FROM picture WHERE id_user = ? ORDER BY date_de_creation DESC;');
						    $rep->execute(array($_SESSION['id_user']));
						    while ($donnees = $rep->fetch()) {
						    	echo "<div><a href='image.php?id_pic=".$donnees['id']."'><img src='data:image/png;base64,".$donnees['image']."' class='pic_galerie' alt='".$donnees['id']."'></a></div>";
						    }
						}
						catch(PDOException $e) {
							echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
						}
					?>
					</div>
				</div>
			</aside>
				

			
			<?php 	}	?>

		</section>
		
		<?php include ('includes/footer.php'); ?>