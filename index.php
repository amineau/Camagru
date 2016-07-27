
		<?php include ('includes/header.php'); ?>
		
		<section>
			<form>
				<div class="calque">
					<?php
						$liste_img = array_splice(scandir('img/calque'), 2);
						foreach ($liste_img as $file) {
							$name = strstr($file, '.', true);
							echo "<input type='radio' name='calque' value='".$file."'><img src='img/calque/".$file."' alt='".$name."' ></input>";
						}
					?>
				</div>
				<video id="video"></video>
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
		</section>
		
		<?php include ('includes/footer.php'); ?>