<?php
/**
 * UserLogin - Manipula os dados de usuários
 *
 * Manipula os dados dos utilizadores, faz login e logout, verifica permissões e 
 * redireciona página para usuários logados.
 *
 * @package SocialArt
 * @version 1.0
 */
class UserLogin{
	
	/**
	 * Dados do post do formulário
	 *
	 * @public
	 * @access public
	 * @var array
	 */
	public $form_data;

	/**
	 * A nossa ligação à BD
	 *
	 * @public
	 * @access public
	 *
	 */
	public $dbcon;

	/**
	 * A classe Methods
	 *
	 * @public
	 * @access public
	 *
	 */
	public $methods;
	
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
	 * Construtor da classe
	 *
	 * @versão 1.0
	 * @access public
	 *
	 */
	public function __construct(){
		$this->dbcon = new DB();
		$this->methods = new Methods();
		if($this->chkUserLogin()){
			$this->user_data = $this->loadUser();
		}
	}

	/**
	 *
	 * Efetua o login e cria a sessão do utilizador
	 * com os dados relevantes armazenados
	 *
	 */
	public function login() {
		$result = array(false);
		
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ]){
			// Faz o loop dos dados do post
			foreach ( $_POST as $key => $value ) {
				if(!empty($value)){
					if($key == "password"){
						// Configura os dados do post para a propriedade $form_data
						$this->form_data[ $key ] = md5($value."tralaicosloki");						
					}else{
						// Configura os dados do post para a propriedade $form_data
						$this->form_data[ $key ] = $value;
					}
				}
			}
			
			$data = array("username"=>$this->form_data['username'], "password"=>$this->form_data['password'],"hash"=>"Y");
			$rows = $this->dbcon->countRows("user", "*", true, $data, "LIKE", "AND");
			
			if($rows <= 0){
				unset($data);
				$data = array("email"=>$this->form_data['username'], "password"=>$this->form_data['password'],"hash"=>"Y");
				$rows = $this->dbcon->countRows("user", "*", true, $data, "LIKE", "AND");
			}
			
			if($rows == 1){
				$data = array("username"=>$this->form_data['username']);
				$ch = array("LastLogin"=>$this->methods->getDate());
				$this->dbcon->updateWConds("user", $data, "LIKE", "", $ch);
				
				if($rows <= 0){
					unset($data);
					$data = array("email"=>$this->form_data['username']);
					$this->dbcon->updateWConds("user", $data, "LIKE", "", $ch);
				}
								
				$userdata = $this->dbcon->select("user",$this->form_data);
				
				if(!$userdata[0]){
					$result = array(false);
				}
				
				if($this->create_user_session($userdata[1])){
					$this->logged_in = true;
					$result = array(true, ucfirst($this->getUserName()));
				}

			}else{
				$result = array(false);
			}

			echo json_encode($result);
		}
	}

	/**
	 *
	 * Cria a sessão do utilizador
	 * com os dados relevantes armazenados
	 *
	 */
	public function create_user_session( $data ){
		if(empty($data)){ return; }
		
		foreach ($data as $key => $value):
			$_SESSION["userdata"][$key] = $value;
		endforeach;
		
		if(!isset($_SESSION["userdata"]) || empty($_SESSION["userdata"])){
			return false;
		}
		
		$_SESSION['logged_in'] = true;
		return true;
	}
	
	/**
	 *
	 * Verifica se o utilizador efetou login
	 *
	 */	
	public function chkUserLogin(){
		
		if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true){
			return false;
		}
		
		return true;
	}
	
	/**
	 *
	 * Destrói a sessão do utilizador
	 * e elimina os dados da sessão
	 *
	 */
	public function logout(){
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && isset($_POST['lgout'])){
			// Remove todos os dados da sessão $_SESSION['userdata']
			$_SESSION[ 'userdata' ] = array();
			$_SESSION['logged_in'] = false;
			// Para garantir que a sessão perde toda a informação.
			unset( $_SESSION[ 'userdata' ] );
			unset( $_SESSION['logged_in'] );
			
			// Regenera o ID da sessão
			session_regenerate_id();
			sleep(3);
			header('Location:/ProjetoFinal/');
		}
	}

	public function loadUser(){
		$user_data = array("userid"=>$this->getUserID());
		return $this->dbcon->selectWConditions("user", "userid,username,firstname, lastname,nif,email,phone,LastLogin,description,Seller,dataRegisto", true, $user_data, "=", "", "userid ASC");
	}
	
	/*
	 *
	 * Função que devolve o UserID
	 *
	 */
	public function getUserID(){
		if($this->chkUserLogin()){
			return $_SESSION["userdata"][0]['userid'];
		}else{
			return;
		}
	}
		
	/*
	 *
	 * Função que devolve o UserName
	 *
	 */
	public function getUserName(){
		if($this->chkUserLogin()){
			return $_SESSION["userdata"][0]['username'];
		}else{
			return;
		}
	}
	
	/*
	 *
	 * Função carrega todos os 
	 * dados do utilizador
	 *
	 */
	public function getUserData(){
		$user = array( "userid" => $this->getUserID() );
		$results = $this->dbcon->selectWConditions("user", "*", true, $user, "LIKE", "", "userid DESC" );
		return $results;
	}
	
	/**
	 * Verifica permissões
	 *
	 * @param string $required A permissão requerida
	 * @param array $user_permissions As permissões do usuário
	 * @final
	 */
	final protected function check_permissions( $required, $user_permissions) {
		if ( !is_array( $user_permissions ) ) {
			return;
		}

		// Se o utilizador não tiver permissão
		if ( !in_array( $required, $user_permissions ) ) {
			return false;
		} else {
			return true;
		}
	}
	
	public function countAlerts(){
		$userdata = array();
		if($this->chkUserLogin()){
			$userdata = $this->loadUser();
		}else{ return; }
		
		$data = array("Follower_userID"=>$userdata[0]['userid'], "New"=>"Y");
		$count = $this->dbcon->countRows("notificacoes", "*", true, $data, "=", "AND" );
		
		return $count;
	}
	
	public function countMSG(){
		$userdata = array();
		
		if($this->chkUserLogin()){
			$userdata = $this->loadUser();
		}else{ return; }

		$count = $this->dbcon->countNewMSGRows($userdata[0]['userid']);
		
		return $count;
	}
	
	public function countCart(){
		$userdata = array();
		$count = 0;
		if($this->chkUserLogin()){
			$userdata = $this->loadUser();
		}else{ return; }

		$field = "CarrinhoCompraID";
		$data = array("Buyer_User_userID"=>$userdata[0]['userid'], "deleted"=>"N");
		$id = $this->dbcon->selectWConditions("carrinhocompra", $field, true, $data, "=", "AND", "CarrinhoCompraID DESC");
		
		if(count($id)){
			$data = array("CarrinhoCompras_CarrinhoCompraID"=>$id[0]['CarrinhoCompraID'], "deleted"=>"N");
			$count = $this->dbcon->countRows("produtoscarrinho", "*", true, $data, "=", "AND" );
		}
		
		return $count;
	}
	
	public function teste(){ echo '<script> alert("xXx"); </script>'; }
}