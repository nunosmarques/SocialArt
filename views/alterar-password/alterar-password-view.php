<div class="notfound404">
	<?php
	$modelo->getUserid();
	?>
	<div class="passwd" class="row">
		<section class="col-md-1"></section>
		<section class="col-md-10 my-margin">
			<section class="col-md-12">
			<h3 class="h3center"><?php echo $modelo->getUsername(); ?> introduza a sua nova palavra-passe</h3>
			<fieldset class="general-form">
		  	  <input type="number" id="usr" value="<?php echo $modelo->getUserid(); ?>" hidden="true">

			  <label for="password">Nova Palavra-passe<span class="mandatory">*</span></label>
			  <input type="password" required placeholder="Introduza a sua password" id="password">

			  <label for="chkpassword">Confirmar nova palavra-passe<span class="mandatory">*</span></label><!---->
			  <input type="password" required placeholder="Introduza novamente a sua password" id="chkpassword">

			<a href="#" id="btn-patern" class="ch-pwd-usr-btn">Alterar Palavra-passe</a>
			</fieldset>
			</section>
		</section>
		<section class="col-md-1"></section>
	</div>
</div>