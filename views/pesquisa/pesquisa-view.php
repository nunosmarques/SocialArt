<div class="produt-main-container">
	<h2 class="h4center">Pesquisa "<?php echo $modelo->getQuery(); ?>" </h2>
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