<?php
/**
 * AppManager - Gere os Models, os Controllers e as Views
 *
 * @package SocialArt
 * @version 1.0
 */
class AppManager{

	/**
	* $controlador
	*
	* Receberá o valor do controlador através da URL
	* exemplo.com/controlador/
	*
	* @access private, só dentro deste scope
	*/
	private $controlador;

	/**
	* $acao
	*
	* Receberá o valor da ação também através da URL
	* exemplo.com/controlador/acao
	*
	* @access private, só dentro deste scope
	*/
	private $acao;

	/**
	* $parametros
	*
	* Receberá um array dos parâmetros também atravésda URL
	* exemplo.com/controlador/acao/param1/param2/paramN
	*
	* @access private, só dentro deste scope
	*/
	private $parametros;

	/**
	* $not_found -> Error 404
	*
	* Caminho da página não encontrada
	*
	* @access private, só dentro deste scope
	*/
	private $not_found = '/views/_includes/404.php';
 
	/**
	* Construtor para essa classe
	*
	* Obtém os valores do controlador, ação e parâmetros. Configura 
	* o controlado e a ação (método).
	*/
	public function __construct ( ) {

		 /**
		 * Obtém os valores do controlador, ação e parâmetros da URL.
		 * E configura as propriedades da classe.
		 */
		 $this->get_url_data();

		 /**
		 * Verifica se o controlador existe. Caso contrário, adiciona o
		 * controlador padrão (controllers/home-controller.php) e chama o método index().
		 */
		 if ( ! $this->controlador ) {
			 // Adiciona o controlador padrão
			 require_once ABSPATH . '/controllers/home-controller.php';

			 // Cria o objeto do controlador "home-controller.php"
			 // Este controlador deverá ter uma classe chamada HomeController
			 $this->controlador = new HomeController();

			 // Executa o método index()
			 $this->controlador->index();
			 return;
		 }

		 // Se o arquivo do controlador não existir, é mostrada a página 404
		 if ( ! file_exists( ABSPATH . '/controllers/' . $this->controlador . '.php' ) ) {
			 // Página não encontrada
			 require_once ABSPATH . $this->not_found;
			 
			 return; 	 
		 }

		 // Inclui o arquivo do controlador
		 require_once ABSPATH . '/controllers/' . $this->controlador . '.php';

		 // Remove caracteres inválidos do nome do controlador para gerar o nome
		 // da classe. Se o arquivo chamar "news-controller.php", a classe vai ser
		 // nomeada para NewsController.
		 $this->controlador = preg_replace( '/[^a-zA-Z]/i', '', $this->controlador );

		 // Caso a classe do controlador não exista aparece a página Not Found
		 if ( ! class_exists( $this->controlador ) ) {
			 // Página não encontrada
			 require_once ABSPATH . $this->not_found;
			 return;
		 }

		 // Cria o objeto da classe do controlador e envia os parâmetros
		 $this->controlador = new $this->controlador( $this->parametros );

		 // Se o método indicado existir, executa o método e envia os parâmetros
		 if ( method_exists( $this->controlador, $this->acao ) ) {
			 $this->controlador->{$this->acao}( $this->parametros );
			 return;
		 }

		 // Sem ação, chamamos o método index
		 if ( ! $this->acao && method_exists( $this->controlador, 'index' ) ) {
			 $this->controlador->index( $this->parametros ); 
			 return;
		 }

		 // Página não encontrada
		 require_once ABSPATH . $this->not_found;
		 return;
	}
 
	 /**
	 * Obtém parâmetros de $_GET['path']
	 *
	 * Obtém os parâmetros de $_GET['path'] e configura as propriedades 
	 * $this->controlador, $this->acao e $this->parametros
	 *
	 * O URL deverá ter o seguinte formato:
	 * http://www.example.com/controlador/acao/parametro1/parametro2/etc...
	 */
	 public function get_url_data () {

		 // Verifica se o parâmetro path foi enviado
		 if ( isset( $_GET['path'] ) ) {
			 // Guarda o valor do $_GET['path'] numa variavel
			 $path = $_GET['path'];

			 // Limpa os dados
			 $path = rtrim($path, '/');
			 $path = filter_var($path, FILTER_SANITIZE_URL);

			 // Cria um array de parâmetros
			 $path = explode('/', $path);
			 
			 // Configura as propriedades
			 $this->controlador  = chk_array($path, 0 );
			 $this->controlador .= '-controller';
			 $this->acao         = chk_array( $path, 1 );

			 // Configura os parâmetros
			 if ( chk_array( $path, 2 ) ) {
				 unset( $path[0] );
				 unset( $path[1] );
				 // Os parâmetros vêm sempre após a ação
				 $this->parametros = array_values( $path );
			 }
		 }
	 }
}
?>