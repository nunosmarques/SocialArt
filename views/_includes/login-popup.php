<div id="login" class="popup" hidden="true">
<div title="Fechar" id="btn_close" class="btn-close"></div>

<form method="post" id="lg">
	<div class="form-group">
		<p>Autenticação</p>
	</div>
	<div class="form-group">
	  <input type="text" required autofocus placeholder="Introduza o seu email ou username" class="form-control" id="usr" name="username">
	</div>
	<div class="form-group nmtop nmbottom">
	  <input type="password" required placeholder="Introduza a sua password" name="password" class="form-control" id="pwd">
	</div>
	<div class="form-group nmtop">
		<a href="#repor-password" class="forgot-pwd">Esqueceu-se da password?</a>
	</div>
	<div class="form-group">
	  <button type="submit" form="lg" name="lg" class="btn btn-success width100 lg-enter" id="bt-lg">Entrar</button>
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