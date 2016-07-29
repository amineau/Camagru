<?php 

	include ('includes/header.php'); 			
		
	if (!isset($_SESSION['login'])) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
?>

		<section>
		<article>
			<div id="galerie">
				<div>
				<?php
					require('connec_db.php');
				    
						try {
						    $rep = $db->prepare('SELECT id, image FROM picture ORDER BY date_de_creation DESC;');
						    $rep->execute();
						    while ($donnees = $rep->fetch()) {
						    	echo "<a href='image.php?id_pic=".$donnees['id']."'><img src='data:image/png;base64,".$donnees['image']."' class='pic_galerie' alt='Photo de galerie' style='display: none;'></a>";
						    }
						}
						catch(PDOException $e) {
							echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
						}
				?>
				</div>
			</div>
			<form id="arrow">
				<img src="img/arrow.png" class="arrow" id="left">
				<span id="page">1</span>
				<img src="img/arrow.png" class="arrow" id="right">
				<input type="hidden" name="sheet_arrow">
			</form>
			<script type="text/javascript" src="galerie.js"></script>
		</article>
		</section>
		
		<?php include ('includes/footer.php'); ?>