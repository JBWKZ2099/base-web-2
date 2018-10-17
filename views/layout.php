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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" crossorigin="anonymous">
	<?php /*Style Core*/ ?>
	<link rel="stylesheet" href="<?=$this->urlTo('assets/css/core.css')?>">
	<?php /*Style Custom*/ ?>
	<link rel="stylesheet" href="<?=$this->urlTo('assets/css/custom.css')?>">

	<?php /* JS Tags */ ?>
	<?php /*jQuery js minified*/ ?>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
	<?php /*jQuery UI*/ ?>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<?php /*Bootstrap js minified*/ ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
	<?php /*Fontawesome*/ ?>
	<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>
	<?php /*Scroll reveal*/ ?>
	<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
	<?php /*Script custom*/ ?>
	<script src="<?=$this->urlTo('assets/js/head.js')?>"></script>

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