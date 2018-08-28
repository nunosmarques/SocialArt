<?php
/**
 * Classe para registo de utilizadores
 *
 * @package SocialArt
 * @version 1.0
 *
 */

class UserConfigModel extends Methods{
	
	/**
	 * $db
	 *
	 * Guarda a intancia da 
	 * classe DB
	 *
	 */
	public $db;

	/**
	 * $login
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
	 * fullname
	 *
	 * Variavel que armazena
	 * o nome da morada de faturação
	 * default
	 *
	 * @access public
	 */
	public $fullname;
	
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
		if(!$this->login->chkUserLogin()){
			header('Location:/ProjetoFinal/');
		}
		$this->controller = $controller;
		$this->params = $this->controller->parametros;
		if($this->login->chkUserLogin()){
			$this->user_data = $this->login->loadUser();
		}else{ header('Location:/ProjetoFinal/'); }
		
		$user = array( "User_userid" => $this->login->getUserID() );
		$results = $this->db->selectWConditions("address", "*", true, $user, "LIKE", "AND", "Principal DESC" );

		foreach($results as $value):
			if($value['Principal'] == 'Y'){ 
				$this->setFullname($value['fullname']);
			}
		endforeach;
	}

	public function getUserID(){
		if(!isset($this->user_data[0]['userid'])){ return; }

		return $this->user_data[0]['userid'];
	}
	
	public function getUsername(){
		if(!isset($this->user_data[0]['username'])){ return "N/A"; }

		return $this->user_data[0]['username'];
	}
	
	public function getFirstName(){
		if(!isset($this->user_data[0]['firstname'])){ return "N/A"; }

		return $this->user_data[0]['firstname'];
	}
	
	public function getLastName(){
		if(!isset($this->user_data[0]['lastname'])){ return "N/A"; }

		return $this->user_data[0]['lastname'];
	}
	
	public function getEmail(){
		if(!isset($this->user_data[0]['email'])){ return "N/A"; }

		return $this->user_data[0]['email'];
	}
	
	public function getPhone(){
		if(!isset($this->user_data[0]['phone'])){ return "N/A"; }

		return $this->user_data[0]['phone'];
	}
	
	public function getDescription(){
		if(!isset($this->user_data[0]['description'])){ return "N/A"; }
		return $this->user_data[0]['description'];
	}
	
	public function getNIF(){
		if(!isset($this->user_data[0]['nif'])){ return "N/A"; }

		return $this->user_data[0]['nif'];
	}
	
	public function setFullname($value){
		$this->fullname = $value;
	}
	
	public function getFullname(){
		return $this->fullname;
	}

	public function chPwd(){
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && isset($_POST['chpwd'])){
			$status[0] = false;
			$pwd = md5($_POST['atual']."tralaicosloki");
			$n_pwd = $_POST['n_pwd'];
			$cn_pwd = $_POST['nc_pwd'];
			
			$data = array("userid"=>$this->login->getUserID(), "password"=>$pwd);
			//$this->db->select("user", $data)
			$rows = $this->db->countRows("user", "*", true, $data, "=", "AND");
				//($table, $field, $where, $array_filter, $where_sign, $where_condition)
			if($rows == 1){
				if($this->methods->passMatch($n_pwd,$cn_pwd)){
					$new_pwd = md5($n_pwd."tralaicosloki");
					$cond = array("password"=>$new_pwd);
					$data = array("userid"=>$this->login->getUserID());
					$result = $this->db->updateWConds("user", $data, "=", "", $cond);
					
					if($result){
						$status[0] = true;
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
	
	public function getUserProds(){
		if(!$this->login->chkUserLogin()){
			return;
		}
		$seller = array( "User_userID" => $this->user_data[0]['userid'] );
		$field = "ProdutoID,NomeProduto,Autor,User_userID,Preco,Quantidade,produto.deleted,username,firstname,lastname";

		$join = "INNER JOIN user ON produto.User_userID = user.userid";

		$results = $this->db->freeSelect("produto", $field, true, $seller, "LIKE", "AND", $join, "produto.deleted = 'N' OR produto.deleted = 'Y'", "ORDER BY ProdutoID DESC, dataAdicionado DESC");
		

		foreach($results as $value):
			echo '<div class="user-prods-row">';
				$aux = array("ProdutoID"=>$value["ProdutoID"]);
		
				$img_results = $this->db->selectWConditions("imagem", "imgID, imgNome", true, $aux, "LIKE", "AND", "imgID" );
				
				$img_id = (isset($img_results[0]['imgID']) ? $img_results[0]['imgID'] : "none");
				$img_name = (isset($img_results[0]['imgNome']) ? $img_results[0]['imgNome'] : "none");
		
				$img = '<img src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
				$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;
				
				if($img_name != "none" && is_file($chk_img)){
					$img = '<img src="'.HOME_URI.'/views/_uploads/'.$img_name.'" value="'.$img_id.'" alt="'.$value["NomeProduto"].'" width="auto" height="auto">';
				}
		
				echo '<div class="user-prods-img">'.$img.'</div>';
				echo '<div class="user-prods-name"><a href="'.HOME_URI.'/editar-artigo/index/'.$value["ProdutoID"].'"><h5 align="center">'.$value['NomeProduto'].'</h5></a></div>';
				$author = (strlen($value["Autor"]) <= 0 ? $value["firstname"]." ".$value["lastname"] : $value["Autor"]);
				echo '<div class="user-prods-author"><h5 align="center">'.$author.'</h5></div>';
				echo '<div class="user-prods-price"><h5 align="center">'.$value["Preco"].' €</h5></div>';
				echo '<div class="user-prods-stock"><h5 align="center">'.$value["Quantidade"].'</h5></div>';
				echo '<div class="options">
						<a href="'.HOME_URI.'/editar-artigo/index/'.$value["ProdutoID"].'"><div class="btn-ch" title="Modificar artigo '.$value["NomeProduto"].'" value="'.$value["ProdutoID"].'"></div></a>
						<a href="#"><div class="btn-del" title="Eliminar artigo '.$value["NomeProduto"].'" value="'.$value["ProdutoID"].'"></div></a>
					  </div>';
				echo "<hr>";
			echo '</div>';
		endforeach;
	}

	public function getUserSales(){
		if(!$this->login->chkUserLogin()){
			return;
		}
		$where = array("SellerID"=>$this->user_data[0]['userid']);

		$join  = "INNER JOIN produto ON produtoscarrinho.Produto_ProdutoID = produto.ProdutoID
				  INNER JOIN user ON produto.User_userID = user.userID";
		$field = "SUM(produtoscarrinho.Quantidade) as 'QtdTotal',SUM(produtoscarrinho.Preco) as 'Price',produtoscarrinho.dataAdicionado,produtoscarrinho.deleted,NomeProduto,firstname,lastname,Autor,ProdutoID,userid,produto.User_userID";
			
		$prods = $this->db->freeSelect("produtoscarrinho", $field, true, $where, "=", "", $join, "produtoscarrinho.deleted = 'Y'", "GROUP BY produtoscarrinho.Produto_ProdutoID ORDER BY produtoscarrinho.dataAdicionado DESC");
		
		if(count($prods) > 0){
			foreach($prods as $value):
				echo '<div class="user-prods-row">';
					$aux = array("ProdutoID"=>$value["ProdutoID"]);

					$img_results = $this->db->selectWConditions("imagem", "imgID, imgNome", true, $aux, "LIKE", "AND", "imgID" );

					$img_id = (isset($img_results[0]['imgID']) ? $img_results[0]['imgID'] : "none");
					$img_name = (isset($img_results[0]['imgNome']) ? $img_results[0]['imgNome'] : "none");

					$img = '<img src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
					$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;

					if($img_name != "none" && is_file($chk_img)){
						$img = '<img src="'.HOME_URI.'/views/_uploads/'.$img_name.'" value="'.$img_id.'" alt="'.$value["NomeProduto"].'" width="auto" height="auto">';
					}

					echo '<div class="user-pursh-img">'.$img.'</div>';
					echo '<div class="user-pursh-name"><a href="'.HOME_URI.'/artigo/index/'.$value["ProdutoID"].'/'.$value["NomeProduto"].'"><h5 align="center">'.$value['NomeProduto'].'</h5></a></div>';
					echo '<div class="user-pursh-price"><h5 align="center">'.$value["Price"].' €</h5></div>';
					echo '<div class="user-pursh-stock"><h5 align="center">'.$value["QtdTotal"].'</h5></div>';
					echo "<hr>";
				echo '</div>';
			endforeach;
		}else{
			echo '<h4 class="h4center">Ainda não vendeu qualquer artigo.</h4>';
		}

	}
	
	public function getUserPurchases(){
		if(!$this->login->chkUserLogin()){
			return;
		}
		$data = array("Buyer_User_userID"=>$this->user_data[0]['userid']);
		$cart_id = $this->db->selectWConditionsDelY("carrinhocompra", "CarrinhoCompraID", true, $data, "=", "", "CarrinhoCompraID DESC");
		if(count($cart_id) > 0){
			
			$where = array("CarrinhoCompras_CarrinhoCompraID"=>$cart_id[0]['CarrinhoCompraID']);

			$join  = "INNER JOIN produto ON produtoscarrinho.Produto_ProdutoID = produto.ProdutoID
					  INNER JOIN user ON produto.User_userID = user.userID";
			$field = "SUM(produtoscarrinho.Quantidade) as 'QtdTotal',SUM(produtoscarrinho.Preco) as 'Price',produtoscarrinho.dataAdicionado,produtoscarrinho.deleted,NomeProduto,firstname,lastname,Autor,ProdutoID,userid,produto.User_userID";

			$prods = $this->db->freeSelect("produtoscarrinho", $field, true, $where, "=", "", $join, "produtoscarrinho.deleted = 'Y'", "GROUP BY produtoscarrinho.Produto_ProdutoID ORDER BY produtoscarrinho.dataAdicionado DESC");

			if(count($prods) > 0){
				foreach($prods as $value):
					echo '<div class="user-prods-row">';
						$aux = array("ProdutoID"=>$value["ProdutoID"]);

						$img_results = $this->db->selectWConditions("imagem", "imgID, imgNome", true, $aux, "LIKE", "AND", "imgID" );

						$img_id = (isset($img_results[0]['imgID']) ? $img_results[0]['imgID'] : "none");
						$img_name = (isset($img_results[0]['imgNome']) ? $img_results[0]['imgNome'] : "none");

						$img = '<img src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
						$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;

						if($img_name != "none" && is_file($chk_img)){
							$img = '<img src="'.HOME_URI.'/views/_uploads/'.$img_name.'" value="'.$img_id.'" alt="'.$value["NomeProduto"].'" width="auto" height="auto">';
						}

						echo '<div class="user-pursh-img">'.$img.'</div>';
						echo '<div class="user-pursh-name"><a href="'.HOME_URI.'/artigo/index/'.$value["ProdutoID"].'/'.$value["NomeProduto"].'"><h5 align="center">'.$value['NomeProduto'].'</h5></a></div>';
						echo '<div class="user-pursh-price"><h5 align="center">'.$value["Price"].' €</h5></div>';
						echo '<div class="user-pursh-stock"><h5 align="center">'.$value["QtdTotal"].'</h5></div>';
						echo "<hr>";
					echo '</div>';
				endforeach;
			}else{
				echo '<h4 class="h4center">Ainda não finalizou qualquer compra.</h4>';
			}
		}else{
			echo '<h4 class="h4center">Ainda não finalizou qualquer compra.</h4>';
		}
	}

	public function delProd(){
		$errors = array();
		$prod_id = (isset($_POST['ProdutoID']) ? $_POST['ProdutoID'] : null);
		if($prod_id == null){
			return;
		}
		
		$result = array();

		$data = array("ProdutoID"=>$prod_id);
		$img_results = $this->db->selectWConditions("imagem", "imgID", true, $data, "LIKE", null, "ProdutoID" );
		
		foreach($img_results as $value):
			unset($data);
			$data = array("imgID"=>$value['imgID']);
			$result = $this->db->delete("imagem", $data, true, "=", "" );
			//($table, $filter, $where_sign, $where_condition)
			if(!$result){
				array_push($errors, "error");
			}
		endforeach;
		
		if(count($errors) <= 0){
			unset($data);

			$data = array("ProdutoID"=>$prod_id);
			$result = $this->db->delete("produto",$data, true, "=", "" );
		}
		
		echo json_encode($result);
	}
	
	public function getUserAdress(){
		if(!$this->login->chkUserLogin()){
			return;
		}

		$user = array( "user_userid" => $this->user_data[0]['userid']);
		$results = $this->db->selectWConditions("address", "*", true, $user, "LIKE", "AND", "Principal ASC" );

		foreach($results as $value):	
			echo '<div class="user-adress-row">';
				echo '<div class="user-adress-name">
						<h5 align="center">'.$value['fullname'].'</h5>
					  </div>';
				echo '<div class="user-adress">
						<h5 align="center">'.$value['street'].' '.$value['zip'].' '.$value["city"].' '.$value["country"].'</h5>
					  </div>';
				echo '<div class="adress-options">';
				if($value['Principal'] == 'N'){ 
					echo '<a href="#"><div class="btn-up-add" title="Promover para morada principal" value="'.$value["addressid"].'"></div></a>';
				}
				  echo '<a href="'.HOME_URI.'/gerir-morada/editarMorada/'.$value["addressid"].'"><div class="btn-ch-add" title="Modificar esta morada" value="'.$value["addressid"].'"></div></a>
						<a href="#"><div class="btn-del-add" title="Eliminar esta morada" value="'.$value["addressid"].'"></div></a>
					  </div>';
				echo "<hr>";
			echo '</div>';
		endforeach;
	}
	
	public function getUserAdressList(){
		if(!$this->login->chkUserLogin()){
			return;
		}

		$user = array( "User_userid" => $this->login->getUserID() );
		$results = $this->db->selectWConditions("address", "*", true, $user, "=", "AND", "Principal DESC" );

		foreach($results as $value):
			if($value['Principal'] == 'Y'){
				echo '<option selected value="'.$value['addressid'].'">'.$value['street'].' '.$value['zip'].' '.$value["city"].' '.$value["country"].'</h5>
					  </div>';
			}else{
				echo '<option value="'.$value['addressid'].'">'.$value['street'].' '.$value['zip'].' '.$value["city"].' '.$value["country"].'</h5>
					  </div>';
			}
		endforeach;
	}
	
	public function delAdd(){
		$add_id = (isset($_POST['idAdd']) ? $_POST['idAdd'] : null);
		$result[0] = false;
		
		if($add_id == null){
			return;
		}
		$data = array("addressid"=>$add_id);
		$results = $this->db->selectWConditions("addressid", "Principal", true, $data, "=", null, "addressid" );

		if(isset($results[0]['Principal']) && $results[0]['Principal'] == "N"){
			$data = array("addressid"=>$add_id);
			$result = $this->db->delete("addressid",$data, true, "=", "" );
		}else{ $result[0] = "principal"; }
		
		echo json_encode($result);
	}

	public function chAdd(){
		$add_id = (isset($_POST['idAdd']) ? $_POST['idAdd'] : null);
		
		if($add_id == null){
			return;
		}
		
		$data = array("user_userid"=>$this->login->getUserID());
		
		$results = $this->db->selectWConditions("address", "addressid", true, $data, "=", null, "addressid" );

		foreach($results as $value):
			unset($data);
			$data = array("addressid"=>$value['addressid']);
			$cond = array("Principal"=>"N");
			$result = $this->db->updateWConds("address", $data, "=", "", $cond);
			if(!$result){
				array_push($errors, "error");
			}
		endforeach;
		$cond = array("Principal"=>"Y");
		$data = array("addressid"=>$add_id);
		$result = $this->db->updateWConds("address", $data, "=", "", $cond);
		
		echo json_encode($result);
	}
	
	public function chInv(){
		$add = (isset($_POST['add']) ? $_POST['add'] : null);
		$name = (isset($_POST['name']) ? $_POST['name'] : null);
		$nif = (isset($_POST['nif']) ? $_POST['nif'] : null);
		$result[0] = false;
		$errors = array();
		if($name == null || $nif == null){
			$result[1] = "Existem campos obrigatórios que não foram preenchidos.";
		}
		
		$data = array("user_userid"=>$this->login->getUserID());
		
		$results = $this->db->selectWConditions("address", "addressid", true, $data, "=", null, "addressID" );

		foreach($results as $value):
			unset($data);
			$data = array("addressID"=>$value['addressid']);
			$cond = array("Principal"=>"N");
			$results = $this->db->updateWConds("address", $data, "=", "", $cond);
			if(!$results){
				array_push($errors, "error");
			}
		endforeach;
		
		if( count($errors) <= 0 ){
			$cond = array("Principal"=>"Y", "fullname"=>$name);
			$data = array("addressid"=>$add);
			$result[0] = $this->db->updateWConds("address", $data, "=", "", $cond);

			unset($data);
			unset($cond);
			
			$cond = array("nif"=>$nif);
			$data = array("userid"=>$this->login->getUserID());
			$result[0] = $this->db->updateWConds("user", $data, "=", "", $cond);
		}else{
			$result[0] = false;
		}
		
		echo json_encode($result);
	}
	
	public function chFullname(){
		$add = (isset($_POST['add']) ? $_POST['add'] : null);
		
		if($add == null){
			$result;
		}
		
		$data = array("addressid"=>$add);
		$result = $this->db->selectWConditions("addressid", "*", true, $data, "=", null, "addressid" );
		
		echo $result[0]['fullname'];
	}
	
	public function chUserdata(){
		$fname = (isset($_POST['fname']) ? $_POST['fname'] : null);
		$lname = (isset($_POST['lname']) ? $_POST['lname'] : null);
		$mail = (isset($_POST['mail']) ? $_POST['mail'] : null);
		$cmail = (isset($_POST['cmail']) ? $_POST['cmail'] : null);
		$phone = (isset($_POST['phone']) ? $_POST['phone'] : null);
		$descr = (isset($_POST['descr']) ? $_POST['descr'] : null);
		$status = false;
		
		$data = array("firstname"=>$fname , "lastname"=>$lname , "phone"=>$phone , "description"=>$descr );
		
		if($this->methods->passMatch($mail, $cmail)){
			$data['email'] = $mail;
		}else{
			$result = false;
		}
		
		$cond = array("userid"=>$this->getUserID());
		$result = $this->db->updateWConds("user", $cond, "=", "", $data);
		
		if(!$result){
			$result = false;
		}
		echo json_encode($result);
	}
	
	public function getAlerts(){
		$where = array("Follower_userID"=>$this->user_data[0]['userid']);
		
		$join  = "INNER JOIN produto ON notificacoes.Produto_ProdutoID = produto.ProdutoID
				  INNER JOIN user ON notificacoes.Followed_userID = user.userID";
		$field = "New,Followed_userID,Follower_userID,idNotificacoes,notificacoes.dataCriacao,NomeProduto,firstname,lastname,Autor,ProdutoID,userid,produto.User_userID";
			
		$results = $this->db->freeSelect("notificacoes", $field, true, $where, "=", "", $join, "notificacoes.deleted = 'N'", "ORDER BY notificacoes.New DESC, notificacoes.dataCriacao DESC");		
				
		foreach($results as $value):
			$bg_color = ( $value['New'] == "Y" ? "alert-shadow" : "");
			echo '<div class="alerts-main-loop-row '.$bg_color.'">';
				echo '<div class="alerts-seller"><h5 align="center">'.$value['firstname'].' '.$value['lastname'].'</h5></div>';
				echo '<div class="alerts-prod"><a href="'.HOME_URI.'/artigo/index/'.$value["ProdutoID"].'"><h5 align="center">'.$value['NomeProduto'].'</h5></a></div>';
				echo '<div class="alerts-date"><h5 align="center">'.date('d-m-Y', strtotime($value["dataCriacao"])).'</h5></div>';
				echo '<div class="alerts-options">';
				if($value['New'] == "Y"){
					echo '<a href="#"><div class="btn-readed" title="Marcar como lido" value="'.$value["idNotificacoes"].'"></div></a>';
				}
				echo	'<a href="#"><div class="btn-del-alert" title="Eliminar notificação" value="'.$value["idNotificacoes"].'"></div></a>
					  </div>';
			echo '</div>';		
			echo '<hr class="hr-style">';
		endforeach;
	}
	
	public function markAsReaded(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		
		if($id == null){
			return;
		}
		
		$cond = array("New"=>"N");
		$data = array("idNotificacoes"=>$id);
		echo json_encode($this->db->updateWConds("notificacoes", $data, "=", "", $cond));
	}
	
	public function deleteAlert(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		
		if($id == null){
			return;
		}		
		
		$data = array("idNotificacoes"=>$id);
		echo json_encode($this->db->delete("notificacoes",$data, true, "=", "" ));
	}	
	
	public function getMessage(){
		if(!$this->login->chkUserLogin()){
			return;
		}
		
		$id = $this->user_data[0]['userid'];

		$results = $this->db->selectMensage( $id, "N" );

		if($results[0] != false){
			foreach($results[1] as $value):

				$bg_color = ( $value['New'] == "Y" ? "alert-shadow" : "");
				echo '<div class="alerts-main-loop-row '.$bg_color.'">';
					echo '<div class="sender-name"><a href="'.HOME_URI.'/mensagem/index/'.$value["MensagemID"].'"><h5 align="center">'.$value["Nome"].'</h5></a></div>';//
					echo '<div class="alerts-date"><h5 align="center">'.date('d-m-Y', strtotime($value["dataAdicionada"])).'</h5></div>';
					echo '<div class="msg-options">';
					if($value['New'] == "Y"){
						echo '<a href="#"><div class="btn-msg-readed" title="Marcar como lido" value="'.$value["MensagemID"].'"></div></a>';
					}
					if($value['Arquivada'] == "N"){
						echo '<a href="#"><div class="btn-msg-filed" title="Arquivar mensagem" value="'.$value["MensagemID"].'"></div></a>';
					}
					echo	'<a href="#"><div class="btn-del-msg" title="Eliminar mensagens do utilizador" value="'.$value["MensagemID"].'"></div></a>
						  </div>';
				echo '</div>';		
				echo '<hr class="hr-style">';
			endforeach;
		}else{
			echo '<h4 class="h4center">Não existem mensagens!</h4>';
		}
	}
	
	public function markMSGAsReaded(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		
		if($id == null){
			return;
		}
		
		$cond = array("New"=>"N");
		$data = array("Mensagem_MensagemID"=>$id);
		echo json_encode($this->db->updateWConds("mensagens", $data, "=", "", $cond));
	}
	
	public function deleteMSG(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		
		if($id == null){
			return;
		}		
		$cond = array("Arquivada"=>"N","deleted"=>"Y");
		$data = array("MensagemID"=>$id);
		$this->db->updateWConds("mensagem", $data, "=", "", $cond);
		
		unset($data);
		unset($cond);
		
		$data = array("Mensagem_MensagemID"=>$id);
		$cond = array("New"=>"N");
		echo json_encode($this->db->updateWConds("mensagens", $data, "=", "", $cond));
		
	}
	
	public function markMSGAsFiled(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		
		if($id == null){
			return;
		}
		
		$cond = array("Arquivada"=>"Y");
		$data = array("MensagemID"=>$id);
		echo json_encode($this->db->updateWConds("mensagem", $data, "=", "", $cond));
	}
	
	public function getMessageFiled(){
		if(!$this->login->chkUserLogin()){
			return;
		}

		$id = $this->user_data[0]['userid'];

		$results = $this->db->selectMensageFilled( $id, "Y" );
		if($results[0] != false){
			foreach($results[1] as $value):
				echo '<div class="alerts-main-loop-row">';
					echo '<div class="sender-name"><a href="'.HOME_URI.'/mensagem/index/'.$value['MensagemID'].'"><h5 align="center">'.$value["Nome"].'</h5></a></div>';//
					echo '<div class="alerts-date"><h5 align="center">'.date('d-m-Y', strtotime($value["dataAdicionada"])).'</h5></div>';
					echo '<div class="msg-options">';
					if($value['Arquivada'] == "Y"){
						echo '<a href="#"><div class="btn-msg-notFiled" title="Retirar mensagem da lista de arquivadas" value="'.$value["MensagemID"].'"></div></a>';
					}
					echo	'<a href="#"><div class="btn-del-msg" title="Eliminar mensagens do utilizador" value="'.$value["MensagemID"].'"></div></a>
						  </div>';
				echo '</div>';		
				echo '<hr class="hr-style">';
			endforeach;
		}else{
			echo '<h4 class="h4center">Não existem mensagens arquivadas!</h4>';
		}
	}
	
	public function removeMSGAsFiled(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		
		if($id == null){
			return;
		}
		
		$cond = array("Arquivada"=>"N");
		$data = array("MensagemID"=>$id);
		echo json_encode($this->db->updateWConds("mensagem", $data, "=", "", $cond));
	}
	
}