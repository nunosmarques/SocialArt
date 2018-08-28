<?php if ( ! defined('ABSPATH')) exit; ?>

<div class="wrap">

	<?php
		/* Carrega o método do model updateAdress */
		$modelo->updateAdress();
	?>

	<form method="post" action="" id="formupadd" class="general-form">
        <h1>Editar Morada</h1>
         <fieldset>
          <label for="name">Nome Completo<span class="mandatory">*</span></label>
          <input type="text" required autofocus id="name" name="fullname" value="<?php echo (isset($modelo->data_array[0]['fullname']) ? $modelo->data_array[0]['fullname'] : "N/A" )?>" placeholder="Introduza o seu nome">
 
          <div class="morada">
          	  <div class="adress">
				  <label for="street" class="space">Morada<span class="mandatory">*</span></label>
				  <input type="text" required id="street" name="street" value="<?php echo (isset($modelo->data_array[0]['street']) ? $modelo->data_array[0]['street'] : "N/A" )?>" placeholder="Rua exemplo n.5 Andar 3 direito">
			  </div>
			  <div class="zip">
				  <label for="zip">Código Postal<span class="mandatory">*</span></label>
				  <input type="text" required id="zip" name="zip" value="<?php echo (isset($modelo->data_array[0]['zip'])? $modelo->data_array[0]['zip'] : "N/A" )?>" placeholder="2140-086">
			  </div>
			  <div class="city">
				  <label for="city">Localidade<span class="mandatory">*</span></label>
				  <input type="text" required id="city" name="city" value="<?php echo (isset($modelo->data_array[0]['city']) ? $modelo->data_array[0]['city'] : "N/A" )?>" placeholder="Lisboa">
			  </div>
		  </div>
                  
          <label for="country">País<span class="mandatory">*</span></label>
          <select id="country" required name="country">
         	  <option selected value="Portugal">Portugal</option>
         	  <option value="Espanha">Espanha</option>
          </select>
       
        </fieldset>
        <button type="submit" name="formupadd" form="formupadd" id="reg-bt">Atualizar morada</button>
	
	</form>
</div>
