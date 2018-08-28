<div class="notfound404">
	<?php $test = $modelo->promote();
	if(isset($test[0]) && isset($test[1]) && isset($test[2])){
		if($test[0] && $test[1] > 0 && $test[2] == "Y"){ ?>
		<h1 align="center" style="font-size: 30px;">Vendedor aprovado.<br>A partir deste momento está habilitado a publicar artigos para venda.</h1>
		<?php }else if($test[0] && $test[1] > 0 && $test[2] == "N"){ 
			echo '<h1 align="center" style="font-size: 30px;">Este utilizador não vai poder publicar artigos para venda, o seu pedido não será aprovado.</h1>';
		}else{
			echo '<h1 align="center" style="font-size: 30px;">Ocorreu um erro na aprovação.<br>Por favor tente novamente.</h1>';
		}
	}else{
		echo '<h1 align="center" style="font-size: 30px;">Ocorreu um erro na aprovação.<br>Por favor tente novamente.</h1>';
	}
	?>
</div>