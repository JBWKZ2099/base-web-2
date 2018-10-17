<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"])."/";
	require $root."php/vendor/autoload.php";

	// Create new Plates instance
	$template = new League\Plates\Engine('views');

	// Backend to make blog page works
	include('php/blog/core.php');
	include("php/slug.lib.php");

	$tabla = 'blogs';
	$mysqli = conectar_db();
	selecciona_db($mysqli);
	mysqli_query ($mysqli,"SET NAMES 'UTF8';");
	
	if( isset($_GET["page"]) )
		$page = $_GET["page"];
	else
		$page = 1;

	if(wblog() == "no") {
		if( isset($_GET["search"]) && !empty($_GET["search"]) ) // If user searchs something
			$search = $_GET["search"];
		else
			$search = null;

		$blog = blog_actual($mysqli, $tabla, null, null, null, $page, $search); $blogroot = "false";
	} else {
		$blogroot = "true";
		$ssblog = blog_ver($mysqli, $tabla, wblog()['idblog'], 1);
		$catblog = blog_ver($mysqli, $tabla, wblog()['isblog'], 2);


		$show_catblog = 0;
		if( wblog()['idblog'] )
			$show_catblog++;
		if( wblog()['isblog'] )
			$show_catblog++;
	}

	$id_blog = $ssblog[0]["id"];
	$comments = getComments($mysqli,$id_blog);

	// Make widget categories works
	$exccom = categories_list($mysqli);
	$atm = blogs_list($mysqli,2);
	$cap = blogs_list($mysqli,3);

	$compact = [
		"blogroot" => $blogroot,
		"blog" => $blog,
		"ssblog" => $ssblog,
		"catblog" => $catblog,
		"comments" => $comments,
		"exccom" => $exccom,
		"atm" => $atm,
		"cap" => $cap,
	];

	// dd( $ssblog );
	// dd( getComments($mysqli,$id_blog) );
	// die();

	// Render a template
	echo $template->render('blog',$compact);
?>