<?php $this->layout('layout', ['title' => 'Contacto']) ?>

<?php $this->start("main") ?>
	
	<?= $this->insert('alerts/alerts') ?>

	<section class="bg-default-02 pt-60 pb-60">
		<div class="container-custom">
			<div class="row">
				<div class="col-md-12">
					<form action="<?= $this->urlTo('php/mailer/index.php','route') ?>" method="POST">
						<div class="form-group">
							<input type="text" class="form-control" name="name" value="" placeholder="Nombre:" required>
						</div>
						<div class="form-group">
							<input type="email" class="form-control" name="email" value="" placeholder="E-Mail:" required>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="subject" value="" placeholder="Asunto:" required>
						</div>
						<div class="form-group">
							<textarea class="form-control" name="msg" rows="5" placeholder="Mensaje:"></textarea>
						</div>
						<div class="form-group">
							<div id="g-recaptcha"></div>
						</div>
						<button type="submit" class="btn btn-secondary">Enviar</button>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php $this->stop() ?>

<?php $this->push("scripts") ?>
	<!-- Google reCaptcha -->
	<script src="https://www.google.com/recaptcha/api.js?onload=renderCaptcha&render=explicit" async="async" defer="defer"></script>
	<script>
		var recaptcha;
		var renderCaptcha = function() {
			recaptcha = grecaptcha.render('g-recaptcha', {
				'sitekey': '6LeQ02YUAAAAAKBAujSmwV4MvJ04ea6Lo2qvvlt2',
				'theme': 'light'
			});
		};
	</script>
	<!-- Google reCaptcha -->
<?php $this->stop() ?>