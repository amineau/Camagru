<?php 

	include ('includes/header.php'); 			
		
	if (!isset($_SESSION['login']) || !isset($_GET['id_pic'])) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
?>

<script type="text/javascript">

	function ft_like(oARef) {
		var xhr 	= getXMLHttpRequest();
		var liOrDis	= oARef.id;
		var idPic	= document.getElementById('picture').alt;

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				readData(xhr.responseText);
			}
		};
		if (liOrDis == 'like') {
			document.getElementById('dislike').style.visibility = "visible";
		} else {
			oARef.style.visibility = "hidden";
		}
		xhr.open("POST", "like.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("action="+liOrDis+"&id_pic="+idPic);
	}

	function readData(sData) {
		var ret = sData;
		console.log(ret);
	}

</script>

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
						    	echo '<img src="data:image/png;base64,'.$donnees['image'].'" id="picture" alt="'.$_GET['id_pic'].'">';
						    } else {
								echo "<p>Cette image n'existe pas !</p>";
							}
						
						    echo '<input type="hidden" name="coeur">';
							echo '<div class="corazon"><a href="#" onclick="ft_like(this)" id="like"><img src="img/coeur-noir.png"></a>';
							echo '<a href="#" onclick="ft_like(this);" id="dislike" style="visibility: '.$visibility.';" ><img src="img/coeur-rouge.png"></a></div>';
								
							if ($donnees['id_user'] == $_SESSION['id_user']) {
								echo '<form action="remove_pic.php" method="post">';
								echo '<input type="hidden" name="id_pic" value="'.$_GET['id_pic'].'">';
								echo '<input type="submit" name="delete" value="Supprimer">';
								echo '</form>';
							}

						} catch(PDOException $e) {;
						echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
						}
					?>

			</article>
		</section>



		<?php include ('includes/footer.php'); ?>