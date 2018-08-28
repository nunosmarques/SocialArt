<div class="produt-main-container without-borders" style="border: 1px solid black;">
	<div class="product-img-main-container">
		<div class="product-imgs-container">
			<?php 
				$modelo->getProductImg(); 
			?>
		</div>
		<div class="product-data-container">
			<?php 
				$modelo->getProduct();
			
				$modelo->getMsgForm();
			?>

		</div>
		<div class="art-description">
			<h4 align="left">Descrição do Artigo</h4>
			<?php 
				$modelo->getProdDescription();
			?>
		</div>
	</div>
</div>
