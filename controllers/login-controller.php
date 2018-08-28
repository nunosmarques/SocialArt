<?php
/**
 * LoginController
 *
 * @package SocialArt
 * @versão 1.0
 */
class LoginController extends MainController {

	/**
	 * Carrega a página "/views/login/index.php"
	 */
	public function index() {
		// Título da página
		$this->title = 'Login';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Login não tem Model

		/** Carrega os arquivos do view **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//<!-- Funções em javascript -->
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';

		// /views/home/login-view.php
		require ABSPATH . '/views/login/login-view.php';

		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';

	}

}