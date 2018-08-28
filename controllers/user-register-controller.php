<?php
/**
 * Classe UserRegisterController
 * Controller do registo de utilizador
 * 
 * @package SocialArt
 * @version 0.1
 */
class UserRegisterController extends MainController {

	/**
	 * $login_required
	 *
	 * Se a página precisa de login
	 *
	 * @access public
	 */
	public $login_required = false;

	/**
	 * Carrega a página "/views/user-register/index.php"
	 */
	public function index() {
		
		$chk = new UserLogin(); 
		if($chk->chkUserLogin()){ header('Location:'.HOME_URI.'/'); }
		
		// Title da página
		$this->title = 'Registo de Utilizador';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'user-register/user-register-model' );

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
		require ABSPATH . '/views/user-register/user-register-view.php';
		
		//Altera o background do botão do menu
		echo "<script> menu_switch(0); </script>";
		
		//Funções em javascript
		echo '<script src="'.HOME_URI.'/views/_js/login-reg.js?v='.time().'"></script>';
		
		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
	}

}