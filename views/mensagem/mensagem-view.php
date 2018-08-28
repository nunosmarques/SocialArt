<div class="produt-main-container">
	<h2 class="h4center">Conversa</h2>
	<?php
		$modelo->getMessage();
	?>
	<div class="new-msg">
	<form id="new-msg">
		<header class="chat-new-msg"> <h5 align="left">Responder:</h5> </header>
		<div class="new-msg-txt-container">
			<input hidden="true" type="number" value="<?php echo $modelo->params[0] ?>" name="id-msg">
			<textarea rows="6" required cols="30" name="msg"></textarea>
		</div>
		<div class="new-msg-btn-container">
			<button class="general-button btn-send-msg">Responder</button>
		</div>
	</form>
	</div>
	</div>
</div>