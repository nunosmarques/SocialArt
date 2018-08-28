<?php
// /views/_includes/header.php -> Incluir o Cabeçalho HTML
$this->title = "Página não encontrada";
require 'header.php';

// /views/_includes/menu.php -> Incluir o Menu da página
require 'menu.php';

?>
<div class="notfound404">
	<h1 align="center" style="font-size: 170px;">404</h1>
	<h3 align="center" style="font-size: 40px; margin-top:-2%; ">NOT FOUND</h3>
	<div class="shadow"></div>
</div>
<?php
// /views/_includes/footer.php -> Incluir o rodapé
require 'footer.php';
?>