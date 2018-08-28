<?php
/**
 * Classe para registo de utilizadores
 *
 * @package SocialArt
 * @version 1.0
 *
 */

class GerirMoradaModel{

	/**
	 * $form_data
	 *
	 * Armazena os dados do utilizador
	 * provenientes do form
	 *
	 * @access public
	 */
	public $form_data;

	/**
	 * $methods
	 *
	 * Intancia da classe Methods
	 *
	 * @access public
	 */
	public $methods;
	
	/**
	 * $db
	 *
	 * O objeto da nossa conexão PDO
	 *
	 * @access public
	 */
	public $db;
	
	/**
	 * $db
	 *
	 * O objeto de Login
	 *
	 * @access public
	 */	
	public $login;
	
	/**
	 * $controller
	 *
	 * Recebe o controller
	 *
	 * @access public
	 */
	public $controller;
	
	/**
	 * $parametros
	 *
	 * Variavel que vai receber
	 * os parametros do url
	 *
	 * @access public
	 */
	public $params;

	/**
	 * $data_array
	 *
	 * Contém dados do
	 * que for necessário
	 *
	 * @access public
	 */	
	public $data_array;
		
	/**
	 * Construtor para essa classe
	 *
	 * Configura o DB, o Login, o controlador, os parâmetros e dados do utilizador.
	 *
	 * @access public
	 * @param object $db Objeto da nossa conexão PDO
	 * @param object $controller Objeto do controlador
	 * @param object $login Objeto do login
	 */
	public function __construct( $db, $controller, $login ) {
		// Carrega o BD
		$this->db = $db;
		
		//Carrega o Login
		$this->login = $login;
		
		$this->methods = new Methods();
		
		$this->controller = $controller;
		$this->params = $this->controller->parametros;
		
		if(isset($this->params[0])){
			$data_test = array("user_userid"=>$this->login->getUserID(), "addressid"=>$this->params[0]);
			$rows = $this->db->countRows("address", "*", true, $data_test, "LIKE", "AND");
			if($rows <= 0){ header('Location:/ProjetoFinal/'); }
			$this->data_array = $this->loadAddress();
		}
		
	}
	
		
   /*
	* Carrega a morada do user
	*
	* @version 1.0
	* @access public
    */
	public function loadAddress(){
		$add_data = array("addressid"=>$this->params[0]);
		return $this->db->selectWConditions("address", "*", true, $add_data, "=", "", "addressid ASC");
	}
	
   /*
	* Cria uma nova morada
	*
	* @version 1.0
	* @access public
    */
	public function newAdress() {

		// Configura os dados do formulário
		$this->form_data = array();
		
		// Verifica se algo foi postado
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && !empty( $_POST ) && isset($_POST['formreg'])) {
			
			// Faz o loop dos dados do post
			foreach ( $_POST as $key => $value ) {
				// Configura os dados do post para a propriedade $form_data
				$this->form_data[ $key ] = $value;
			}
			
			unset($this->form_data['formreg']);
			
			// Verifica se os campos obrigatórios estão preenchidos
			$chk_fields = $this->methods->chk_mandatory_fields($this->form_data);
			
			if(count($chk_fields) > 0){
				$aux = implode("<br>   ",$chk_fields);
				echo '<script > 
						alertBox("Campos Obrigatórios", "Os campos abaixo são obrigatórios!<br>'.$aux.'"); 
					  </script>';
				return;
			}else{
				
				// Variavel temporária com o userid 
				$this->form_data["user_userid"] = $this->login->getUserID();

				// Insere a morada
				$statusAddr = $this->db->simpleInsert("address", $this->form_data );
				
				// Testa se tudo foi inserido corretamente,
				// e dá essa informação ao user
				if(isset($statusAddr) && $statusAddr[0] && is_numeric($statusAddr[1])){
					echo '<script > 
							alertBox("Adicionou uma nova morada.", "A nova morada foi adicionada com sucesso.");
						  </script>';
				}else{
					sleep(5);
					echo '<script > 
							alertBox("Ocorreu um erro!","Ocorreu um erro, a nova morada não foi criada. <br>Erro: '.$statusAddr[1].'");
						  </script>';
					return;
				}
			}
			
		} else {

			//Enquanto não é enviado nada a função não faz nada
			return;

		}
	}
	
	public function updateAdress(){

		// Configura os dados do formulário
		$this->form_data = array();
		
		// Verifica se algo foi postado
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && !empty( $_POST ) && isset($_POST['formupadd'])) {
			
			// Faz o loop dos dados do post
			foreach ( $_POST as $key => $value ) {
				// Configura os dados do post para a propriedade $form_data
				$this->form_data[ $key ] = $value;
			}
			
			unset($this->form_data['formupadd']);
			// Verifica se os campos obrigatórios estão preenchidos
			$chk_fields = $this->methods->chk_mandatory_fields($this->form_data);
			
			if(count($chk_fields) > 0){
				$aux = implode("<br>   ",$chk_fields);
				echo '<script > 
						alertBox("Campos Obrigatórios", "Os campos abaixo são obrigatórios!<br>'.$aux.'"); 
					  </script>';
				return;
			}else{
				
				// Variavel temporária com o userid 
				$where = array("addressid" => $this->data_array[0]['addressid']);

				// atualiza a morada
				$statusAddr = $this->db->updateWConds("address", $where, "=", "", $this->form_data);
				
				// Testa se tudo foi inserido corretamente,
				// e dá essa informação ao user
				if(isset($statusAddr) && $statusAddr[0]){
					sleep(3);
					echo '<script > 
							alertBox("A sua morada foi atualizada com sucesso.", "");
						  </script>';
				}else{
					
					echo '<script > 
							alertBox("Ocorreu um erro!","Ocorreu um erro, a nova morada não foi atualizada. <br>Erro: '.$statusAddr[1].'");
						  </script>';
					return;
				}
			}
			
		} else {

			//Enquanto não é enviado nada a função não faz nada
			return;

		}
	}


}