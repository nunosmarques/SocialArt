<div class="produt-main-container">
	<h2 class="h4center">Artesanato</h2>
	<?php
		$modelo->getProduct();
	?>
	<hr>
	<footer> 
		<p>
		<?php 
			$modelo->pagination();
		?>
		</p>
	</footer>
</div>