<?php 			
	if($modelo->user_data[0]['Seller'] != "Y"){
			echo '<h4 class="h4center" style="margin-top:12%;">É necessário ser vendedor para poder publicar artigos.</h4>';
	}else{		
?>

<h4 class="h4center"> INTRODUZIR NOVO ARTIGO </h4>

<?php
$modelo->insertProduct();
?>
<div class="produt-main-container">
	<div class="np-form">
		<form action="" method="post" id="nprod-form" enctype="multipart/form-data">	
		<div class="product-upload-container" style="margin-top: 9%;">
			<label for='fileUpload'>Selecionar um arquivo &#187;<br>(maximo 5 imagens, 4MB/cada) </label>
			<input id="fileUpload" name="np-img[]" type="file" multiple><br />
			<div id="image-holder"></div>
		</div>
		
        <fieldset class="add-prd-field">
         
			<label for="NomeProduto">Nome do Produto<span class="mandatory">*</span></label>
			<input type="text" required id="Produto" placeholder="Introduza o nome que identifique o artigo" name="NomeProduto">

			<label for="Autor">Autor:<span class="mandatory">*</span></label>
			<input type="text" required id="Autor" placeholder="Introduza o nome do autor do artigo" name="Autor">
			
			<div class="np-numbers">
				<div class="np-num-l">
					<label for="Preco">Preço:<span class="mandatory">*</span></label>
					<input type="number" step="0.01" min="1" required id="Preco" value="1" name="Preco"> €
				</div>
				<div class="np-num-m">
					<label for="Quantidade">Quantidade:<span class="mandatory">*</span></label>
					<input type="number" min="1" required id="Quantidade" value="1" name="Quantidade">
				</div>
				<div class="np-num-r">
					<label for="Peso">Peso (em gramas):<span class="mandatory">*</span></label>
					<input type="number" step="0.01" min="0.01" required id="Peso" value="0.01" name="Peso">
				</div>
			</div>
			
		    <label for="Categoria_CategoriaID">Familia<span class="mandatory">*</span></label>
		    <select id="Categoria_CategoriaID" required name="Categoria_CategoriaID">
				<?php $modelo->getFamily(); ?>
		    </select>
			
			<label for="Descricao">Descrição do Produto:</label>
			<textarea name="SmallDescription" rows="5"></textarea>
			
			<button type="submit" name="nprod-form" form="nprod-form" id="btn-patern">
				Registar Produto
			</button>
		</fieldset>
		
		</form>
		<?php } ?>
	</div>
	
</div>