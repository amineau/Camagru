<?php

    session_start();
    session_destroy();
    require_once('redir.php');
	header('Location: '.adresse('index.php'));
	exit;
?>