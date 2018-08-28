<?php
if(!$modelo->login->chkUserLogin()){
	$modelo->setCartBuyer(session_id());
}else{
	$modelo->setCartBuyer($modelo->user_data[0]['userid']);
}
$modelo->getPurchase();

?>

<div class="produt-main-container">
<form method="post" action="" id="s-cart">
<input type="text" value="<?php echo $modelo->getCartBuyer(); ?>" hidden="true">	
	<div class="cart-container">
		<?php
			if(!$modelo->login->chkUserLogin()){
				echo '<h4 class="h4center">
						<a href="#login" class="login-href">
							Já se registou?Clique aqui para iniciar a sessão.
						</a>
					</h4>';
			}
		?>
		<div class="cart-container-title">
			<h4 align="left">
				<?php
				if(!$modelo->login->chkUserLogin()){
					echo 'COMPRA SEM REGISTO';
				}else{
					echo 'CARRINHO DE COMPRAS';
				}
				?>
			</h4>
		</div>
		
		<div class="cart-userdata-container ilb valign-top">
			<div class="cart-data-form">
				<div class="cart-data-title">
					<h4 align="center">Endereço de Envio</h4>
				</div>

				<fieldset>
		  	  	  <select name="send-add" id="send-add" > <?php $modelo->getUserAdressList(); ?> </select>
				  <input type="text" hidden="true" id="carid" name="cartid" value="<?php echo ($modelo->getCartID() != null ? $modelo->getCartID() : ""); ?>">
				  <label for="firstname">Nome<span class="mandatory">*</span></label>
				  <input type="text" required id="firstname" placeholder="Introduza o seu primeiro nome" name="firstname" value="<?php echo (isset($modelo->user_data[0]['firstname']) ? $modelo->user_data[0]['firstname'] : ""); echo (isset($modelo->user_data[0]['lastname']) ? " ".$modelo->user_data[0]['lastname'] : ""); ?>">

				  <label for="Empresa">Empresa<span class="mandatory">*</span></label>
				  <input type="text" id="Empresa" placeholder="SocialArt Lda." name="Empresa"  value="<?php echo (isset($modelo->user_data[0]['Empresa']) ? $modelo->user_data[0]['Empresa'] : ""); ?>">
				  
				  <label for="mail">Email<span class="mandatory">*</span></label>
				  <input type="email" required id="mail" placeholder="email@exemplo.com" name="email" value="<?php echo (isset($modelo->user_data[0]['email']) ? $modelo->user_data[0]['email'] : ""); ?>">

				  <label for="phone">Telemóvel</label>
				  
				  <input type="text" id="phone" name="phone" placeholder="EX: +351 912 345 678"  value="<?php echo (isset($modelo->user_data[0]['phone']) ? $modelo->user_data[0]['phone'] : ""); ?>">

				  <label for="nif">NIF</label>
				  <input type="text" id="nif" name="nif" placeholder="EX: 123 456 789"  value="<?php echo (isset($modelo->user_data[0]['nif']) ? $modelo->user_data[0]['nif'] : ""); ?>">

				  <label for="country">País<span class="mandatory">*</span></label>
				  <select id="country" required name="country">
					  <option selected>Portugal</option>
				  </select>

				  <div class="adress">
					  <label for="street" class="space">Endereço</label>
					  <input type="text" required id="street" name="street" placeholder="Rua exemplo n.5 Andar 3 direito"  value="<?php echo (isset($modelo->add_data[0]["street"]) ? $modelo->add_data[0]["street"] : ""); ?>">
				  </div>	
				  		  
				  <div class="morada">
					  <div class="zip">
						  <label for="zip">Código Postal<span class="mandatory">*</span></label>
						  <input type="text" required id="zip" name="zip" placeholder="2140-086"  value="<?php echo (isset($modelo->add_data[0]['zip']) ? $modelo->add_data[0]['zip'] : ""); ?>">
					  </div>
					  <div class="city">
						  <label for="city">Localidade<span class="mandatory">*</span></label>
						  <input type="text" required id="city" name="city" placeholder="Chamusca"  value="<?php echo (isset($modelo->add_data[0]['city']) ? $modelo->add_data[0]['city'] : ""); ?>">
					  </div>
					  <div class="district">
						  <label for="district">Distrito<span class="mandatory">*</span></label>
						  <input type="text" required id="district" name="district" placeholder="Santarém"  value="<?php echo (isset($modelo->add_data[0]['Distrito']) ? $modelo->add_data[0]['Distrito'] : ""); ?>">
					  </div>
				  </div>
				</fieldset>
				<?php if($modelo->login->chkUserLogin()){ ?>
				<div class="[ form-group ] my-checkbox">
					<input type="checkbox" checked name="fancy-checkbox-success" id="fancy-checkbox-success" autocomplete="off" />
					<div class="[ btn-group ]">
						<label for="fancy-checkbox-success" class="[ btn btn-success ]">
							<span class="[ glyphicon glyphicon-ok ]"></span>
							<span> </span>
						</label>
						<label for="fancy-checkbox-success" class="[ btn btn-default active ]">
							Este é o meu endereço de faturação
						</label>
					</div>
				</div>
				
				<fieldset class="cart-invoice-data">
		  	  	  <div class="cart-data-title">
					<h4 align="center">Endereço de Faturação</h4>
				  </div>
				  <label for="infirstname">Nome<span class="mandatory">*</span></label>
				  <input type="text" id="infirstname" placeholder="Introduza o seu primeiro nome" name="infirstname">
				  
				  <label for="inempresa">Empresa<span class="mandatory">*</span></label>
				  <input type="text" id="inempresa" placeholder="SocialArt Lda." name="inempresa"  value="<?php echo (isset($modelo->user_data[0]['Empresa']) ? $modelo->user_data[0]['Empresa'] : ""); ?>">

				  <label for="inmail">Email<span class="mandatory">*</span></label>
				  <input type="email" id="inmail" placeholder="email@exemplo.com" name="inemail">
				  <?php				  
					if(!$modelo->login->chkUserLogin()){
						 echo '<label for="inconfmail">Confirmar Email<span class="mandatory">*</span></label>
						  <input type="email" id="inconfmail" placeholder="email@exemplo.com" name="inconfemail">';
					}
				  ?>				  
				  <label for="inphone">Telemóvel</label>
				  <input type="text" id="inphone" name="inphone" placeholder="EX: +351 912 345 678">

				  <label for="innif">NIF</label>
				  <input type="text" id="innif" name="innif" placeholder="EX: 123 456 789">

				  <label for="incountry">País<span class="mandatory">*</span></label>
				  <select id="incountry" name="incountry">
					  <option selected>Portugal</option>
				  </select>

				  <div class="adress">
					  <label for="instreet" class="space">Endereço<span class="mandatory">*</span></label>
					  <input type="text" id="instreet" name="instreet" placeholder="Rua exemplo n.5 Andar 3 direito">
				  </div>	
				  		  
				  <div class="morada">
					  <div class="zip">
						  <label for="inzip">Código Postal<span class="mandatory">*</span></label>
						  <input type="text" id="inzip" name="inzip" placeholder="2140-086">
					  </div>
					  <div class="incity">
						  <label for="incity">Localidade<span class="mandatory">*</span></label>
						  <input type="text" id="incity" name="incity" placeholder="Chamusca">
					  </div>
					  <div class="district">
						  <label for="indistrict">Distrito<span class="mandatory">*</span></label>
						  <input type="text" id="indistrict" name="indistrict" placeholder="Santarém">
					  </div>
				  </div>
				</fieldset>
				<?php } ?>
			</div>
		</div>
		
		<div class="cart-payment-info ilb valign-top">
			<h5 align="center"><strong>Metodo de Pagamento:</strong></h5>
			<section class="cart-taxes">
					<input type="radio" checked class="rd-btn-mbpay" name="payment-method" value="MB">
					<h5 align="center"><strong>Multibanco</strong></h5>
					
					<input type="radio" class="rd-btn-paypal" name="payment-method" value="PP">
					<h5 align="center"><strong>Paypal</strong></h5>
			</section>
			
			<div class="cart-table">	
				<header class="cart-title-top">
					<div class="final-cart-prod-top"><h5 align="center"><strong>Artigo</strong></h5></div>
					<div class="final-cart-auth-top"><h5 align="center"><strong>Vendedor</strong></h5></div>
					<div class="final-cart-preco-top"><h5 align="center"><strong>Preço</strong></h5></div>
					<div class="final-cart-qtd-top"><h5  align="center"><strong>Quantidade</strong></h5></div>
				</header>
				<?php
					$modelo->getCart($modelo->getCartBuyer());
				?>
			</div>
			<div class="cart-coments">
			<hr>
				<label for="coments">Comentários</label>
				<br>
				<textarea id="coments" name="coments" rows="4" cols="95"></textarea>
			</div>
			<div id="paypal-button-container" hidden="true"></div>
			<script src="https://www.paypalobjects.com/api/checkout.js"></script>
			<button type="submit" name="shoppgcart" form="s-cart" id="btn-patern">Finalizar compra</button>
			
		</div>
		
	</div>
</form>
</div>

<script>
var val  = "";
var form = [];
	
$(function() {
	val = $('#CartTotal').text();
	val = val.slice(0, -2);
	val = val.replace(/\s/g, '');
	
	$("#s-cart").on('change',function(){
		form = $(this).serialize();
	});

	paypal.Button.render({
			env: 'sandbox', // Or 'sandbox'
		

		
			client: {
				sandbox:    'AVvLWwY-J19KS5POT1rnYwHj0AJ3vFOl8S3yryzuyKhqbJd-pkOPlqI5V434JJn3sxOEtUMAivLH4rk6',
				production: 'AYXH6CKZ7tPtRsC4u92V069EJ1clQmlv0Fx6DSMqoOtOJUR_sMxT6tR9P2II7hg6jx-vV2UNyOuTFmSQ'
			},

			locale: 'pt_PT',

			commit: true, // Show a 'Pay Now' button

			payment: function(data, actions) {
				return actions.payment.create({
					payment: {
						transactions: [
							{
								amount: { total: val, currency: 'EUR' }
							}
						]
					}
				});
			},

			onAuthorize: function(data, actions) {
				return actions.payment.execute().then(function() {
						$.ajax({
							url: "../carrinho/afterPaypal",
							method: "POST",
							data: form,
							dataType: "json"
						}).done(function(data){
							alertBox("Compra finalizada com sucesso!","Verifique a sua caixa de email.");
						});
					//
				});
			}

	}, '#paypal-button-container');
	
});
	
</script>