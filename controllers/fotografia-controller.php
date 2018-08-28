<?php
/**
 * Classe HomeController
 * Controller da página inicial
 *
 * @package SocialArt
 * @version 1.0
 */
class FotografiaController extends MainController{
 
	/**
	* Carrega a página "/views/home/home-view.php"
	*/
	public function index() {
		// Título da página
		$this->title = 'Fotografia';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( '/fotografia/fotografia-model' );

		/** Carrega os arquivos do view **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//<!-- Funções em javascript -->
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php -> Incluir o Cabeçalho HTML
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php -> Incluir o Menu da página
		require ABSPATH . '/views/_includes/menu.php';
		
		// /views/_includes/addcartpopup.php -> Incluir o popup de adicionar ao carrinho
		require ABSPATH . '/views/_includes/addcartpopup.php';
		
		// /views/home/home-view.php -> Incluir o corpo da página
		require ABSPATH . '/views/fotografia/fotografia-view.php';
		
		//Altera o background do botão do menu
		echo "<script> menu_switch(2); </script>";
		
		// /views/_includes/footer.php -> Incluir o rodapé
		require ABSPATH . '/views/_includes/footer.php';
	}
	
 	public function addToCart(){
		// Instanciamento do model
		$modelo = $this->load_model( '/fotografia/fotografia-model' );
		$modelo->addItems();
	}
	
 	public function addToFav(){
		// Instanciamento do model
		$modelo = $this->load_model( '/pintura/pintura-model' );
		$modelo->addFav();
	}
}
?>