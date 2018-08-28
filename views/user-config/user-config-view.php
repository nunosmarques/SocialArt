<div class="myaccount-container">
    <ul>
    <?php if($modelo->user_data[0]['Seller'] == 'Y'){?>
    	<li><a href="<?php echo HOME_URI;?>/user-config/produtos/">Produtos</a></li>
    	<li><a href="<?php echo HOME_URI;?>/user-config/vendas/">Vendas</a></li>
    <?php }?>	
    	<li><a href="<?php echo HOME_URI;?>/user-config/compras/">Compras</a></li>		
    	<li><a href="<?php echo HOME_URI;?>/user-config/mensagens/recebidas">Mensagens</a></li>
    	<li><a href="<?php echo HOME_URI;?>/user-config/informacoes_pessoais/">Informações Pessoais</a></li>
    	<li><a href="<?php echo HOME_URI;?>/user-config/notificacoes/">Notificações</a></li>
    </ul>
    <div class="container-op">
    <?php if($modelo->user_data[0]['Seller'] == 'Y'){?>

    	<div id="produtos">
			<header>Produtos Ativos</header>
			<h3 class="h3center">Os meus artigos</h3>
			<section class="user-prods">
				<div class="user-prods-main-row">
					<div class="user-prods-top-img"><h5 align="center">Artigo<strong></strong></h5></div>
					<div class="user-prods-top-name"><h5  align="center"><strong>Nome do Artigo</strong></h5></div>
					<div class="user-prods-top-author"><h5  align="center"><strong>Autor</strong></h5></div>
					<div class="user-prods-top-price"><h5  align="center"><strong>Preço</strong></h5></div>
					<div class="user-prods-top-stock"><h5  align="center"><strong>Quantidade</strong></h5></div>
						<div class="options-top"><h5  align="center"><strong>Opções</strong></h5></div>
				</div>
					<?php $modelo->getUserProds(); ?>
			</section>
		</div>
		<div id="vendas">
			<header>Vendas Efetuadas</header>
			<section class="user-prods">
					<h3 class="h3center">As Minhas Compras</h3>
					<section class="add-btn-container">
					</section>
					<section class="user-main-adress">
						<div class="user-pursh-main-row">
							<div class="user-pursh-top-artigo"><h5 align="center"><strong>Artigo</strong></h5></div>
							<div class="user-pursh-top-preco"><h5 align="center"><strong>Preço</strong></h5></div>
							<div class="user-pursh-top-qtd"><h5  align="center"><strong>Quantidade</strong></h5></div>
						</div>
						<?php $modelo->getUserSales(); ?>
					</section>
			</section>		
		</div>
	<?php }?>	
		<div id="compras">
			<header>Compras Efetuadas</header>
			<section class="user-prods">
					<h3 class="h3center">As Minhas Compras</h3>
					<section class="add-btn-container">
					</section>
					<section class="user-main-adress">
						<div class="user-pursh-main-row">
							<div class="user-pursh-top-artigo"><h5 align="center"><strong>Artigo</strong></h5></div>
							<div class="user-pursh-top-preco"><h5 align="center"><strong>Preço</strong></h5></div>
							<div class="user-pursh-top-qtd"><h5  align="center"><strong>Quantidade</strong></h5></div>
						</div>
						<?php $modelo->getUserPurchases(); ?>
					</section>
			</section>
		</div>
		<div id="mensagens">
			<header>
				<ul>
					<li><a href="<?php echo HOME_URI;?>/user-config/mensagens/recebidas">Mensagens Recebidas</a></li>
					<li class="bleft-transp"><a href="<?php echo HOME_URI;?>/user-config/mensagens/arquivadas">Mensagens Arquivadas</a></li>
				</ul>
			</header>
			<div id="mrec">
				<section class="alerts-container">
						<h3 class="h3center">Mensagens Recebidas</h3>
						<section class="alert-main">
							<div class="alerts-main-row">
								<div class="sender-top-name"><h5 align="center"><strong>Remetente</strong></h5></div>
								<div class="alerts-top-date"><h5 align="center"><strong>Data</strong></h5></div>
								<div class="alerts-top-options"><h5  align="center"><strong>Opções</strong></h5></div>
							</div>
							<?php $modelo->getMessage(); ?>
						</section>
				</section>					
			</div>
			<div id="marq">
				<section class="alerts-container">
						<h3 class="h3center">Mensagens Arquivadas</h3>
						<section class="alert-main">
							<div class="alerts-main-row">
								<div class="sender-top-name"><h5 align="center"><strong>Remetente</strong></h5></div>
								<div class="alerts-top-date"><h5 align="center"><strong>Data</strong></h5></div>
								<div class="alerts-top-options"><h5  align="center"><strong>Opções</strong></h5></div>
							</div>
							<?php $modelo->getMessageFiled(); ?>
						</section>
				</section>
			</div>
		</div>
		<div id="ipessoais">
			<header>				
				<ul>
					<li><a href="<?php echo HOME_URI;?>/user-config/informacoes_pessoais/dados-pessoais">Dados Pessoais </a></li>
					<li class="bleft-transp"><a href="<?php echo HOME_URI;?>/user-config/informacoes_pessoais/dados-faturacao">Dados de Faturação</a></li>
					<li class="bleft-transp"><a href="<?php echo HOME_URI;?>/user-config/informacoes_pessoais/as-minhas-moradas">Moradas</a></li>
					<li class="bleft-transp"><a href="<?php echo HOME_URI;?>/user-config/informacoes_pessoais/mudar-password">Mudar Password</a></li>
				</ul>
			</header>
			<div id="dp" class="row">
				<section class="col-md-1"></section>
				<section class="col-md-10">
					<section class="col-md-12">
						<form method="post" action="" id="dataform" class="general-form">
							<h3 class="h3center">Alteração de Dados Pessoais </h3>

							<fieldset>
							  <legend><span class="number">IP</span>Informação Pessoal</legend>

							  <label for="name">Nome</label>
							  <input type="text" autofocus id="firstname" placeholder="Introduza o seu nome" value="<?php echo $modelo->getFirstName(); ?>">

							  <label for="lastname">Apelido</label>
							  <input type="text" id="lastname" placeholder="Introduza o seu ultimo nome" value="<?php echo $modelo->getLastName(); ?>">
							</fieldset>
							<fieldset>
							  <legend><span class="number">E</span>Email</legend>
							  <label for="mail">Email</label>
							  <input type="email" id="mail" placeholder="email@exemplo.com" value="<?php echo $modelo->getEmail(); ?>">

							  <label for="mail">Confirmar Email</label>
							  <input type="email" id="confmail" placeholder="email@exemplo.com" value="<?php echo $modelo->getEmail(); ?>">
							</fieldset>
							<fieldset>
							  <legend><span class="number">OD</span>Outros Dados</legend>
							  <label for="phone">Telemóvel</label>
							  <input type="text" id="phone" placeholder="EX: +351 912 345 678" name="phone" value="<?php echo $modelo->getPhone(); ?>">

							  <label for="bio">Descrição do Artesão</label>
							  <textarea id="bio" placeholder="Descreva o seu trabalho de forma geral"><?php echo $modelo->getDescription(); ?></textarea>
							</fieldset>

							<a href="#" id="btn-patern" class="ch-userdata-btn">Atualizar dados pessoais</a>
						</form>
					</section>
				</section>
				<section class="col-md-1"></section>
			</div>
			<div id="df" class="row">
				<section class="col-md-1"></section>
				<section class="col-md-10">
					<section class="col-md-12">
						<form method="post" action="" id="invoiceform" class="general-form">
							<h3 class="h3center">Alteração de Dados de Faturação</h3>
								<fieldset>
								  <label for="name">Nome Completo</label>
								  <input type="text" autofocus id="inv-fullname" name="inv-fullname" value="<?php echo $modelo->getFullname(); ?>" placeholder="Introduza o seu nome">
								  <select name="inv-add" id="inv-add" > <?php $modelo->getUserAdressList(); ?> </select>
								  <a id="btn-patern" style="padding: 1% !important; text-decoration: none;" href="<?php echo HOME_URI;?>/gerir-morada/">Adicionar Nova Morada</a>
								  <label for="nif">NIF</label>
									<input type="text" id="nif" name="nif" value="<?php echo $modelo->getNIF(); ?>" placeholder="EX: 123 456 789">
								</fieldset>
								<a href="#" id="btn-patern" class="ch-invoice-btn">Atualizar dados de faturação</a>
						</form>
					</section>
				</section>
				<section class="col-md-1"></section>
			</div>
			<div id="morada" class="row">
				<section class="col-md-1"></section>
				<section class="col-md-10">
					<section class="col-md-12">
							<h3 class="h3center">Moradas</h3>
							<section class="add-btn-container">
							<a id="btn-patern" class="btn-addAdd" href="<?php echo HOME_URI;?>/gerir-morada/">Adicionar Nova Morada</a>
							</section>
							<section class="user-main-adress">
								<div class="user-adress-main-row">
									<div class="user-adress-top-name"><h5 align="center"><strong>Nome</strong></h5></div>
									<div class="user-adress-top-adress"><h5 align="center"><strong>Morada</strong></h5></div>
									<div class="adress-options-top"><h5  align="center"><strong>Opções</strong></h5></div>
								</div>
									<?php $modelo->getUserAdress(); ?>
							</section>
					</section>
				</section>
				<section class="col-md-1"></section>
			</div>
			<div id="passwd" class="row">
				<section class="col-md-1"></section>
				<section class="col-md-10 my-margin">
					<section class="col-md-12">
					<h3 class="h3center">Alteração de Password</h3>
					<fieldset class="general-form">
					  <label for="actualpwd">Palavra-passe Atual<span class="mandatory">*</span></label>
					  <input type="password" required placeholder="Introduza a sua password atual" id="actualpwd">

					  <label for="password">Nova Palavra-passe<span class="mandatory">*</span></label>
					  <input type="password" required placeholder="Introduza a sua password" id="password">

					  <label for="chkpassword">Confirmar nova palavra-passe<span class="mandatory">*</span></label><!---->
					  <input type="password" required placeholder="Introduza novamente a sua password" id="chkpassword">

					<a href="#" id="btn-patern" class="ch-pwd-btn">Alterar Palavra-passe</a>
					</fieldset>
					</section>
				</section>
				<section class="col-md-1"></section>
			</div>
		</div>
		<div id="notificacoes">
			<header>Notificações</header>
			<section class="alerts-container">
					<h3 class="h3center">Notificações</h3>
					<section class="alert-main">
						<div class="alerts-main-row">
							<div class="alerts-top-seller"><h5 align="center"><strong>Vendedor</strong></h5></div>
							<div class="alerts-top-prod"><h5 align="center"><strong>Descrição</strong></h5></div>
							<div class="alerts-top-date"><h5 align="center"><strong>Data</strong></h5></div>
							<div class="alerts-top-options"><h5  align="center"><strong>Opções</strong></h5></div>
						</div>
						<?php $modelo->getAlerts(); ?>
					</section>
			</section>		
		</div>
	</div>
</div>