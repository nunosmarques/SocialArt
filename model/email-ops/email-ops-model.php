<?php
class EmailOpsModel extends Methods {
	
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
	}
	
	public function getUserid(){
		$hash = $this->params[0];
		if(strlen($hash) <= 0){
			return;
		}
		//xyz
		$xpos = strpos($hash, "xyz");	
		//zxy
		$zpos = strpos($hash, "zxy");
		$id = substr($hash, $xpos + 3, $zpos - ($xpos+3));
		return($id);
	}
	
	public function getUsername(){
		$id = $this->getUserid();
		if(strlen($id) <= 0){
			return;
		}
		$data = array("userid"=>$id);
		$this->user_data = $this->db->selectWConditions("user","firstname,lastname",true,$data, "=", "", "userid DESC");
		return $this->user_data[0]['firstname'].' '.$this->user_data[0]['lastname'];
	}
	
	public function getUserEmail(){
		$id = $this->getUserid();
		if(strlen($id) <= 0){
			return;
		}
		$data = array("userid"=>$id);
		$this->user_data = $this->db->selectWConditions("user","email",true,$data, "=", "", "userid DESC");
		return $this->user_data[0]['email'];
	}
	
	public function promote(){
		$hash  = $this->params[0];
		if(strlen($hash) <= 0){
			return;
		}
		$pos = strpos($hash, "xyz");
		$id = substr($hash, 0, $pos);
		$op = substr($hash, -1);

		$data = array("userid"=>$id);
		$up   = array("Seller"=>$op);
		
		$result = array();
		
		$results = $this->db->updateWConds("user", $data, "LIKE", "AND",$up);
		
		if($results[0] && $results[1] > 0){
			$result = array($results[0],$results[1],"Y");
		}else{
			array(false,0,"N");
		}
		
		return($result);
	}
	
	public function confirmAccount(){
		$hash  = $this->params[0];
		if(strlen($hash) <= 0){
			return;
		}
		
		$pos = strpos($hash, "xyz");
		$id = substr($hash, 0, $pos);
		
		$data = array("hash"=>$hash);
		$up   = array("hash"=>"Y");
		$result = $this->db->updateWConds("user", $data, "LIKE", "AND",$up);
		
		return($result);
	}
	
	public function chkUserAndSendMail(){
		$usr = isset($_POST['usr']) ? $_POST['usr'] : null;
		$result = array(false);

		if($usr == null){
			$result = array(false);
		}
		
		$data = array("username"=>$usr);
		$rows = $this->db->countRows("user", "userid", true, $data, "LIKE", "");
		
		if($rows <= 0){
			$data1 = array("email"=>$usr);
			$rows = $this->db->countRows("user", "userid", true, $data1, "LIKE", "");
		}
		
		if($rows == 1){
			$results = $this->db->selectWConditions("user","userid,firstname,lastname,email",true,$data, "LIKE", "OR", "userid DESC");
			
			$hash = $this->methods->genRandomString(28,null).'xyz'.$results[0]['userid'].'zxy'.$this->methods->genRandomString(28,null);
			
			$content   = '<html> <body>';
			$content  .= '<h2>'.$results[0]["firstname"].' '.$results[0]["lastname"].' solicitou uma alteração de palavra-passe?</h2>';
			$content  .= '<h4>Siga o link abaixo para repor a sua palavra-passe:</h4>';
			$content  .= '<a href="localhost/ProjetoFinal/email-ops/alterar_password/'.$hash.'">Alterar palavra-passe</a>';
			$content  .= '</body></html>';						
			$this->methods->sendMail("SocialArt - Alteração de palavra-passe", "nuno.markez@gmail.com",$results[0]["email"] , "Alteração de palavra-passe", $content);
			$result = array(true);
		}else{
			$result = array(false);
		}
		
		return json_encode($result);
	}
		
	public function chPwd(){
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && isset($_POST['chpwd'])){
			$status[0] = false;
			$id = $_POST['id'];
			$n_pwd = $_POST['n_pwd'];
			$cn_pwd = $_POST['nc_pwd'];
			
			$data = array("userid"=>$id);
			$rows = $this->db->countRows("user", "userid", true, $data, "=", "");

			if($rows == 1){
				if($this->methods->passMatch($n_pwd,$cn_pwd)){
					$new_pwd = md5($n_pwd."tralaicosloki");
					$cond = array("password"=>$new_pwd);
					$data = array("userid"=>$id);
					$result = $this->db->updateWConds("user", $data, "=", "", $cond);
					
					if($result){
						
						unset($cond);
						$hash = $statusUsr[1].'xyz'.$this->methods->genRandomString(55,null);
						$cond = array("hash"=>$hash);
						$this->db->updateWConds("user", $data, "=", "", $cond);
						
						$status[0] = true;
						$content   = '<html> <body>';
						$content  .= '<h2>'.$this->getUsername().' confirme a alteração da sua palavra-passe</h2>';
						$content  .= '<h4><strong>Siga o link para confirmar:</strong></h4>';
						$content  .= '<a href="localhost/ProjetoFinal/email-ops/confirmAccount/'.$hash.'">Confirme a alteração de palavra-passe</a>';						$content  .= '</body></html>';						
						$this->methods->sendMail("SocialArt - Alteração de palavra-passe", "nuno.markez@gmail.com", $this->getUserEmail(), "Confirmar alteração de palavra-passe", $content);						
						
					}else{
						$status[0] = false;
						$status[1] = "Ocorreu um erro, a sua password não foi alterada! Tente novamente.";
					}
				}else{
					$status[0] = false;
					$status[1] = "As palavras-passe não são iguais!";
				}
			}else{
				$status[0] = false;
				$status[1] = "Verifique se colocou a sua palavras-passe atual corretamente!";
			}
			echo json_encode($status);
		}
	}
}
?>