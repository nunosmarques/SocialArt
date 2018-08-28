<div id="repor-password" class="popup" hidden="true">
<div title="Fechar" id="btn_close" class="btn-close"></div>

<form method="post" id="lg">
	<div class="form-group">
		<p>Reposição de Palavra-passe</p>
	</div>
	<div class="form-group nmtop nmbottom dados-rep">
		<label>Email ou Nome de utilizador</label>
		<input type="text" required placeholder="Email ou Nome de utilizador" name="dados" class="form-control" id="dados">
	</div>
	<div class="form-group">
	  <button type="submit" form="lg" name="lg" class="btn btn-success width100 lg-enter ask-pwd-ch" id="bt-lg">Submeter</button>
	</div>
	<div class="form-group nmtop">
		<span class="text12px">Ainda não se registou?</span><a href="<?php echo HOME_URI;?>/user-register/" class=""><span class="text12px mleft1perc">Registe-se</span></a>
	</div>
</form>
</div>
<div id="img-loading">
<div class="loader"></div>
</div>
<script src="<?php echo HOME_URI;?>/views/_js/funcoes.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo HOME_URI;?>/views/_js/login-reg.js?v=<?php echo time(); ?>"></script>