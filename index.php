<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"])."/";
	require $root."php/vendor/autoload.php";

	// // Create new Plates instance
	// $template = new League\Plates\Engine('views');

	// // Render a template
	// echo $template->render('home');


	class IndexController {
		private $templates;

		public function __construct() {
			$this->template = new League\Plates\Engine('views');
		}

		public function index() {
			return $this->template->render('home');
		}
	}

	$index = new IndexController();
	echo $index->index();

?>