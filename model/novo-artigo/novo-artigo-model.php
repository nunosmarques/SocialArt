<?php
class NovoArtigoModel extends Methods {
	
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
	 * Configura o DB, o Login, o controlador, os parâmetros e dados do utilizador.
	 *
	 * @access public
	 * @param object $db Objeto da nossa conexão PDO
	 * @param object $controller Objeto do controlador
	 * @param object $login Objeto do login
	 */
	public function __construct($db, $controller, $login) {
		// Configura o Login
		$this->login = $login;
		
		if(!$this->login->chkUserLogin()){
			header('Location:/ProjetoFinal/user-register/');
		}
		
		$this->user_data = $this->login->loadUser();
		// Configura o DB
		$this->db = $db;

		// Configura o controlador
		$this->controller = $controller;

		// Configura os parâmetros
		$this->parametros = $this->controller->parametros;
		
		//Configura os Methods
		$this->methods = new Methods();
	}

	public function insertProduct(){
		$new_id = null;
		// Verifica se algo foi postado
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && !empty( $_POST ) && isset($_POST['nprod-form'])){
			$errors = array();
			$this->form_data = $_POST;
			unset($this->form_data['nprod-form']);
			$this->form_data["User_userID"] = $this->login->getUserID();
			$this->form_data["dataAdicionado"] = $this->methods->getDate();

			$result = $this->db->simpleInsert("produto", $this->form_data);
			$new_id = $result[1];
			
			if($result[0]){
				//Verifica se foram adicionados ficheiros
				if(file_exists($_FILES['np-img']['tmp_name'][0])){
					$img = $_FILES['np-img'];

					// Faz o loop dos dados do post
					for($i = 0; $i < count($img['name']); $i++):
						$tmp_img  = array("tmp_name" => $img['tmp_name'][$i],
										  "name" => $img["name"][$i],
										  "type" => $img['type'][$i], 
										  "size" => $img['size'][$i],
										 );
						$res_img = $this->copyImgToDir($tmp_img, "\$".$this->login->getUsername());
					
						if($this->methods->checkImg($tmp_img) != "SUCCESS" || $res_img[0] != "SUCCESS"){
							array_push($errors, "<br>Erro ao copiar a imagem ".($i+1));
						}else{							
							$data["ProdutoID"]      = $result[1];
							$data["imgNome"]        = $res_img[1];
							$data["Size"]           = $tmp_img["size"];
							$data["dataAdicionado"] = $this->methods->getDate();

							$img_result = $this->db->simpleInsert("imagem", $data);

							if($img_result[0] != true){
								array_push($errors, "Erro ao adicionar a imagem ".($i+1));
							}
						}
					endfor;

					if(count($errors) > 0){
						$aux = implode(", ",$errors);
						$data = array("ProdutoID"=>$new_id);

						$this->db->delete("produto", $data, true, "=", null);

						echo '<script> alertBox("Ocorreu um erro!","O artigo não foi adicionado! Tente novamente '.$aux.'"); </script>';
					}else{
						echo '<script> alertBox("Artigo adicionado","O artigo foi adicionado com sucesso!"); </script>';				
					}					
				}else{
					echo '<script> alertBox("Ocorreu um erro!","O artigo não foi adicionado! Tente novamente"); </script>';
				}
			}
		}
	}
	
	/*
	 * Função que devolve todas as
	 * familias de produtos que existem
	 *
	 */
	public function getFamily(){
		$data = array("deleted"=>"N");
		$result = $this->db->select("categoria", $data);

		if(count($result[1]) > 0){
			foreach($result[1] as $value):
				echo '<option value="'.$value['CategoriaID'].'">'.$value['Categoria'].'</option>';
			endforeach;
		}
	}
}
?>