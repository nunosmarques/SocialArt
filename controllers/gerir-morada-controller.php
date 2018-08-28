<?php
/**
 * Classe EditarMoradaController
 * Controller para gerir moradas
 * 
 * @package SocialArt
 * @since 0.1
 */
class GerirMoradaController extends MainController {


	/**
	 * Carrega a página "/views/user-register/index.php"
	 */
	public function index() {
		
		// Title da página
		$this->title = 'Adicionar nova morada';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'gerir-morada/gerir-morada-model' );

		/** Carrega os arquivos das views **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//Funções em javascript
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';

		// /views/user-register/index.php
		require ABSPATH . '/views/gerir-morada/gerir-morada-view.php';
		
		//Funções em javascript
		echo '<script src="'.HOME_URI.'/views/_js/login-reg.js?v='.time().'"></script>';
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';
		
		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
	}
	
	public function editarMorada() {
		
		// Title da página
		$this->title = 'Editar Morada';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'gerir-morada/gerir-morada-model' );

		/** Carrega os arquivos das views **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//Funções em javascript
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';

		// /views/editar-morada/editar-morada.php
		require ABSPATH . '/views/editar-morada/editar-morada-view.php';
		
		//Funções em javascript
		echo '<script src="'.HOME_URI.'/views/_js/login-reg.js?v='.time().'"></script>';
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';
		
		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
	}

}