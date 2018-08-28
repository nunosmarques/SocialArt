<?php
class CarrinhoModel extends Methods {
	
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
	
	private $cartBuyer;
	
	private $cartTotal;
	
	public $cartID;
	
	private $totalPortes;
	
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
	 * add_data
	 *
	 * Variavel que vai receber
	 * os dados da morada do utilizador
	 *
	 * @access public
	 */	
	public $add_data;
		
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
	public function __construct($db, $controller, $login) {
		// Configura o DB
		$this->db = $db;
		
		// Configura o Login
		$this->login = $login;
		
		// Configura o controlador
		$this->controller = $controller;

		// Configura os parâmetros
		$this->params = $this->controller->parametros;
		
		//Intancia da classe Methods
		$this->methods = new Methods();
		
		if($this->login->chkUserLogin()){
			$this->user_data = $this->login->loadUser();
			$this->add_data = $this->getUserAdd();
		}
		$myid = isset($this->user_data[0]['userid']) ? $this->user_data[0]['userid'] : $this->login->getUserID();
		if(strlen($myid) <= 0){return;}
		$where = array("Buyer_User_userID"=>$myid);
		$cartID = $this->db->freeSelect("carrinhocompra","CarrinhoCompraID", true, $where, "=", NULL, "", "deleted = 'N'", "GROUP BY CarrinhoCompraID");
		if($cartID != false){
			$this->setCartID($cartID[0]["CarrinhoCompraID"]);
		}
	}

	public function getCart($buyer){
		if(!isset($buyer)){ return; }
		$weight = 0;
		$this->setCartTotal(0);
		$this->setTotalPortes(0);
		
		$where = array("Buyer_User_userID"=>$buyer);
		$field = "CarrinhoCompraID,Buyer_User_userID,SellerID,Produto_ProdutoID,
				  SUM(produtoscarrinho.Quantidade) as 'QtdTotal',SUM(produtoscarrinho.Preco) as 'TotalPrice',produtoscarrinho.dataAdicionado,
				  produtoscarrinho.deleted,ProdutoID,NomeProduto,produto.Autor,produto.deleted,
				  username,ROUND(SUM(produto.Peso),2) as 'PesoTotal'";
			
		$join = "INNER JOIN produtoscarrinho ON carrinhocompra.CarrinhoCompraID = produtoscarrinho.CarrinhoCompras_CarrinhoCompraID
			     INNER JOIN produto ON produtoscarrinho.Produto_ProdutoID = produto.ProdutoID
				 INNER JOIN user ON produto.User_userID = user.userid";

		$products = $this->db->freeSelect("carrinhocompra", $field, true, $where, "=", NULL, $join, "carrinhocompra.deleted = 'N' AND produtoscarrinho.deleted = 'N' AND produto.deleted = 'N'", "GROUP BY produtoscarrinho.Produto_ProdutoID ORDER BY SellerID ASC");
		
		$aux_pid = null;
		$aux2    = null;
		$v_array = array();
		$i = count($products);
		
		foreach($products as $value):
			$idprod   = $value["NomeProduto"];
			$sellerID = $value["username"];
		
			if(strlen($idprod) > 28){
				$idprod = substr($idprod, 0, 28)."...";
			}

			if(strlen($sellerID) > 12){
				$sellerID = substr($sellerID, 0, 12)."...";
			}
		
			$aux = array("ProdutoID"=>$value["ProdutoID"]);

			$img_results = $this->db->selectWConditions("imagem", "imgID, imgNome", true, $aux, "LIKE", "AND", "imgID" );

			$img_id = (isset($img_results[0]['imgID']) ? $img_results[0]['imgID'] : "none");
			$img_name = (isset($img_results[0]['imgNome']) ? $img_results[0]['imgNome'] : "none");

			$img = '<img src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
			$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;

			if($img_name != "none" && is_file($chk_img)){
				$img = '<img src="'.HOME_URI.'/views/_uploads/'.$img_name.'" value="'.$img_id.'" alt="'.$value["NomeProduto"].'" width="auto" height="auto">';
			}

			$prod_name = str_replace(' ', '-', strtolower($value["NomeProduto"]));
		
			echo '<div class="cart-title">';
			echo	'<div class="final-cart-del">';
			echo		'<a href="#">';
			echo			'<div class="btn-del-cart" title="Eliminar do carrinho" value="'.$value['Produto_ProdutoID'].'"></div>';
			echo		'</a>';
			echo	'</div>';
			echo	'<div class="final-cart-img">'.$img.'</div>';
			echo	'<div class="final-cart-prod">
						<a href="'.HOME_URI.'/artigo/index/'.$value["ProdutoID"].'/'.$prod_name.'" title="'.$value["NomeProduto"].'" value="'.$value["ProdutoID"].'" id="prod-id"><h5 align="center">'.$idprod.'</h5></a>';
			echo	'</div>';
			echo	'<div class="final-cart-auth"><h5 align="center">'.ucfirst($sellerID).'</h5></div>';
			echo	'<div class="final-cart-preco"><h5 align="center">'.$value['TotalPrice'].' €</h5></div>';
			echo	'<div class="final-cart-qtd"><h5 align="center">'.$value['QtdTotal'].'</h5></div>';
			echo '</div>';
			echo "<hr>";

		
		
		
		
			if( $value['SellerID'] == $aux_pid || empty($aux_pid)){
				$weight = $weight + $value['PesoTotal'];
			}else{
				if($aux2 == $aux_pid){
					$portes = $this->db->getPortes($weight);
					$porte = $portes[1][0]["Valor"];
					$this->setTotalPortes($this->getTotalPortes()+$porte);
					
					if($value['SellerID'] != $aux2){
						$weight = 0;
						$weight = $value['PesoTotal'];

						$portes = $this->db->getPortes($weight);
						$porte = $portes[1][0]["Valor"];
						
						$this->setTotalPortes($this->getTotalPortes()+$porte);
					}
					
				}else{
					$weight = 0;
					$weight = $value['PesoTotal'];

					$portes = $this->db->getPortes($weight);
					$porte = $portes[1][0]["Valor"];
					$this->setTotalPortes($this->getTotalPortes()+$porte);
				}
			}
		
			$this->setCartTotal(($this->getCartTotal() + $value['TotalPrice']));
			$aux2 = $aux_pid;
			$aux_pid = $value['SellerID'];
		
		endforeach;
		echo "<hr>";
		echo '<div class="cart-values">';
		echo  '<table width="100%">
				  <tbody>
					<tr>
					  <td align="left">Total: </th>
					  <td align="right"><strong> '.$this->getCartTotal().' €</strong></th>
					</tr>
					<tr>
					  <td align="left">Portes: </td>
					  <td align="right"><strong> '.$this->getTotalPortes().' €</strong></td>
					</tr>
					<tr>
					  <td align="left"><strong>Total a pagar: </strong></td>
					  <td align="right" id="CartTotal"><strong> '.($this->getCartTotal()+$this->getTotalPortes()).' €</strong></td>
					</tr>
				  </tbody>
				</table>';
		echo '</div>';
	}

	public function getPurchase(){
				// Configura os dados do formulário
		$this->form_data = array();
		$aux = array();
		$results[0] = false;
		// Verifica se algo foi postado
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && !empty( $_POST ) && isset($_POST['send-add'])) {
			$chk_fields = array();
			
			// Faz o loop dos dados do post
			foreach ( $_POST as $key => $value ) {
				// Configura os dados do post para a propriedade $form_data
				if(!empty($value)){
				$this->form_data[ $key ] = $value;
				}
			}
			
			// Verifica se os campos obrigatórios estão preenchidos
			if(isset($this->form_data['fancy-checkbox-success'])){
				
				$coments    = isset($this->form_data["coments"]) ? $this->form_data["coments"] : "";
				$enterprise = isset($this->form_data["empresa"]) ? $this->form_data["empresa"] : "";
				$id         = $this->getCartID() != null ? $this->getCartID() : $this->form_data["cartid"];
				
				$aux = array("CarrinhoCompras_CarrinhoCompraID"=>$id,
							 "fullname"=>$this->form_data["firstname"],
							 "empresa"=>$enterprise,
							 "email"=>$this->form_data["email"],
							 "phone"=>$this->form_data["phone"],
							 "nif"=>$this->form_data["nif"],
							 "country"=>$this->form_data["country"],
							 "street"=>$this->form_data["street"],
							 "zip"=>$this->form_data["zip"],
							 "city"=>$this->form_data["city"],
							 "distrito"=>$this->form_data["district"],
							 "Comment"=>$coments,
							 "dataOrder"=>$this->methods->getDate());
				
				$chk_fields = $this->chk_mandatory_fields($this->form_data);
				
			}else{
				$coments = isset($this->form_data["coments"]) ? $this->form_data["coments"] : "";
				$enterprise = isset($this->form_data["empresa"]) ? $this->form_data["empresa"] : "";
				
				$aux = array("CarrinhoCompras_CarrinhoCompraID"=>$id,
							 "fullname"=>$this->form_data["infirstname"],
							 "email"=>$this->form_data["inemail"],
							 "phone"=>$this->form_data["inphone"],
							 "nif"=>$this->form_data["innif"],
							 "country"=>$this->form_data["incountry"],
							 "street"=>$this->form_data["instreet"],
							 "zip"=>$this->form_data["inzip"],
							 "city"=>$this->form_data["incity"],
							 "district"=>$this->form_data["indistrict"],
							 "coments"=>$coments);
				$chk_fields = $this->chk_mandatory_fields($this->form_data);
			}
			
			if(count($chk_fields) > 0){
				return;
			}else{
				
				$results = $this->db->simpleInsert("encomenda", $aux);
				
				if($results[0]){
					$data = array("Order_OrderID"=>$results[1],
								  "Estado"=>"Em processamento",
								  "dataCriacao"=>$this->methods->getDate());
					$results = $this->db->simpleInsert("estado", $data);

					if($results[0]){
						unset($results);
						$where = array("CarrinhoCompraID"=>$id);
						$con = array("deleted"=>"Y");
						$results = $this->db->updateWConds("carrinhocompra", $where, '=', "", $con);

							if($results[0]){
								unset($where);
								$weight = 0;
								$this->setCartTotal(0);
								$this->setTotalPortes(0);
								$aux_pid = null;
								$aux2    = null;	
								
								$where = array("CarrinhoCompras_CarrinhoCompraID"=>$id);
								$results = $this->db->updateWConds("produtoscarrinho", $where, '=', "", $con);
								
								if($results[0]){
									$where = array("Buyer_User_userID"=>$this->user_data[0]['userid']);
									$field = "CarrinhoCompraID,Buyer_User_userID,SellerID,Produto_ProdutoID,
											  SUM(produtoscarrinho.Quantidade) as 'QtdTotal',SUM(produtoscarrinho.Preco) as 'TotalPrice',produtoscarrinho.dataAdicionado,
											  produtoscarrinho.deleted,ProdutoID,NomeProduto,produto.Autor,produto.deleted,
											  username,ROUND(SUM(produto.Peso),2) as 'PesoTotal'";

									$join = "INNER JOIN produtoscarrinho ON carrinhocompra.CarrinhoCompraID = produtoscarrinho.CarrinhoCompras_CarrinhoCompraID
											 INNER JOIN produto ON produtoscarrinho.Produto_ProdutoID = produto.ProdutoID
											 INNER JOIN user ON produto.User_userID = user.userid";

									$products = $this->db->freeSelect("carrinhocompra", $field, true, $where, "=", NULL, $join, "carrinhocompra.deleted = 'Y' AND produtoscarrinho.deleted = 'Y'", "GROUP BY produtoscarrinho.Produto_ProdutoID ORDER BY SellerID ASC");
									
									$content  = '<html><body>
												<table width="100%"><tbody>';
									$content .= '<tr>
												  <th scope="col">Artigo</th>
												  <th scope="col">User_userID</th>
												  <th scope="col">Quantidade</th>
												  <th scope="col">Preço</th>
												 </tr>';

									foreach($products as $value):
									  $content .= '<tr>
													 <td><h5 align="center">'.$value["NomeProduto"].'</h5></td>
													 <td><h5 align="center">'.$value["username"].'</h5></td>
													 <td><h5 align="center">'.$value['QtdTotal'].'</h5></td>
													 <td><h5 align="center">'.$value['TotalPrice'].' €</h5></td>
												   </tr>';
										if( $value['SellerID'] == $aux_pid || empty($aux_pid)){
											$weight = $weight + $value['PesoTotal'];
										}else{
											if($aux2 == $aux_pid){		
												$portes = $this->db->getPortes($weight);
												$portes = $portes[1][0]["Valor"];
												$this->setTotalPortes($this->getTotalPortes()+$portes);

												if($value['SellerID'] != $aux2){
													$weight = 0;
													$weight = $value['PesoTotal'];

													$portes = $this->db->getPortes($weight);
													$portes = $portes[1][0]["Valor"];
													$this->setTotalPortes($this->getTotalPortes()+$portes);
												}

											}else{
												$weight = 0;
												$weight = $value['PesoTotal'];

												$portes = $this->db->getPortes($weight);
												$portes = $portes[1][0]["Valor"];
												$this->setTotalPortes($this->getTotalPortes()+$portes);
											}
										}

										$this->setCartTotal(($this->getCartTotal() + $value['TotalPrice']));
										$aux2 = $aux_pid;
										$aux_pid = $value['SellerID'];
									endforeach;
									$content .= '<tr>
												   <th ></th>
												   <th ></th>
												   <th></th>
												   <th></th>
												 </tr>
												 <tr>
												   <th ></th>
												   <th ></th>
												   <th align="right">Total</th>
												  <th align="center">'.$this->getCartTotal().' €</th>
												 </tr>
												 <tr>
												   <th ></th>
												   <th ></th>
												   <th align="right">Portes</th>
												   <th align="center">'.$this->getTotalPortes().' €</th>
												 </tr>
												 <tr>
												   <th ></th>
												   <th ></th>
												   <th align="right">Total a pagar</th>
												   <th align="center">'.($this->getCartTotal()+$this->getTotalPortes()).' €</th>
												 </tr>
												</tbody>
												</table>';
									if($this->form_data['payment-method'] == "MB"){
								   		$content .= '<h4><strong>Nome:</strong> SocialArt Online Shop<br>
													 <strong>IBAN:</strong> PT50.0011.0000.12345678954.01<br>
													 <strong>Montante:</strong> '.($this->getCartTotal()+$this->getTotalPortes()).'</h4>';
									}else{
										$content .= '<h4>Pagamento efetuado via Paypal
													 <strong>Montante:</strong> '.($this->getCartTotal()+$this->getTotalPortes()).'</h4>';
									}
								   $content .= '</body></html>';
									$this->methods->sendMail("SocialArt", "nuno.markez@gmail.com", $this->form_data["email"], "Compra efetuada na SocialArt", $content);
								}
						}
					}
				}
			}
			return json_encode($results[0]);
		}
		
	}

	public function setTotalPortes($value){
		$this->totalPortes = $value;
	}
	
	public function getTotalPortes(){
		return $this->totalPortes;
	}
	
	public function setCartBuyer($value){
		$this->cartBuyer = $value;
	}
	
	public function getCartBuyer(){
		return $this->cartBuyer;
	}

	public function setCartID($value){
		$this->cartID = $value;
	}
	
	public function getCartID(){
		return $this->cartID;
	}

	public function setCartTotal($value){
		$this->cartTotal = $value;
	}
	
	public function getCartTotal(){
		return $this->cartTotal;
	}

	public function getUserAdd(){
		$id = array("user_userid"=>$this->user_data[0]['userid'], "Principal"=>"Y");
		return $this->db->selectWConditions("address", "street,zip,city,Distrito", true, $id, "=", "AND", "user_userid");
	}

	public function getUserAdressList(){
		if(!$this->login->chkUserLogin()){
			return;
		}

		$user = array( "user_userid" => $this->user_data[0]['userid'] );
		$results = $this->db->selectWConditions("address", "*", true, $user, "LIKE", "AND", "Principal DESC" );

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
	
	public function updateAddress(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		if($id == null){
			return;
		}
		
		$data = array("addressid"=>$id);
		echo json_encode($this->db->select("address", $data));
	}

	public function deleteFromCart(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		$cartid = (isset($_POST['cartID']) ? $_POST['cartID'] : null);

		if($id == null || $cartid == null){
			return;
		}

		$data = array("Produto_ProdutoID"=>$id, "CarrinhoCompras_CarrinhoCompraID"=>$cartid);
		echo json_encode($this->db->delete("produtoscarrinho",$data, true, "=", "AND" ));
	}

}
?>