<?php session_start(); ?>

<html>
<head><title>debug</title></head>
<body>

<?php
	echo "<p>SESSION : ";
	print_r($_SESSION);
	echo "<br />POST : ";
	print_r($_POST);
	echo "<br />SERVER : ";
	print_r($_SERVER);
	echo "<br />Allez, bisous</p>";
?>
</body>
</html>
