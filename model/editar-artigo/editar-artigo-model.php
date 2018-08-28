<?php
class EditarArtigoModel extends Methods {

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
	 * @access public
	 */	
	private $productID;
	
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
		
		if(isset($_POST['ProdutoID'])){
			$this->setProductID($_POST['ProdutoID']);
		}else{
			$this->setProductID($this->params[0]);
		}
		
		$data = array("User_userID"=>$this->login->getUserID(), "ProdutoID"=>$this->getProductID());
		$rows = $this->db->countRows("produto", "*", true, $data, "LIKE", "AND");

		if($rows <= 0){ header('Location:/ProjetoFinal/'); }
		$this->form_data = $this->loadProduct();
	}
	
	public function loadProduct(){
		$prod_data = array("ProdutoID"=>$this->params[0]);
		return $this->db->selectWConditions("produto", "*", true, $prod_data, "=", "", "ProdutoID ASC");
	}
	
	public function getProductImg(){
		$prod_data = array("ProdutoID"=>$this->params[0]);
		$result = $this->db->selectWConditions("imagem", "*", true, $prod_data, "=", "", "imgID ASC");

		echo '<div class="main-edit-thumbnails">';		
		foreach($result as $value):
			echo '<div class="edit-menu-thumbnails-container">';
			echo '<div class="thumbnails-edit">
					<a href="#"><img src="/ProjetoFinal/views/_uploads/'.$value['imgNome'].'"></a>
				 </div>';
			echo '<div class="thumbnails-edit-options">
						<a href="#" value="'.$value['imgID'].'"><div class="btn-del-edit" title="Eliminar imagem do '.$this->form_data[0]['NomeProduto'].'" value="'.$value['imgID'].'"></div></a>
				 </div>';
			echo '</div>
				 <hr>';
		endforeach;
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
	
	/*
	 * Função que devolve todas as
	 * familias de produtos que existem
	 *
	 */
	public function getFamily(){
		$data = array("deleted"=>"N");
		$result = $this->db->select("categoria", $data);
		if(count($result) > 0){
			foreach($result[1] as $value):
				if($value['CategoriaID'] == $this->form_data[0]['Categoria_CategoriaID']){
					echo '<option selected value="'.$value['CategoriaID'].'">'.$value['Categoria'].'</option>';
				}else{
					echo '<option value="'.$value['CategoriaID'].'">'.$value['Categoria'].'</option>';
				}
			endforeach;
		}
	}
	
	public function delImg(){
		$result = array(false);
		$id = (isset($_POST['id']) ? $_POST['id'] : null);

		if($id == null){
			$result = array(false);
		}
		$data = array("imgID"=>$id);
		$result = $this->db->deleteWNumRows("imagem", $data, true, "=", "");
		if($result > 0){
			$result = array(true, $result);
		}else{
			$result = array(false, $result);
		}
		echo json_encode($result);
	}
	
	public function updateArtigo(){
		// Verifica se algo foi postado
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && !empty( $_POST ) && isset($_POST['upprod-form'])){
			$errors = array();
			$eco = array();
			$this->form_data = $_POST;
			unset($this->form_data['upprod-form']);
			
			$where = array("ProdutoID"=>$this->form_data['ProdutoID']);
			
			$data = array("ProdutoID"=>$this->form_data['ProdutoID'],
						  "NomeProduto"=>$this->form_data['NomeProduto'],
						  "Autor"=>$this->form_data['Autor'],
						  "Preco"=>$this->form_data['Preco'],
						  "Quantidade"=>$this->form_data['Quantidade'], 
						  "Peso"=>$this->form_data['Peso'],
						  "Categoria_CategoriaID"=>$this->form_data['Familia'], 
						  "SmallDescription"=>$this->form_data['SmallDescription']);
				
			$result = $this->db->updateWConds("produto", $where, "=", "", $data);

			if($result){
				//Verifica se foram adicionados ficheiros
				if(file_exists($_FILES['upp-img']['tmp_name'][0])){
					$chkRows = array("ProdutoID"=>$this->form_data["ProdutoID"]);
					$numRows = $this->db->countRows("imagem", "ProdutoID", true, $chkRows, "=", "" );
					//($table, $field, $where, $array_filter, $where_sign, $where_condition)
					if($numRows <= 5){
						$img = $_FILES['upp-img'];

						// Faz o loop dos dados do post
						for($i = 0; $i < count($img['name']); $i++):
							$tmp_img  = array("tmp_name" => $img['tmp_name'][$i],
											  "name" => $img["name"][$i],
											  "type" => $img['type'][$i], 
											  "size" => $img['size'][$i],
											 );
							$res_img = $this->copyImgToDir($tmp_img, "\$".$this->login->getUsername());
							$imgchkres = $this->methods->checkImg($tmp_img);

							if($imgchkres != "SUCCESS" || $res_img[0] != "SUCCESS"){
								if(is_array($imgchkres)){
									foreach($imgchkres as $value):
									array_push($errors, "<br>".$value);
									endforeach;
								}else{ array_push($errors, "<br>".$imgchkres); }
								array_push($errors, implode("<br>",$res_img));
							}else{	
								unset($data);
								$data["ProdutoID"]      = $this->form_data["ProdutoID"];
								$data["imgNome"]        = $res_img[1];
								$data["Size"]           = $tmp_img["size"];
								$data["dataAdicionado"] = $this->methods->getDate();

								$img_result = $this->db->simpleInsert("imagem", $data);

								if($img_result[0] != true){
									array_push($errors, implode("<br>",$img_result));
								}
							}
						endfor;

						if(count($errors) > 0){
							$eco[0] = "Ocorreu um erro!";
							$eco[1] = "O artigo foi atualizado, mas não foi possivel atualizar as imagens! Tente novamente.";
						}else{
							$eco[0] = "Artigo atualizado";
							$eco[1] = "O artigo foi atualizado com sucesso!";
						}
					}else{
						$eco[0] = "Artigo já possoui imagens!";
						$eco[1] = "O artigo foi atualizado mas sem alteração nas imagens,<br> elimine imagens para poder colocar novas.<br> O limite são 5 imagens!";						
					}
				}else{
					$eco[0] = "Artigo atualizado!";
					$eco[1] = "O artigo foi atualizado mas sem alteração nas imagens!";
				}
			}
			echo '<script> 
					alertBox("'.$eco[0].'","'.$eco[1].'<br>'.implode("",$errors).'"); 
				 </script>';		
		}
		
	}
	
	
}
?>