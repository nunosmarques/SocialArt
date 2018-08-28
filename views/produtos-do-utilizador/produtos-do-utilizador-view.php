
	<div class="produt-main-container">
		<h2 class="h4center">Utilizador <?php echo ($modelo->getUserName() != null ? $modelo->getUserName() : ""); ?></h2>
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
