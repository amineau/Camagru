<?php 		
	session_start();	
	if (!isset($_POST['delete'], $_POST['id_pic'])) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
	include ('includes/header.php'); 
?>
		<section>

		<?php
			require('connec_db.php');
		    
				try {
				    $rep = $db->prepare('SELECT id_user FROM picture WHERE id = ?;');
				    $rep->execute(array($_POST['id_pic']));
				    $donnees = $rep->fetch();

				    if ($donnees['id_user'] == $_SESSION['id_user']) {
						try {
							$db->beginTransaction();
						    $rep = $db->prepare('DELETE FROM picture WHERE id = ?;');
						    $rep->execute(array($_POST['id_pic']));
						    $rep = $db->prepare('DELETE FROM likes WHERE id_pic = ?;');
						    $rep->execute(array($_POST['id_pic']));
						    $rep = $db->prepare('DELETE FROM comments WHERE id_pic = ?;');
						    $rep->execute(array($_POST['id_pic']));
						    $db->commit();
						    $aff = "L'image a bien été supprimée.";
						}
						catch(PDOException $e) {
							$db->rollBack();
							$aff = 'Connexion échouée : ' . $e->getMessage();
						}
					} else {
						$aff = "Vous n'êtes pas autorisé à supprimer cette image.";
					}
				}
				catch(PDOException $e) {
					$aff = 'Connexion échouée : ' . $e->getMessage();
				}
				
				echo "<p>".$aff."</p>";

		?>

				
		</section>
		
		<?php include ('includes/footer.php'); ?>