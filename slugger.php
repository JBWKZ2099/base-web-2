<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"])."/";
	require $root."php/vendor/autoload.php";

	// Create new Plates instance
	$template = new League\Plates\Engine('views');

	include("php/slug.lib.php");

	// Render a template
	echo $template->render('slugger');
?>