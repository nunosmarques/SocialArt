<?php
/**
 * Classe para registo de utilizadores
 *
 * @package SocialArt
 * @version 1.0
 *
 */

class UserRegisterModel extends Methods{

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
	 *
	 * Guarda a intancia da 
	 * classe Methods
	 *
	 */	
	public $methods;
	
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
		
		//Intancia da classe Methods
		$this->methods = new Methods();
	}
	
   /*
	* Valida o formulário de envio e se 
	* estiver correto cria o user
	*
	* @version 1.0
	* @access public
    */
	public function user_register() {

		// Configura os dados do formulário
		$this->form_data = array();
		// Verifica se algo foi postado
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && !empty( $_POST ) /*&& isset($_POST['formreg'])*/) {
			
			// Faz o loop dos dados do post
			foreach ( $_POST as $key => $value ) {
				// Configura os dados do post para a propriedade $form_data
				$this->form_data[ $key ] = $value;
			}

			// Verifica se os campos obrigatórios estão preenchidos
			$chk_fields = $this->chk_mandatory_fields($this->form_data);
			
			if(sizeof($chk_fields) > 0){
				$aux = implode("<br>   ",$chk_fields);
				echo '<script > 
						alertBox("Campos Obrigatórios", "Os campos abaixo são obrigatórios!<br>   '.$aux.'"); 
					  </script>';
				return;
			}
			
			// Verifica se as passwords introduzidas são iguais
			if( isset($this->form_data["password"]) && isset($this->form_data["chkpassword"])){
				if(!$this->passMatch($this->form_data["password"], $this->form_data["chkpassword"]) == "false"){
					return;
				}
			}else{
				return;
			}

			// Reune os campos do user, pois é inserido na BD antes de inserir a morada
			$users = $this->split_users_fields($this->form_data);
			
			
			// Reune os campos da morada, uma vez que é iserida na BD depois da creação do user
			$adress = $this->split_adress_fields($this->form_data);
			
			
			// Verifica se o user existe
			$user = array("username" => $this->form_data["username"]);
			$exist = $this->db->select_check("user", $user);
			if($exist == true){
				echo '<script > 
						alertBox("Utilizador já existe.", "O nome de utilizador \"'.strtoupper($this->form_data["username"]).'\" já está a ser utilizado.<br>Por favor, escolha um nome de utilizador diferente."); 
					  </script>';
				return;
			}
 			$users["Seller"] = "N";
			$users["dataRegisto"] = $this->getDate();
			
			// Insere o user na BD
			$statusUsr  = $this->db->simpleInsert("user", $users );
		
			// Testa se o user foi inserido com sucesso e insere a morada
			if( $statusUsr[0] ){
				sleep(2);
				
				$uid = array("userid"=>$statusUsr[1]);
				$tmp = array("hash"=>$statusUsr[1].'xyz'.$this->methods->genRandomString(55,null));
				$this->db->updateWConds("user", $uid, "=", "",$tmp);
				
				// Variavel temporária com o userid do user criado anteriormente
				$adress["User_userID"] = intval($statusUsr[1]);
				$adress["fullname"] = $this->form_data["firstname"].' '.$this->form_data["lastname"];

				// Insere a morada
				$statusAddr = $this->db->simpleInsert("address", $adress );
				
				// Testa se tudo foi inserido corretamente,
				// e dá essa informação ao user
				if(isset($statusAddr) && $statusAddr[0]){
					$content   = '<html> <body>';
					$content  .= '<h2>Obrigado por se registar no SocialArt '.$this->form_data["firstname"].' '.$this->form_data["lastname"].'</h2>';
					$content  .= '<p><strong>Username:</strong> '.$this->form_data["username"].'</p>';
					$content  .= '<p><strong>Email:</strong> '.$this->form_data["email"].'</p>';
					$content  .= '<a href="localhost/ProjetoFinal/email-ops/confirmAccount/'.$tmp["hash"].'">Confirme a sua conta</a>';
					$content  .= '<br><br><h4>Obrigado pela sua preferência.</h4>';
					$content  .= '</body></html>';
					
					
					$this->methods->sendMail("SocialArt - Registo de Utilizador", "nuno.markez@gmail.com", $this->form_data["email"], "Confirmação do Registo", $content);
					if($this->form_data["Seller"] == "Y"){
						unset($content);
						$content   = '<html> <body>';
						$content  .= '<h2>O utilizador '.$this->form_data["firstname"].' '.$this->form_data["lastname"].' pretende ser vendedor na SocialArt.</h2>';
						$content  .= '<p><strong>Username:</strong> '.$this->form_data["username"].'</p>';
						$content  .= '<p><strong>Email:</strong> '.$this->form_data["email"].'</p>';
						$content  .= '<h4>Este processo carece da aprovação dos administradores:</h4>';
						$content  .= '<a href="localhost/ProjetoFinal/email-ops/aproveSeller/'.$statusUsr[1].'xyzApXmwGvqVXUHK7nT3hmdNDBkU6jqI8K1TdaFh191cE4WyE1xrLczeNqY">Aprovar</a>
									  <br><br>
									  <a href="localhost/ProjetoFinal/email-ops/aproveSeller/'.$statusUsr[1].'xyzmS1EXwDh0ZZ4iVyBvm8MFbtILApKt3KEI541b1qonEPW3iSXX6EqySDN">Desaprovar</a>';
						$content  .= '</body></html>';						
						$this->methods->sendMail("SocialArt - Aprovações", "nuno.markez@gmail.com", "nuno.markez@gmail.com", "Administrador - Aprovar vendedor", $content);
					}
					echo '<script > 
							alertBox("Sucesso","'.$this->form_data["firstname"].' '.$this->form_data["lastname"].' a sua conta foi criada<br>com sucesso.<br>Por favor verifique se recebeu o email de confirmação.");
						  </script>';
				}else{
					sleep(5);
					echo '<script > 
							alertBox("Sem Sucesso","Ocorreu um erro na criação do seu utilizador.<br>Tente novamente.<br>Erro: '.$statusAddr[1].'");
						  </script>';
					return;
				}
			}else{
				sleep(5);				
				echo '<script >
						alertBox("Sem Sucesso","Ocorreu um erro na criação do seu utilizador.<br>Tente novamente.<br>Erro: '.$statusUsr[1].'");
					  </script>';
				return;
			}
			
			// Efetuar debug se este estiver a "true"
			if ( defined('DEBUG') && DEBUG != true){
				var_dump($adress);
				var_dump($this->form_data);
				echo "Status: ".$status[1];
				echo "debug";
			}
		} else {

			//Enquanto não é enviado nada a função não faz nada
			return;

		}
	}
}