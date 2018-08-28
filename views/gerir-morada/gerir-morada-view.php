<?php if ( ! defined('ABSPATH')) exit; ?>

<div class="wrap">

	<?php
		/* Carrega o método do model newAdress */
		$modelo->newAdress();
	?>

	<form method="post" action="" id="formreg">
        <h1>Nova Morada</h1>
         <fieldset>
          <label for="name">Nome Completo<span class="mandatory">*</span></label>
          <input type="text" required autofocus id="name" placeholder="Introduza o seu nome" name="fullname">
 
          <div class="morada">
          	  <div class="adress-new">
				  <label for="street" class="space">Morada<span class="mandatory">*</span></label>
				  <input type="text" required id="street" name="street" placeholder="Rua exemplo n.5 Andar 3 direito">
			  </div>
			  <div class="zip">
				  <label for="zip">Código Postal<span class="mandatory">*</span></label>
				  <input type="text" required id="zip" name="zip" placeholder="2140-086">
			  </div>
			  <div class="city">
				  <label for="city">Localidade<span class="mandatory">*</span></label>
				  <input type="text" required id="city" name="city" placeholder="Chamusca">
			  </div>
			  <div class="city">
				  <label for="Distrito">Distrito<span class="mandatory">*</span></label>
				  <input type="text" required id="Distrito" name="Distrito" placeholder="Lisboa">
			  </div>
		  </div>
                  
          <label for="country">País<span class="mandatory">*</span></label>
          <select id="country" required name="country">
         	  <option value="Portugal">Portugal</option>
          </select>
       
        </fieldset>
        <button type="submit" name="formreg" form="formreg" id="reg-bt">Submeter nova morada</button>
	
	</form>
</div>
