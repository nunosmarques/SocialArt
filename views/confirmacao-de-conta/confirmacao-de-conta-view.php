<div class="notfound404">
	<?php $test = $modelo->confirmAccount();
	if(isset($test[0]) && isset($test[1])){
		if($test[0] && $test[1] > 0){ ?>
		<h1 align="center" style="font-size: 30px;">A sua conta foi confirmada, pode utilizá-la a partir de agora</h1>
		<h3 align="center">
			<a href="#login" class="login-href">
				Clique aqui para iniciar a sessão.
			</a>
		</h3>
		<?php }else{ 
			echo '<h1 align="center" style="font-size: 30px;">Ocorreu um erro ao confirmar a sua conta.<br>Por favor tente novamente.</h1>';
		} 
	}else{
		echo '<h1 align="center" style="font-size: 30px;">Ocorreu um erro ao confirmar a sua conta.<br>Por favor tente novamente.</h1>';
	}
	?>
</div>
<script>
$('.login-href').click(function(event) {
	//Apanha o link do "botão" clicado
	var loginBox = $(this).attr('href');
	janela(loginBox);
	event.preventDefault();
});
</script>