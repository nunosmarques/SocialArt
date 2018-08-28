<?php
class FavoritosModel extends Methods {
	
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
		$this->user_data = $this->login->loadUser();
	}

	public function getFavProds(){
		if(!$this->login->chkUserLogin()){
			return;
		}

		$results = $this->db->innerJoinFavoritos("favoritos.User_userID", $this->user_data[0]['userid']);

		if($results[0]){
			foreach($results[1] as $value):
				echo '<div class="user-prods-row">';
					$aux = array("ProdutoID"=>$value["Produto_ProdutoID"]);

					$img_results = $this->db->selectWConditions("imagem", "imgID, imgNome", true, $aux, "LIKE", "AND", "imgID" );

					$img_id = (isset($img_results[0]['imgID']) ? $img_results[0]['imgID'] : "none");
					$img_name = (isset($img_results[0]['imgNome']) ? $img_results[0]['imgNome'] : "none");

					$img = '<img src="'.HOME_URI.'/views/_images/na.png" alt="Imagem Indisponivel" width="auto" height="auto">';
					$chk_img = $_SERVER['DOCUMENT_ROOT']."/ProjetoFinal/views/_uploads/".$img_name;

					if($img_name != "none" && is_file($chk_img)){
						$img = '<img src="'.HOME_URI.'/views/_uploads/'.$img_name.'" value="'.$img_id.'" alt="'.$value["NomeProduto"].'" width="auto" height="auto">';
					}

					echo '<div class="user-prods-img">'.$img.'</div>';
					echo '<div class="user-prods-name"><a href="'.HOME_URI.'/artigo/index/'.$value["Produto_ProdutoID"].'"><h5 align="center">'.$value['NomeProduto'].'</h5></a></div>';
					$author = (strlen($value["Autor"]) <= 0 ? $value["firstname"].' '.$value["lastname"] : $value["Autor"]);
					echo '<div class="user-prods-author"><h5 align="center">'.$author.'</h5></div>';
					echo '<div class="user-prods-price"><h5 align="center">'.$value["Preco"].' €</h5></div>';
					echo '<div class="user-prods-stock"><h5 align="center">'.$value["firstname"].' '.$value["lastname"].'</h5></div>';
					echo '<div class="options">
							<a href="#"><div class="btn-del-fav" title="Remover dos favoritos" value="'.$value["FavoritosID"].'"></div></a>
						  </div>';
					echo "<hr>";
				echo '</div>';
			endforeach;
		}else{
			echo '<h4 class="h4center">Não existem favoritos</h4>';	
		}
	}
	
 	public function removeFromFav(){
		$id = (isset($_POST['id']) ? $_POST['id'] : null);
		
		if($id == null){
			return;
		}		
		
		$data = array("FavoritosID"=>$id);
		echo json_encode($this->db->delete("favoritos",$data, true, "=", "" ));
	}
	
}
?>