<?php 

	include ('includes/header.php'); 			
		
	if (!isset($_SESSION['login']) || !isset($_GET['id_pic'])) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
?>

<script type="text/javascript" src="image.js"></script>
		<section>
			<article>

				<?php
					require('connec_db.php');
				    
						try {
						    $rep = $db->prepare('SELECT image, id_user FROM picture WHERE id = ?;');
						    $rep->execute(array($_GET['id_pic']));
							$donnees = $rep->fetch();
						    

						    $rep2 = $db->prepare('SELECT COUNT(*) FROM likes WHERE id_user = ? AND id_pic = ?;');
							$rep2->execute(array($_SESSION['id_user'], $_GET['id_pic']));
							
							if ($rep2->fetchColumn() != 0) {
								$visibility = "visible";
							} else {
						    	$visibility = "hidden";
						    };



						    if (isset($donnees['image'])) {
						    	echo '<img src="data:image/png;base64,'.$donnees['image'].'" id="picture">';
						    } else {
								echo "<p>Cette image n'existe pas !</p>";
							}
						
						    echo '<input type="hidden" name="coeur">';
							echo '<div class="corazon"><a href="#" onclick="ft_like(this);" id="like"><img src="img/coeur-noir.png"></a>';
							echo '<a href="#" onclick="ft_like(this);" id="dislike" style="visibility: '.$visibility.';" ><img src="img/coeur-rouge.png"></a></div>';
							echo "<div id='comments'>";
							try {
								require("connec_db.php");
								$rep = $db->prepare('SELECT commentaire, id_user, date_comment FROM comments WHERE id_pic = ? ORDER BY date_comment ASC;');
								$rep->execute(array($_GET['id_pic']));
								while ($donnees = $rep->fetch()) {
									try {
										$rep2 = $db->prepare('SELECT login FROM user WHERE id = ?;');
										$rep2->execute(array($donnees['id_user']));
										$recup = $rep2->fetch();
										$name		= $recup['login'];
										$date 		= $donnees['date_comment'];
										$comment 	= $donnees['commentaire'];
										echo '<script type="text/javascript">createComment("'.$name.'","'.$date.'","'.$comment.'");</script>';
									} catch(PDOException $e) {
										echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
									}

								}

							} catch(PDOException $e) {
								echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
							}
							echo "</div>";
							?>
								<input type="text" id="comment">
								<input type="button" onclick="ft_comment()" id="valider" value="Valider">
							<?php	
							
								echo '<form action="remove_pic.php" method="post">';
								echo '<input type="hidden" id="id_pic" name="id_pic" value="'.$_GET['id_pic'].'">';
								if ($donnees['id_user'] == $_SESSION['id_user']) {
									echo '<input type="submit" name="delete" value="Supprimer">';
								}
								echo '</form>';

						} catch(PDOException $e) {;
						echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
						}
					?>

			</article>
		</section>



		<?php include ('includes/footer.php'); ?>