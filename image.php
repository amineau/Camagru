<?php 

	include ('includes/header.php'); 			
		
	if (!isset($_SESSION['login']) || !isset($_GET['id_pic'])) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
?>
		<section>

		<?php
			require('connec_db.php');
		    
				try {
				    $rep = $db->prepare('SELECT image, id_user FROM picture WHERE id = ?;');
				    $rep->execute(array($_GET['id_pic']));
				    $donnees = $rep->fetch();

				    if (isset($donnees['image'])) {
				    	echo "<img src='data:image/png;base64,".$donnees['image']."' id='pic' alt='Photo'>";
					} else {
						echo "<p>Cette image n'existe pas !</p>";
					}
					if ($donnees['id_user'] == $_SESSION['id_user']) {
						echo '<form action="remove_pic.php" method="post">';
						echo '<input type="hidden" name="id_pic" value="'.$_GET['id_pic'].'">';
						echo '<input type="submit" name="delete" value="Supprimer">';
						echo '</form>';
					}
				}
				catch(PDOException $e) {
					echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
				}

				
		?>

				
		</section>
		
		<?php include ('includes/footer.php'); ?>