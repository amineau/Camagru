		<?php
			include ('includes/header.php');
		?>
		
		<section>
		    
		    <?php
		    
		    	if (!$_GET['code']) {
		            echo "OUPS ! Ce lien n'existe pas.";
		        }
		    	else {
			    	require ('connec_db.php');
					
			    	$rep	= $db->prepare('SELECT valid FROM user WHERE code = ?;');
			    	$rep->execute(array($_GET['code']));
			    	$donnee	= $rep->fetch();
			        if (!$donnee) {
			            echo "Ce lien n'est pas valide.";
			        }
			        elseif ($donnee['valid']) {
			        	echo "Votre compte a déjà été validé.";
			        }
			        else {
			        	echo "Nous avons bien enregistrer votre validation, vous pouvez dès à présent vous connecter.";
			        	$rep = $db->prepare('UPDATE user SET valid = 1 WHERE code = ?;');
			        	$rep->execute(array($_GET['code']));
			        }
			        
		    	}

		    ?>
		    
		</section>
		
		<?php include ('includes/footer.php'); ?>
