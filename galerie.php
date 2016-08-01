<?php 
	include ('includes/header.php'); 			
		
	if (!isset($_SESSION['login'])) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
?>

		<section class="fond sect">
		<article>
			<h2>Galerie</h2>
			<div id="galerie">
				<div>
				<?php
					require('connec_db.php');
				    
						try {
						    $rep = $db->prepare('SELECT COUNT(*) FROM picture;');
						    $rep->execute();
						    $nb = $rep->fetchColumn();
						    while ($nb--){
						    	echo "<div class='zoom'><a><img class='pic_galerie' alt='Photo de galerie' style='display: none;'></a></div>";
						    }
						}
						catch(PDOException $e) {
							echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
						}
				?>
				</div>
			</div>
			<form id="arrow">
				<span class="arrow" id="left"><</span>
				<span id="page">1</span>
				<span class="arrow" id="right">></span>
				<input type="hidden" name="sheet_arrow">
			</form>
			<script type="text/javascript" src="galerie.js"></script>
		</article>
		</section>
		
		<?php include ('includes/footer.php'); ?>