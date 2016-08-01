		<?php
			include ('includes/header.php');
		?>
		
		<section>
		    
		    <?php
		    
		    	if (!isset($_GET['code'])) {
		            $aff = "OUPS ! Ce lien n'existe pas.";
		        }
		    	else {
			    	require ('connec_db.php');
					try {
				    	$rep = $db->prepare('SELECT valid FROM user WHERE code = ?;');
				    	$rep->execute(array($_GET['code']));
				        if (!($donnee = $rep->fetch())) {
				            $aff = "Ce lien n'est pas valide.";
				        } elseif ($donnee['valid']) {
				        	$aff = "Votre compte a déjà été validé.";
				        } else {
				        	$aff = "Nous avons bien enregistré votre validation, vous pouvez dès à présent vous connecter.";
				        	try {
				        		$db->beginTransaction();
					        	$rep = $db->prepare('UPDATE user SET valid = 1 WHERE code = ?;');
					        	$rep->execute(array($_GET['code']));
					        	$db->commit();
					        } catch(PDOException $e) {
								$db->rollBack();
								$aff ='Connexion échouée : ' . $e->getMessage() . '<br/>';
							}
				        }
			    	} catch(PDOException $e) {;
						$aff = 'Connexion échouée : ' . $e->getMessage() . '<br/>';
				 	}
			        
		    	}
				echo "<div>".$aff."</div>";
		    ?>
		</section>
		
		<?php include ('includes/footer.php'); ?>
