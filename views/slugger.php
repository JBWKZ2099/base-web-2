<?php $this->layout('layout', ['title' => 'Slugger']) ?>

<?php $this->start("main") ?>
	<?php if(isFile()[0] == "no") { ?>
		<section class="bg-default-02 pt-60 pb-60">
			<div class="container-custom">
				<div class="row">
					<div class="col-md-12">
						CONTENT <br>
						<a href="<?= $this->urlTo( isFile()[1]."/".slugger("nombre link") ); ?>">Link Test 1</a> <br>
						<a href="<?= $this->urlTo( isFile()[1]."/".slugger("otro link") ); ?>" title="">Link Test 2</a>
					</div>
				</div>
			</div>
		</section>
	<?php } else { ?>
		<section class="bg-default-02 pt-60 pb-60">
			<div class="container-custom">
				<div class="row">
					<div class="col-md-12">
						Otro link
						<img src="<?= $this->urlTo('assets/img/test/500x300.jpg') ?>" alt="TestIMG">

					</div>
				</div>
			</div>
		</section>
	<?php } ?>
<?php $this->stop() ?>

<?php $this->push("scripts") ?>
	<script></script>
<?php $this->stop() ?>