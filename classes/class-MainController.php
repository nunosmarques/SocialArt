<?php
/**
* MainController - Todos os controllers deverão estender essa classe
*
* @package SocialArt
 * @version 1.0
*/
class MainController{

	/**
	* $db
	* A minha conexão com a base de dados, mantem o objeto PDO
	* @access public
	*/
	public $db;

	/**
	* $db
	* A minha classe de login, mantem o
	* objeto de Login em todos os modelos
	* @access public
	*/
	public $login;
	
	/**
	* $phpass
	* Classe phpass 
	* @see http://www.openwall.com/phpass/
	* @access public
	*/
	public $phpass;

	/**
	* $title
	* Título das páginas 
	* @access public
	*/
	public $title;

	/**
	* $parametros
	* @access public
	*/
	public $parametros = array();

	/**
	* Construtor da classe
	* Configura as propriedades e métodos da classe.
	* @versão 1.0
	* @access public
	*/
	public function __construct ( $parametros = array() ) {

		// Instancía a classe DB
		$this->db = new DB();

		$this->login = new UserLogin();

		// Parâmetros
		$this->parametros = $parametros;
	}
	
	
	/**
	* Load model
	*
	* Carrega os modelos presentes na pasta /models/.
	*
	* @since 0.1
	* @access public
	*/
	public function load_model( $model_name ) {
		// Um arquivo deverá ser enviado  
		if ( ! $model_name ) return;

		// Garante que o nome do modelo tenha letras minúsculas
		$model_name =  strtolower( $model_name );

		// Inclui o arquivo
		$model_path = ABSPATH . '/model/' . $model_name . '.php';

		// Verifica se o arquivo existe
		if ( file_exists( $model_path ) ) {
			// Inclui o arquivo
			require_once $model_path;

			// Remove os caminhos do arquivo (se tiver algum)
			$model_name = explode('/', $model_name);

			// Pega só o nome final do caminho
			$model_name = end( $model_name );

			// Remove caracteres inválidos do nome do arquivo
			$model_name = preg_replace( '/[^a-zA-Z0-9]/is', '', $model_name );

			// Verifica se a classe existe
			if ( class_exists( $model_name ) ) {
				$url = $_SERVER['REQUEST_URI'];
				// Retorna um objeto da classe
				return new $model_name( $this->db, $this, $this->login);
			}
			return;
		}
	}
}