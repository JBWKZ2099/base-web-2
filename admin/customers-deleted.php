<?php
	session_start();
	include("../php/db/conn.php");
	include("../php/db/auth.php");
	
	if( authCheck() ) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php
		$title="Clientes";
		$copy_year = date("Y",strtotime("today"));
		include("structure/head.php");
	?>
	<script src="assets/js/datatables/jquery.js"></script>
	<script src="assets/js/datatables/jquery.dataTables.js"></script>

	<?php $dt_restore=true; $dt_which="customer"; include("widgets/data-table-script.php"); ?>
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<?php
		$active_menu = $dt_which."_mn";
		$collapse = $dt_which;
		$active_opt = $dt_which."-deleted";
		include("structure/navbar.php");
		
		$data_table_which = "Usuarios";
		$table_head = array(
			"Nombre",
			"Apellido Paterno",
			"Apellido Materno",
			"Nombre de Usuario",
			"E-Mail",
			"Permisos",
		);
		include("widgets/data-table.php");
	?>

	<?php include("structure/footer.php"); ?>

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fa fa-angle-up"></i>
	</a>
	<?php
		include("widgets/modal.php");
		$table = "users"; $path = "customers";
		include("widgets/modal-restore.php");
	?>
</body>
</html>
<?php
	} else {
		header("Location: login");
	}
?>