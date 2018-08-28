<?php
class FotografiaModel extends Methods {
	
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
	 * $actualPage
	 *
	 * Variavel que contém
	 * a página atual apresentada
	 *
	 * @access public
	 */
	private $actualPage;

	/**
	 * $counter
	 *
	 * Variavel que contém
	 * o numero total de resultados
	 * devolvidos pela query
	 *
	 * @access public
	 */
	private $counter;

	/**
	 * $pageLimit
	 *
	 * Variavel que contém
	 * o limite de items
	 * que são apresentados
	 * por página
	 *
	 * @access public
	 */
	private $pageLimit;

	/**
	 * $start
	 *
	 * Variavel que contém
	 * o numero inicial
	 * em que a query vai
	 * apresentar os items
	 *
	 * @access public
	 */
	private $start;

	/**
	 * $totalPages
	 *
	 * Variavel que contém
	 * o numero total de
	 * páginas disponivel
	 *
	 * @access public
	 */
	private $totalPages;
	
	
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
		$this->setActualPage(str_replace('pagina-', '', $this->params[0]));
		
		if($this->login->chkUserLogin()){
			$this->user_data = $this->login->loadUser();
		}
		
		$this->counter = $this->countRows();
		$this->setPagelimit(12);
		$this->setTotalPages(ceil($this->counter/$this->getPageLimit()));
		$this->setStart((($this->getPageLimit() * $this->getActualPage())-$this->getPageLimit()));
	}
	
	/**
	 *
	 * getProduct - função para imprimir
	 * no ecrã todos os produtos
	 * da categoria Pintura
	 * provenientes da DB
	 *
	 */	
	public function getProduct(){
		if($this->counter == 0){
			echo '<h4 class="h4center">Não existem items categoria Pintura!</4>';
		}else{
			$clause = array("Categoria_CategoriaID" => "2");
			$results = $this->db->selectLimit("produto", true, $clause, "Like", NULL, $this->getStart(), $this->getPageLimit(), "ProdutoID DESC");
			
			$i = 1;
			foreach($results as $array => $value):
				$idprod   = $value["NomeProduto"];
				$sellerID = $value["User_userID"];
				$data     = array("ProdutoID"=>$value["ProdutoID"]);
			
				$img_path = $this->db->selectWConditions("imagem", "imgID,imgNome,dataAdicionado", true, $data, "=", "", "imgID");
				$img_name = (isset($img_path[0]['imgNome']) ? $img_path[0]['imgNome'] : "none");
				$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;
				
				$user_seldata = array("userid"=>$value['User_userID']);
				$field = "userid,username,firstname,lastname";
				$seller = $this->db->selectWConditions("user", $field, true, $user_seldata, "=", "", "userid");

				if(strlen($idprod) > 28){
					$idprod = substr($idprod, 0, 28)."...";
				}

				if(strlen($sellerID) > 16){
					$sellerID = substr($sellerID, 0, 16)."...";
				}

				$sellerName = $seller[0]["firstname"].' '.$seller[0]["lastname"];
				if(strlen($sellerName) > 16){
					$sellerName = substr($sellerName, 0, 16)."...";
				}

				echo '<div class="produt-container">
						<div class="img-container">';
				if($img_name != "none" && is_file($chk_img)){
					echo '<img src="'.HOME_URI.'/views/_uploads/'.$img_name.'" width="auto" height="auto"/>';
				}else{
					echo '<img src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
				}
							
				echo		'<div class="hover">
								<div class="btn-container">';
						if($this->login->chkUserLogin()){
							if( $this->chkFav($value["ProdutoID"]) == false && $this->user_data[0]['userid'] != $value["User_userID"]){	
								echo '<a href="#'.$value["ProdutoID"].'"><div class="addFav" title="Adicionar aos favoritos"></div></a>';
							}
						}
				$prod_name = str_replace(' ', '-', strtolower($value["NomeProduto"]));
				echo			'</div>
							</div>
						</div>
						<div class="text-container">
							<div class="left-div">
								<a href="'.HOME_URI.'/artigo/index/'.$value["ProdutoID"].'/'.$prod_name.'" title="'.$value["NomeProduto"].'" value="'.$value["ProdutoID"].'" id="prod-id"><h4 align="left">'.$idprod.'</h4></a>
								<div class="seller-list-container">
									<div class="seller-name">
										<h4><a href="'.HOME_URI.'/produtos-do-utilizador/index/pagina-1/'.$sellerID.'/'.$seller[0]["firstname"].' '.$seller[0]["lastname"].'"><b class="lseller" value="'.$sellerID.'">'.$sellerName.'</b></a></h4>
									</div>';
			if($this->login->chkUserLogin()){
					if( $this->chkFollow($value["User_userID"]) == false ){
							echo	'<div class="follow-seller">
										<a href="#"><div class="follow" title="Seguir '.$sellerName.'" value="'.$sellerID.'"></div></a>
										<div class="follow-label"></div>
									</div>';
					}else if($this->user_data[0]['userid'] != $value["User_userID"]){
					echo	'<div class="follow-seller">
								<a href="#"><div class="unfollow" title="Remover '.$sellerName.'" value="'.$sellerID.'"></div></a>
								<div class="follow-label"></div>
							</div>';					
					}
			}
			
				echo			'</div>
							</div>
							<div class="right-div">
								<h4 align="center" class="rprice"><b>'.$value["Preco"].' €</b></h4>';
							if($this->user_data[0]['userid'] != $value["User_userID"]){	
								echo '<h4 align="center"><a href="#addCart" title="Adicionar '.$value["NomeProduto"].' ao carrinho" class="fa fa-cart-plus btn-addToCart"></a></h4>';
							}
				echo		'</div>
						</div>
					 </div>';
				echo $this->methods->modTest($i, 3);
				$i++;
			endforeach;
			echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';
		}
	}

	/**
	 *
	 * pagination - função responsável
	 * por criar a numeração das
	 * páginas
	 *
	 */	
	public function pagination(){
		echo '<a class="text25px" href="'.HOME_URI.'/fotografia/index/pagina-1">&laquo;</a>
				<a class="text25px" href="'.HOME_URI.'/fotografia/index/pagina-'.($this->getActualPage() > 1 ? ($this->getActualPage()-1) : 1).'">&lsaquo;</a>';
		for($i = 1; $i <= $this->getTotalPages(); $i++){		
					echo '<a href="'.HOME_URI.'/fotografia/index/pagina-'.$i.'" class="page-num">'.$i.'</a>';
		}
		echo '<a class="text25px" href="'.HOME_URI.'/fotografia/index/pagina-'.($this->getActualPage() < $this->getTotalPages() ? ($this->getActualPage()+1) : $this->getTotalPages()).'">&rsaquo;</a>
			  <a class="text25px" href="'.HOME_URI.'/fotografia/index/pagina-'.$this->getTotalPages().'">&raquo;</a>';
		echo '<script> pagination_switch('.($this->getActualPage()-1).'); </script>';
	}

	/**
	 *
	 * setActualPage - função que define
	 * a página actual apresentada
	 *
	 */	
	private function setActualPage($aPage){
		$this->actualPage = $aPage;
	}
	
	/**
	 *
	 * getActualPage - função que devolve
	 * a página em que o utilizador está
	 * actualmente
	 *
	 */	
	public function getActualPage(){
		return $this->actualPage;
	}

	/**
	 *
	 * setPageLimit - função que define
	 * a quantidade de resultados
	 * a serem mostrados por página
	 *
	 */	
	private function setPageLimit($value){
		$this->limit = $value;
	}	
	
	/**
	 *
	 * getPageLimit - função que devolve
	 * a quantidade de resultados
	 * a serem mostrados por página
	 *
	 */	
	private function getPageLimit(){
		return $this->limit;
	}

	/**
	 *
	 * setStart - função que define
	 * o valor inicial a partir do
	 * qual a DB devolve objetos
	 *
	 */	
	private function setStart($value){
		$this->start = $value;
	}	
	
	/**
	 *
	 * getStart - função que devolve
	 * o valor inicial a partir do
	 * qual a DB devolve objetos
	 *
	 */	
	private function getStart(){
		return $this->start;
	}	

	/**
	 *
	 * setTotalPages - função que define
	 * o valor total de páginas a apresentar
	 *
	 */	
	private function setTotalPages($value){
		
		$this->totalPages = $value;
	}	
	
	/**
	 *
	 * getTotalPages - função que devolve
	 * o valor total de páginas a apresentar
	 *
	 */	
	private function getTotalPages(){
		return $this->totalPages;
	}
	
	/**
	 *
	 * countRows - função que devolve
	 * o numero de resultados da
	 * consulta à DB
	 *
	 */	
	public function countRows(){
		$clause = array("Categoria_CategoriaID" => "2");
		return $this->db->countRows("produto", "ProdutoID", true, $clause, "Like", NULL);
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
					$chk_fields = $this->chk_mandatory_fields($this->form_data);
					if(sizeof($chk_fields) > 0){
						$aux = implode("\\n  ",$chk_fields);
						$x = array('Ocorreu um erro','Ocorreu um erro ao adicionar o produto!');
						echo json_encode($x);
						return;
					}

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

	private function chkUserProd($userID, $prodID){
		$data = array("ProdutoID"=>$prodID,"User_userID"=>$userID);	
		return $this->db->countRows("produto", "ProdutoID,User_userID", true, $data, "=", "AND");
	}
	
}
?>