<?php
	header("Content-Type: text/xml");

	$nb_img = $_POST['nb_img'];
	$page 	= $_POST['page'];
	$i 		= 0;
	if (!isset($nb_img, $page) || empty($nb_img) || empty($page)) {
	    require_once('function.php');
		header('Location: '.adresse('index.php'));
		exit;
	}

	echo '<?xml version = "1.0" encoding="UTF-8"?>';
	$nb_load = $nb_img * ($page - 1);
	require('connec_db.php');
	try {
		$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
		$rep = $db->prepare('SELECT id, image FROM picture ORDER BY date_de_creation DESC LIMIT ?, ?;');
		$rep->execute(array((int)$nb_load, (int)$nb_img));
		echo '<racine>';
		while ($donnees = $rep->fetch()) {
			echo '<img><id>'.$donnees['id'].'</id>';
			echo '<bin>'.$donnees['image'].'</bin></img>';
			$i++;
		}
		echo '<nb>'.$i.'</nb>';
		$nb_load++;
		echo '<first>'.$nb_load.'</first>';
		echo '</racine>';
	} catch(PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}

?>