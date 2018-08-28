<?php if ( ! defined('ABSPATH')) exit; ?>

<div class="wrap">

	<?php
		/* Carrega o método do model user_register */
		$modelo->user_register();
	?>

	<form method="post" action="" id="formreg">
        <h1>Registo</h1>
        <h4 class="h4center"><a href="#login" class="login-href">Já se registou? Clique aqui para iniciar a sessão.</a></h4>
        <fieldset>
          <legend><span class="number">IP</span>Informação Pessoal</legend>
          <label for="name">Nome<span class="mandatory">*</span></label>
          <input type="text" required autofocus id="name" placeholder="Introduza o seu nome" name="firstname">
          
          <label for="lastname">Apelido<span class="mandatory">*</span></label>
          <input type="text" required id="lastname" placeholder="Introduza o seu ultimo nome" name="lastname">
          
          <label for="mail">Email<span class="mandatory">*</span></label>
          <input type="email" required id="mail" placeholder="email@exemplo.com" name="email">
          
          <label for="phone">Telemóvel</label>
          <input type="text" id="phone" name="phone" placeholder="EX: +351 912 345 678">
          
          <label for="nif">NIF</label>
          <input type="text" id="nif" name="nif" placeholder="EX: 123 456 789">
          
          <div class="morada">
          	  <div class="adress add-mg-correction">
				  <label for="street" class="space">Morada<span class="mandatory">*</span></label>
				  <input type="text" required id="street" name="street" placeholder="Rua exemplo n.5 Andar 3 direito">
			  </div>
			  <div class="zip">
				  <label for="zip">Código Postal<span class="mandatory">*</span></label>
				  <input type="text" required id="zip" name="zip" placeholder="2140-086">
			  </div>
			  <div class="city ct-mg-correction">
				  <label for="city">Localidade<span class="mandatory">*</span></label>
				  <input type="text" required id="city" name="city" placeholder="Chamusca">
			  </div>
		  </div>
     	  <div class="dc-container">
     	  	  <div class="district-container">
 				  <label for="Distrito">Distrito<span class="mandatory">*</span></label>
				  <input type="text" required id="Distrito" name="Distrito" placeholder="Santarém">    	  	  
			  </div>
			  <div class="country-container">
				  <label for="country">País<span class="mandatory">*</span></label>
				  <select id="country" required name="country">
					  <option selected>Portugal</option>
				  </select>
			  </div>
		  </div>
       	  <div class="Seller-radio">
			  <label for="Seller">Deseja ser vendedor<span class="mandatory">*</span></label>
			  <label for="Seller">Sim</label>
			  <input type="radio" value="Y" name="Seller">
			  <br />
			  <label for="Seller">Não</label>
			  <input type="radio" checked value="N" name="Seller">
		  </div>
        </fieldset>
        
        <fieldset>
          <legend><span class="number">IU</span>Perfil de Utilizador</legend>
          
          <label for="username">Nome de Utilizador<span class="mandatory">*</span></label>
          <input type="text" required id="username" placeholder="Introduza o seu nome de utilizador" name="username">
          
          <label for="password">Palavra-passe<span class="mandatory">*</span></label>
          <input type="password" required placeholder="Introduza a sua password" id="password" name="password">
          
          <label for="chkpassword">Confirmar palavra-passe<span class="mandatory">*</span></label>
          <input type="password" required placeholder="Introduza novamente a sua password" id="chkpassword" name="chkpassword">
          
          <label for="description">Descrição do Artesão</label>
          <textarea id="description" placeholder="Descreva o seu trabalho de forma geral" name="description"></textarea>
        </fieldset>

        <button type="submit" name="formreg" form="formreg" id="reg-bt">Registar</button>
	
	</form>
</div>
