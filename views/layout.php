<!DOCTYPE html>
<html lang="es">
<head>
	<?php
		/*
		* Cambiar los valores de $up_dir dependiendo de en que nivel se encuentre
		* la vista que se agregó, por ejemplo:
		*	proyecto/
		*	├── assets/
		*	├── structure/
		* ├── otra_carpeta/
		* │   └── Subcarpeta/
		* │   		├── archivo01.php -> En este caso $up_dir debe ser igual a 2
		* │   		└── archivo02.php
		*	└── carpeta_donde_hay_vistas/
		*	    ├── archivo01.php -> En este caso $up_dir debe ser igual a 1
		*	    ├── archivo02.php
		*	    ├── archivo03.php
		*	    ├── archivo04.php
		*	    └── archivo05.php
		*/
		$up_dir = 0; for( $i01=1; $i01<=$up_dir; $i01++ ) { $dir.="../"; }
	?>
	
	<link rel="shortcut icon" href="http://placehold.it/32.ico"/>
	<meta charset="UTF-8">
	<title> <?=$this->e($title)?> | site_name </title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php /* CSS Tags */ ?>
	<?php /*Bootstrap css minified*/ ?>
	<?= $this->htmlStyle("https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css") ?>
	<?php /*Style Core*/ ?>
	<?= $this->htmlStyle("assets/css/core.css") ?>
	<?php /*Style Custom*/ ?>
	<?= $this->htmlStyle("assets/css/custom.css") ?>

	<?php /* JS Tags */ ?>
	<?php /*jQuery js minified*/ ?>
	<?= $this->htmlScript("https://code.jquery.com/jquery-3.3.1.min.js",["crossorigin"=>"anonymous"]) ?>
	<?php /*jQuery UI*/ ?>
	<?= $this->htmlScript("https://code.jquery.com/ui/1.12.1/jquery-ui.min.js") ?>
	<?php /*Bootstrap js minified*/ ?>
	<?= $this->htmlScript("https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js",["crossorigin"=>"anonymous"]) ?>
	<?= $this->htmlScript("https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js",["crossorigin"=>"anonymous"]) ?>
	<?php /*Fontawesome*/ ?>
	<?= $this->htmlScript("https://use.fontawesome.com/releases/v5.1.0/js/all.js",["defer"]) ?>
	<?php /*Scroll reveal*/ ?>
	<?= $this->htmlScript("https://unpkg.com/scrollreveal/dist/scrollreveal.min.js") ?>
	<?php /*Script custom*/ ?>
	<?= $this->htmlScript("assets/js/head.js") ?>

	<?php
		// Path where are storaged media files (img, video, etc)
		// echo $asset = $this->urlTo("/assets/img/folder_name/","image");
	?>

	<?=$this->section('meta_data')?>
</head>
<body>
	<?php $active="index"; ?>

	<?=$this->insert('menus/navbar')?>
	
	<?=$this->section('main')?>

	<?=$this->insert('menus/footer')?>

	<?=$this->section('scripts')?>
</body>
</html>