<?php 

	include ('includes/header.php'); 			
		
	if (!isset($_SESSION['login'])) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
?>
		<section>

		<?php
			require('connec_db.php');
		    
				try {
				    $rep = $db->prepare('SELECT id, image FROM picture ORDER BY date_de_creation DESC;');
				    $rep->execute();
				    while ($donnees = $rep->fetch()) {
				    	echo "<a href='image.php?id_pic=".$donnees['id']."'><img src='data:image/png;base64,".$donnees['image']."' width='200' id='new_pic' alt='Photo de galerie'></a>";
				    }
				}
				catch(PDOException $e) {
					echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
				}
		?>
				
		</section>
		
		<?php include ('includes/footer.php'); ?>