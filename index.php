<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"])."/";
	require $root."vendor/autoload.php";

	// Create new Plates instance
	$template = new League\Plates\Engine('views');

	// Render a template
	echo $template->render('home');
?>