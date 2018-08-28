<?php if ( ! defined('ABSPATH')) exit;
	$usrl = new UserLogin();
	//$usrl->login();
	$usrl->logout();
?>
<form method="post"></form>
<header>
	<div class="desktop-nav">
		<nav class="nav-login">
			<div class="logo">
				<a href="<?php echo HOME_URI;?>"><img src="<?php echo HOME_URI;?>/views/_images/logo.png" /></a>
			</div>
			<div class="div-cont-login">
				<div class="cont-login">
						<?php
							$section = "produtos";
							if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION[ 'userdata' ])){
								echo '<div class="dropdown bt-signin">
										  <a class="dropbtn">Olá, '.ucfirst($_SESSION["userdata"][0]["username"]).'</a>
										  </form>';
								$msg_class = "new-msg-on-menu";
								if($usrl->countMSG() <= 0){
									$msg_class = "new-msg-on-menu-empty";
								}
								echo	 '<a href="'.HOME_URI.'/user-config/mensagens/recebidas"><div class="'.$msg_class.'">'.$usrl->countMSG().'</div></a>';
								if($usrl->countAlerts() > 0){
									echo	 '<a href="'.HOME_URI.'/user-config/notificacoes/"><div class="new-alert">'.$usrl->countAlerts().'</div></a>';
								}
								if($usrl->user_data[0]['Seller'] == "N"){ $section = "compras"; }
								echo 	 '<div class="dropdown-content">
											<a href="'.HOME_URI.'/user-config/'.$section.'/">A minha conta</a>
											<form method="post" id="form-lgout">
												<a><button type="submit" class="bt-logout" name="lgout" form="form-lgout" id="logout">
													Logout
												</button></a>
											</form>
										  </div>
								 	  </div>';
								echo '';
								echo '<div class="bt-fav">
										<a href="'.HOME_URI.'/favoritos/">
											<div class="icon-margin imgfav" title="Favoritos"></div>
										</a>
									  </div>';
							}else{
								echo '<a href="#login" class="bt-login"> Login </a>';
								echo '<a href="'.HOME_URI.'/user-register/" class="bt-signin">
										  Registar
									  </a>';
							}
							$cartClass = "imgecart";
							$cartMsg   = "O carrinho está vazio";
							if($usrl->countCart() > 0){ $cartClass = "imgfcart"; $cartMsg = "Existe ".$usrl->countCart()." artigo(s) no carrinho.";}
						?>
				
					<div class="bt-cart">
						<a href="<?php echo HOME_URI;?>/carrinho/">
							<div class="icon-margin <?php echo $cartClass; ?>" title="<?php echo $cartMsg; ?>"></div>
						</a>
					</div>
					<div class="pub-art"><a href="<?php echo HOME_URI;?>/novo-artigo/">MOSTRE A SUA ARTE</a></div>
				</div>
			</div>
		</nav>
		<nav class="menu">
			<ul>
				<li><a href="<?php echo HOME_URI;?>">Home</a></li>
				<li><a href="<?php echo HOME_URI;?>/pintura/index/pagina-1">Pintura</a></li>
				<li><a href="<?php echo HOME_URI;?>/fotografia/index/pagina-1">Fotografia</a></li>
				<li><a href="<?php echo HOME_URI;?>/escultura/index/pagina-1">Escultura</a></li>
				<li><a href="<?php echo HOME_URI;?>/artesanato/index/pagina-1">Artesanato</a></li>
				<li><a href="<?php echo HOME_URI;?>/estilo-livre/index/pagina-1">Estilo Livre</a></li>
				<li class="li-search">
					<form action="<?php echo HOME_URI;?>/pesquisa/index/pagina-1" method="post">
						<input type="text" name="query" class="searchInput">
						<button type="submit" class="btn-search">Pesquisar</button>
					</form>
				</li>
			</ul>
		</nav>
	</div>
	<div class="mobile-nav" hidden="true">
		<nav class="menu clearfix">
			<ul>
				<li><a href="<?php echo HOME_URI;?>">Home</a></li>
				<li><a href="<?php echo HOME_URI;?>/user-register/">User Register</a></li>
				<li><a href="<?php echo HOME_URI;?>/noticias/">Notícias</a></li>
				<li><a href="<?php echo HOME_URI;?>/noticias/adm/">Notícias Admin</a></li>
				<li><a href="<?php echo HOME_URI;?>/xpto/">Exemplo básico</a></li>
			</ul>
			
		</nav>		
	</div>
</header>
<script src="<?php echo HOME_URI;?>/views/_js/login-reg.js?v=<?php echo time(); ?>"></script>
<div class="main-page">
<?php 
require "login-popup.php";
require "repor-password.php";
require "alert.php";
require "loader.php";

?>