<?php if ( ! defined('ABSPATH')) exit; ?>

<div id="login" class="login-container">
	<form method="post" id="5">
		<div >
			<p class="login-p">Autenticação</p>
		</div>
		<div class="form-group">
		  <input type="text" required autofocus placeholder="Introduza o seu email ou username" class="form-control" id="login-usr">
		</div>
		<div class="form-group">
		  <input type="password" required placeholder="Introduza a sua password" class="form-control" id="login-pwd">
		</div>
		<div class="form-group">
		  <button type="button" class="btn btn-success login-sub">Entrar</button>
		</div>
	</form>
</div>