<?php
/**
 * Classe CarrinhoController
 * Controller da página do Carrinho
 *
 * @package SocialArt
 * @version 1.0
 */
class CarrinhoController extends MainController{
 
	/**
	* Carrega a página "/views/home/home-view.php"
	*/
	public function index() {

		// Título da página
		$this->title = 'Carrinho';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( '/carrinho/carrinho-model' );

		/** Carrega os arquivos do view **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';
		
		//Funções em javascript
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';

		// /views/_includes/header.php -> Incluir o Cabeçalho HTML
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php -> Incluir o Menu da página
		require ABSPATH . '/views/_includes/menu.php';
		
		// /views/home/home-view.php -> Incluir o corpo da página
		require ABSPATH . '/views/carrinho/carrinho-view.php';
		
		//echo '<script src="https://www.paypalobjects.com/api/checkout.js"></script>';
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';
		echo '<script src="'.HOME_URI.'/views/_js/login-reg.js?v='.time().'"></script>';
		echo '<script src="https://www.paypalobjects.com/api/checkout.js"></script>';
		// /views/_includes/footer.php -> Incluir o rodapé
		require ABSPATH . '/views/_includes/footer.php';
	}
	
	public function updateAddress() {
		// Instanciamento do model
		$modelo = $this->load_model( '/carrinho/carrinho-model' );
		
		$modelo->updateAddress();	
	}
	
	public function deleteFromCart(){
		// Instanciamento do model
		$modelo = $this->load_model( '/carrinho/carrinho-model' );
		
		$modelo->deleteFromCart();		
	}

	public function afterPaypal(){
		// Instanciamento do model
		$modelo = $this->load_model( '/carrinho/carrinho-model' );
		
		$modelo->getPurchase();
	}
}
?>