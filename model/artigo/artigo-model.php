<?php
class ArtigoModel extends Methods {

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
	 * productID
	 *
	 * Variavel que vai receber
	 * o artigo a ser mostrado
	 *
	 * @access private
	 */	
	private $productID;
	
	/**
	 * mensagem
	 *
	 * Variavel que vai receber
	 * o post das mensagens
	 *
	 * @access private
	 */	
	private $mensagem;

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
		}
		
		$this->setProductID($this->params[0]);
		$this->updateView($this->params[0]);
	}
	
	public function getProduct(){
		if(empty($this->params[0])){
			echo '<h4 class="h4center">Ocorreu um erro ao carregar o produto!<br>Tente novamente</4>';
		}else{
			$where = array("ProdutoID"=>$this->getProductID());
			$field = "ProdutoID,NomeProduto,User_userID,Categoria_CategoriaID,Preco,SmallDescription,userid,firstname,lastname,produto.deleted";

			$join = "INNER JOIN user ON produto.User_userID = user.userid";

			$this->form_data = $this->db->freeSelect("produto", $field, true, $where, "=", "AND", $join, "produto.deleted = 'N'", "ORDER BY ProdutoID ASC");

			$sellerName = $this->form_data[0]["firstname"].' '.$this->form_data[0]["lastname"];
			if(strlen($sellerName) > 16){
				$sellerName = substr($sellerName, 0, 16)."...";
			}
			
			echo '<h4 class="prod-details"><span id="prod-name">'.$this->form_data[0]['NomeProduto'].'</span></h4>';
			echo '<h4 class="prod-details"><a href="'.HOME_URI.'/produtos-do-utilizador/index/pagina-1/'.$this->form_data[0]["User_userID"].'/'.$this->form_data[0]['firstname'].' '.$this->form_data[0]['lastname'].'/"><span id="seller-name" value="'.$this->form_data[0]['User_userID'].'">'.$sellerName.'</span></a></h4>';
			if( $this->chkFollow($this->form_data[0]["User_userID"]) == false ){
					echo	'<div class="follow-seller correct-follow">
								<a href="#"><div class="follow-art" title="Seguir '.$sellerName.'" value="'.$this->form_data[0]["User_userID"].'"></div></a>
								<div class="follow-label"></div>
							</div>';
			}else if($this->user_data[0]['userid'] != $this->form_data[0]["User_userID"]){
					echo	'<div class="follow-seller correct-follow">
								<a href="#"><div class="unfollow-art" title="Deixar de seguir '.$this->form_data[0]["firstname"].' '.$this->form_data[0]["lastname"].'" value="'.$this->form_data[0]["User_userID"].'"></div></a>
								<div class="follow-label"></div>
							</div>';
			}
			echo '<h4 class="prod-details">'.$this->form_data[0]['Categoria_CategoriaID'].'</h4>';
			echo '<div class="prod-details-price">
					<div class="prd-price-left"><p>'.$this->form_data[0]['Preco'].' €</p></div>
					<div class="prd-price-right">';
			 if($this->user_data[0]['userid'] != $this->form_data[0]["User_userID"]){
				 echo '<button value="'.$this->params[0].'" class="btn-success btn-addToCart">Adicionar ao Carrinho</button>';
			 }
			echo	'</div>';
			if( $this->chkFav($this->params[0]) == false && $this->user_data[0]['userid'] != $this->form_data[0]["User_userID"]){
				echo '<h4 class="h4center"><a href="#" class="addToFav" title="Adicionar aos favoritos" value="'.$this->params[0].'">Adicionar aos Favoritos</a></h4>';
			}					
			echo '</div>';
			echo '<div class="prd-info">
					<div class="numFavs"><h5 align="center">'.$this->countFavs().'<br><span>Favoritos</span></h5></div>
					<div class="views"><h5 align="center">'.$this->countViews().'<br><span>Views</span></h5></div>
				  </div>';
		}
	}
	
	public function getProdDescription(){//'
		echo $this->form_data[0]['SmallDescription'];
	}
	
	public function getProductImg(){
		$data     = array("ProdutoID"=>$this->getProductID());
		$img_res = $this->db->selectWConditions("imagem", "imgID,imgNome,dataAdicionado", true, $data, "=", "", "imgID");
		$img_name = (isset($img_res[0]['imgNome']) ? $img_res[0]['imgNome'] : "none");
		$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;	
		
		echo '<div class="main-thumbnails">';
		for($i = 0; $i < count($img_res); $i++):
			$img_name = (isset($img_res[$i]['imgNome']) ? $img_res[$i]['imgNome'] : "none");
			$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;
		
			echo '<div class="thumbnails">
					<a href="#'.$i.'">';
				if($img_name != "none" && is_file($chk_img)){
					echo '<img src="'.HOME_URI.'/views/_uploads/'.$img_name.'" width="auto" height="auto"/>';
				}else{
					echo '<img src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
				}
			echo   '</a>
				 </div>';
		endfor;
		echo '</div>';
		
		echo '<div class="main-image">';
			//$img = "/_images/img2.jpg";
			//$img = "teste1.jpg";
		
			/*list($width, $height) = getimagesize('./views/_uploads/'.$img);
		
			if($width == $height){
				$class = "square";
			}
		
			if($width > $height){
				$class = "landscape";
			}
		
			if($width < $height){
				$class = "portrait";
			}*/

			$class = "landscape";
			for($i = 0; $i < count($img_res); $i++):
				$img_name = (isset($img_res[$i]['imgNome']) ? $img_res[$i]['imgNome'] : "none");
				$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;
				if($i == 0){
					if($img_name != "none" && is_file($chk_img)){
						echo '<img class="'.$class.' img-active" id="'.$i.'" src="'.HOME_URI.'/views/_uploads/'.$img_name.'" width="auto" height="auto"/>';
					}else{
						echo '<img class="'.$class.'" id="'.$i.'" src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
					}
				}else{
					if($img_name != "none" && is_file($chk_img)){
						echo '<img class="'.$class.'" id="'.$i.'" src="'.HOME_URI.'/views/_uploads/'.$img_name.'" width="auto" height="auto"/>';
					}else{
						echo '<img class="'.$class.'" id="'.$i.'" src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
					}
				}
			endfor;
		echo '</div>';
	}

	/**
	 *
	 * setProductID - função para atribuir
	 * o ID do artigo seleccionado
	 *
	 */
	public function setProductID($value){
		$this->productID = $value;
	}

	/**
	 *
	 * getProductID - função para devolver
	 * o ID do artigo seleccionado
	 *
	 */
	public function getProductID(){
		return $this->productID;
	}

	/**
	 *
	 * addItems - função que adiciona
	 * items ao Carrinho
	 *
	 */		
	public function addItems(){
		// Configura os dados do formulário
		$this->form_data = array();
		
		// Faz o loop dos dados do post
		foreach ( $_POST as $key => $value ){
			// Configura os dados do post para a propriedade $form_data
			$this->form_data[ $key ] = $value;
		}
		
		if(!$this->login->chkUserLogin()){  
			$this->form_data['Buyer_User_userID'] = session_id(); 
		}else{
			$this->form_data['Buyer_User_userID'] = $this->user_data[0]['userid'];
		}
		$chkProd = $this->chkUserProd($this->form_data['Buyer_User_userID'], $this->form_data['Produto_ProdutoID'] );
		if($chkProd <= 0){
			$where = array("Buyer_User_userID"=>$this->form_data['Buyer_User_userID'], "deleted"=>"N");
			$result = $this->db->selectWConditions("carrinhocompra", "CarrinhoCompraID", true, $where, "LIKE", "AND",  "CarrinhoCompraID DESC");



			if(count($result) > 0){
				$cart_id = $result[0]["CarrinhoCompraID"];

				// Verifica se os campos obrigatórios estão preenchidos
				$chk_fields = $this->chk_mandatory_fields($this->form_data);
				if(sizeof($chk_fields) > 0){
					$aux = implode("\\n  ",$chk_fields);
					$x = array('Ocorreu um erro','Ocorreu um erro ao adicionar o produto!');
					echo json_encode($x);
					return;
				}

				$this->form_data['CarrinhoCompras_CarrinhoCompraID'] = $result[0]['CarrinhoCompraID'];
				$this->form_data['dataAdicionado'] = $this->methods->getDate();
				unset($this->form_data['Buyer_User_userID']);
				unset($result);
				$result = $this->db->simpleInsert("produtoscarrinho",$this->form_data);
			}else{
				$buyer_id = $this->form_data['Buyer_User_userID'];
				$data = array("Buyer_User_userID"=>$buyer_id, "dataAdicionado"=>$this->methods->getDate());

				$result = $this->db->simpleInsert("carrinhocompra", $data);
				var_dump($result);
				if($result[0] == true){


					// Verifica se os campos obrigatórios estão preenchidos
					/*$chk_fields = $this->chk_mandatory_fields($this->form_data);
					if(sizeof($chk_fields) > 0){
						$aux = implode("\\n  ",$chk_fields);
						$x = array('Ocorreu um erro','Ocorreu um erro ao adicionar o produto!');
						echo json_encode($x);
						return;
					}*/

					$this->form_data['CarrinhoCompras_CarrinhoCompraID'] = $result[2];
					$this->form_data['dataAdicionado'] = $this->methods->getDate();
					unset($this->form_data['Buyer_User_userID']);
					unset($result);
					var_dump($this->form_data);
					$result = $this->db->simpleInsert("produtoscarrinho",$this->form_data);
					if($result){
						unset($result);
						$result = true;
					}else{
						unset($result);
						$result = false;
					}
				}else{
					$result = false;
				}
			}
		}else{ $result = false; }
		echo json_encode($result);
	}
	
	/**
	 *
	 * addFav - função que adiciona
	 * artigos aos favoritos
	 *
	 */
	public function addFav(){
		// Configura os dados do formulário
		$this->form_data = array();
		
		// Faz o loop dos dados do post
		foreach ( $_POST as $key => $value ){
			// Configura os dados do post para a propriedade $form_data
			$this->form_data[ $key ] = $value;
		}
		
		if(!$this->login->chkUserLogin()){  
			echo '<script> alertBox("Login necessário!","Para adicionar favoritos é necesssário efetuar login"); </script>';
			return;
		}else{
			$this->form_data['User_userID'] = $this->login->getUserID();;
		}

		// Verifica se os campos obrigatórios estão preenchidos
		$chk_fields = $this->methods->chk_mandatory_fields($this->form_data);
		
		if(sizeof($chk_fields) > 0){
			$aux = implode("\\n  ",$chk_fields);
			$x = array('Ocorreu um erro','Ocorreu um erro ao adicionar o artigo!');
			echo json_encode($x);
			return;
		}
		
		$this->form_data['dataAdicionado'] = $this->methods->getDate();
		$result = $this->db->simpleInsert("favoritos",$this->form_data);
		echo json_encode($result);
	}

	/**
	 *
	 * chkFav - função que verifiva
	 * se os favoritos já estão adicionados
	 *
	 */
	public function chkFav($favId){
		$userID = $this->login->getUserID();
		if(empty($userID)){
			$userID = "none";
		}
		   
		$data = array("User_userID"=>$userID, "Produto_ProdutoID"=>$favId);
		return $this->db->select_doublecheck("Favoritos", "*", true, $data, "LIKE", "AND");
	}

	/**
	 *
	 * addFollow - função que adiciona
	 * users que o utilizador pretende
	 * seguir
	 *
	 */
	public function addFollow(){
		// Configura os dados do formulário
		$this->form_data = array();
		
		// Faz o loop dos dados do post
		foreach ( $_POST as $key => $value ){
			// Configura os dados do post para a propriedade $form_data
			$this->form_data[ $key ] = $value;
		}
		
		if(!$this->login->chkUserLogin()){  
			echo '<script> alertBox("Login necessário!","Para seguir outros utilizadores é necesssário efetuar login"); </script>';
			return;
		}else{
			$this->form_data['Follower_userID'] = $this->login->getUserID();;
		}

		// Verifica se os campos obrigatórios estão preenchidos
		$chk_fields = $this->methods->chk_mandatory_fields($this->form_data);
		
		if(sizeof($chk_fields) > 0){
			$aux = implode("\\n  ",$chk_fields);
			$x = array('Ocorreu um erro','Ocorreu um erro ao adicionar o utilizador à sua lista!');
			echo json_encode($x);
			return;
		}
		
		$this->form_data['dataAdicionado'] = $this->methods->getDate();
		$result = $this->db->simpleInsert("seguidores",$this->form_data);
		echo json_encode($result);
	}
	
	/**
	 *
	 * chkFollow - função que verifiva
	 * se o user já é seguido pelo user
	 * logado
	 *
	 */
	public function chkFollow($followUser){
		$userID = $this->login->getUserID();
		$result = true;
		if(empty($userID)){
			$userID = "none";
		}
		   
		$data = array("Follower_userID"=>$userID, "Followed_userID"=>$followUser);
		if($followUser != $userID){
			$result = $this->db->select_doublecheck("seguidores", "*", true, $data, "=", "AND");
		}
		
		return $result;
	}

	public function updateView($id){
		if(!empty($id)){
			// incrementa as views
			$statusAddr = $this->db->prodViewUpdate($id);
		}
	}
	
	public function countFavs(){
		$data = array("Produto_ProdutoID"=>$this->params[0]);
		return $this->db->countRows("favoritos", "Produto_ProdutoID", true, $data, "=", "");
	}
	
	public function countViews(){
		$data = array("ProdutoID"=>$this->params[0]);
		$result = $this->db->selectWConditions("produto", "visitas", true, $data, "=", "", "visitas");
		return $result[0]["visitas"];
	}
	
	public function removeFollow(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		
		if($id == null){
			return;
		}		
		
		$data = array("Followed_userID"=>$id, "Follower_userID"=> $this->login->getUserID());
		echo json_encode($this->db->delete("seguidores",$data, true, "=", "AND" ));
	}

	public function getMsgForm(){
		if($this->login->chkUserLogin() && $this->user_data[0]['userid'] != $this->form_data[0]["User_userID"]){
		  echo '<div class="open-msg-container">
					<h5 class="contact-seller"><strong>Contactar User_userID</strong></h5>
					<div class="open-msg"></div>
				</div>
				<div class="mensage-container general-form" hidden="true">
					<form action="/ProjetoFinal/artigo/mensagem/" method="post" id="msg-form">
					  <input type="text" hidden="true" id="seller" name="seller" value="'.$this->form_data[0]["User_userID"].'">
					  <input type="text" hidden="true" id="pid" name="pid" value="'.$this->getProductID().'">

					  <label for="name">Nome<span class="mandatory">*</span></label>
					  <input type="text" required autofocus id="name" placeholder="Introduza o seu nome" name="Nome">

					  <label for="mail">Email<span class="mandatory">*</span></label>
					  <input type="email" required id="mail" placeholder="email@exemplo.com" name="Email">

					  <label for="phone">Contacto<span class="optional"> (opcional)<span></label>
					  <input type="text" id="phone" name="Contacto" placeholder="EX: +351 912 345 678">

					  <label for="bio">Mensagem</label>
					  <textarea id="msg" placeholder="Descreva o seu trabalho de forma geral" name="msg"></textarea>
					  <button type="submit" name="msg-form" form="msg-form" class="general-button btn-msg-adjust ">Enviar Mensagem</button>				
					</form>
				</div>';
		}
	}
	
	public function mensagem(){
		$result= array();
		// Faz o loop dos dados do post
		foreach ( $_POST as $key => $value ) {
			// Configura os dados do post para a propriedade $form_data
			$this->mensagem[ $key ] = $value;
		}

		$content = $this->mensagem["msg"];
		$pid     = $this->mensagem["pid"];
		unset($this->mensagem["msg"]);
		unset($this->mensagem["pid"]);
		unset($this->mensagem['msg-form']);
		
		
		$this->mensagem["User1_userID"] = $this->user_data[0]['userid'];
		$this->mensagem["dataAdicionada"] = $this->methods->getDate();
		
		$where = array("User1_userID"=>$this->user_data[0]["userid"] , "User2_userID"=>$this->mensagem["seller"]);
		$count = $this->db->countRows("mensagem", "MensagemID", true, $where, "=", "AND");
		
		if($count <= 0){
			$where = array("User2_userID"=>$this->user_data[0]["userid"] , "User1_userID"=>$this->mensagem["seller"]);
			$count = $this->db->countRows("mensagem", "MensagemID", true, $where, "=", "AND");
		}
		
		if($count > 0){
			$msg_id = $this->db->selectWConditions("mensagem", "MensagemID", true, $where, "=", "AND", "MensagemID"); 
			$this->mensagem["SenderID"] = $this->user_data[0]['userid'];
			
			$ins = array("Mensagem_MensagemID"=>$msg_id[0]["MensagemID"],
						 "SenderID"=>$this->user_data[0]['userid'],
						 "Mensagem"=>$content,
						 "dataAdicionada"=>$this->methods->getDate());	
			
			unset($this->mensagem["User1_userID"]);
			unset($this->mensagem["User2_userID"]);
			unset($this->mensagem["Nome"]);
			unset($this->mensagem["Email"]);
			unset($this->mensagem["Contacto"]);
			unset($this->mensagem["seller"]);
			
			$result = $this->db->simpleInsert("mensagens", $ins);

			//$this->db->markMsgUnreaded($msg_id[0]["MensagemID"],$result[1]);
		}else{
			$nome = isset($this->mensagem["Nome"]) ? $this->mensagem["Nome"] : null;
			$mail = isset($this->mensagem["Nome"]) ? $this->mensagem["Nome"] : null;
			$contacto = isset($this->mensagem["Nome"]) ? $this->mensagem["Nome"] : null;
			$date = $this->methods->getDate();
			
			$data = array("User1_userid"=>$this->mensagem["seller"],
						  "User2_userID"=>$this->user_data[0]['userid'],
						  "Nome"=>$nome,
						  "Email"=>$mail,
						  "Contacto"=>$contacto,
						  "dataAdicionada"=>$date);
			
			$result = $this->db->simpleInsert("mensagem", $data);
			
			$this->mensagem["SenderID"] = $this->user_data[0]['userid'];
			
			unset($this->mensagem["User1_userID"]);
			unset($this->mensagem["User2_userID"]);
			unset($this->mensagem["Nome"]);
			unset($this->mensagem["Email"]);
			unset($this->mensagem["Contacto"]);
			
			
			$this->mensagem["Mensagem"] = $content;
			$this->mensagem["Mensagem_MensagemID"] = $result[1];
			
			$result = $this->db->simpleInsert("mensagens", $this->mensagem);

			$this->db->markMsgUnreaded($msg_id[0]["MensagemID"],$result[1]);
		}
		echo json_encode($result);
	}
	
	private function chkUserProd($userID, $prodID){
		$data = array("ProdutoID"=>$prodID,"User_userID"=>$userID);	
		return $this->db->countRows("produto", "ProdutoID,User_userID", true, $data, "=", "AND");
	}
}
?>