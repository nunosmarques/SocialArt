<?php
class MensagemModel extends Methods {
	
	/**
	 * $db
	 *
	 * Guarda a intancia da 
	 * classe DB
	 *
	 */
	public $db;

	/**
	 * $db
	 *
	 * O objeto do Login
	 *
	 * @access public
	 */	
	public $login;	
	
	/**
	 *
	 * Guarda a intancia da 
	 * classe Methods
	 *
	 */	
	public $methods;
	
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
	 * form_data
	 *
	 * Variavel que vai receber
	 * os dados do $_POST
	 *
	 * @access public
	 */	
	public $form_data;
	
	/**
	 * user_data
	 *
	 * Variavel que vai receber
	 * os dados do utilizador
	 *
	 * @access public
	 */	
	public $user_data;	
	
	/**
	 * Construtor para essa classe
	 *
	 * Configura o DB, o controlador, os parâmetros e dados do utilizador.
	 *
	 * @access public
	 * @param object $db Objeto da nossa conexão PDO
	 * @param object $controller Objeto do controlador
	 * @param object $login Objeto do login
	 */
	public function __construct($db, $controller, $login) {
		$this->methods = new Methods();
		$this->db = $db;
		$this->login = $login;
		$this->controller = $controller;
		$this->params = $this->controller->parametros;
		if($this->login->chkUserLogin()){
			$this->user_data = $this->login->loadUser();
		}else{ header('Location:/ProjetoFinal/'); }
	}

	public function getMessage(){
		if(!$this->login->chkUserLogin()){
			return;
		}

		$where = "Mensagem_MensagemID";
		$what = $this->params[0];
		$fields = "Mensagem,SenderID,dataAdicionada,userid,username,email";

		$results = $this->db->selectMensages( $where, $what, $fields, "");

		if($results[0] != false){
			echo '<div class="msg-main-container">';
			foreach($results[1] as $value):
				if($value['SenderID'] == $this->user_data[0]['userid']){
					$class = "receiver-msg";
				}else{ $class = "sender-msg"; $this->receiver = $value['userid']; }
			
				echo '<div class="msg-main-loop-row">';
					echo '<div class="owner">
							<span class="owner-name">'.$value['username'].'</span>
							<br>
							<span class="owner-date">'.$value['dataAdicionada'].'</span>
						  </div>';
					echo '<div class="'.$class.'" align="justify">'.$value['Mensagem'].'</div>';
				echo '</div>';
			
			endforeach;
		}else{
			echo '<div class="msg-main-container">';
			echo '<h4 class="h4center">Não existem conversas com este utilizador!</h4>';
		}
	}

	public function sendMSG(){
		$result = false;
		$data = $_POST;
		
		$new_data = array("Mensagem_MensagemID"=>$data['id'],
						  "Mensagem"=>$data['msg'],
						  "SenderID"=>$this->user_data[0]['userid'],
						  "dataAdicionada"=>$this->methods->getDate());
		
		$result = $this->db->simpleInsert("mensagens", $new_data);
		$msgid = $result[1];
		$this->db->markMsgUnreaded($data['id'], $msgid);
		
		echo json_encode($result);
	}
}
?>