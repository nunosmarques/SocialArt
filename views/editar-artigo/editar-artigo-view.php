<?php $modelo->updateArtigo(); ?>
<div class="produt-main-container without-borders" style="border: 1px solid black;">
	<div class="product-img-main-container">
		<div class="produt-main-container">
			<div class="np-form">
				<form action="" method="post" id="upprod-form" enctype="multipart/form-data">	
				<div class="product-upload-container" style="margin-top: 9%;">
					<label for='fileUpload'>Selecionar um arquivo &#187;<br>(maximo 5 imagens, 4MB/cada) </label>
					<input id="fileUpload" name="upp-img[]" type="file" multiple><br />
					<div id="image-holder"></div>
				</div>

				<fieldset class="add-prd-field">
					<input  hidden="true" type="text" required id="ProdutoID" value="<?php echo (isset($modelo->form_data[0]['ProdutoID']) ? $modelo->form_data[0]['ProdutoID'] : 0) ?>" name="ProdutoID">

					<label for="NomeProduto">Nome do Produto<span class="mandatory">*</span></label>
					<input type="text" required id="Produto" value="<?php echo (isset($modelo->form_data[0]['NomeProduto']) ? $modelo->form_data[0]['NomeProduto'] : "N/A") ?>" placeholder="Introduza o nome que identifique o artigo" name="NomeProduto">

					<label for="Autor">Autor:<span class="mandatory">*</span></label>
					<input type="text" required id="Autor" value="<?php echo (isset($modelo->form_data[0]['Autor']) ? $modelo->form_data[0]['Autor'] : "N/A") ?>" placeholder="Introduza o nome do autor do artigo" name="Autor">

					<div class="np-numbers">
						<div class="np-num-l">
							<label for="Preco">Preço:<span class="mandatory">*</span></label>
							<span><input type="number" step="0.01" min="1" required id="Preco" value="<?php echo (isset($modelo->form_data[0]['Preco']) ? $modelo->form_data[0]['Preco'] : 0) ?>" name="Preco">€</span>
						</div>
						<div class="np-num-m">
							<label for="Quantidade">Quantidade:<span class="mandatory">*</span></label>
							<input type="number" min="1" required id="Quantidade" value="<?php echo (isset($modelo->form_data[0]['Quantidade']) ? $modelo->form_data[0]['Quantidade'] : 0) ?>" name="Quantidade">
						</div>
						<div class="np-num-r">
							<label for="Peso">Peso (em gramas):<span class="mandatory">*</span></label>
							<input type="number" step="0.01" min="1" required id="Peso" value="<?php echo (isset($modelo->form_data[0]['Peso']) ? $modelo->form_data[0]['Peso'] : 1) ?>" name="Peso">
						</div>
					</div>

					<label for="Familia">Familia<span class="mandatory">*</span></label>
					<select id="Familia" required name="Familia">
						<?php $modelo->getFamily(); ?>
					</select>

					<label for="Descricao">Descrição do Produto:</label>
					<textarea name="SmallDescription" rows="5"><?php echo (isset($modelo->form_data[0]['SmallDescription']) ? $modelo->form_data[0]['SmallDescription'] : "N/A") ?></textarea>

					<button type="submit" name="upprod-form" form="upprod-form" id="btn-patern">
						Atualizar Artigo
					</button>
				</fieldset>

				</form>
			</div>

		</div>
		<div class="edit-product-imgs-container">
			<section class="edit-main-adress">
				<div class="edit-main-row">
					<div class="edit-top-img"><h5 align="center"><strong>Imagem</strong></h5></div>
					<div class="edit-top-options"><h5 align="center"><strong>Opções</strong></h5></div>
				</div>
			</section>
			<?php 
				$modelo->getProductImg();
			?>
		</div>
	</div>
</div>
