<?php
/**
 * Methods
 *
 * @package SocialArt
 * @version 1.0
 */
class Methods {
	
	/**
	 * $form_data
	 *
	 * Os dados de formulários de envio.
	 *
	 * @access public
	 */
	public $form_data;

	/**
	 * $form_msg
	 *
	 * As mensagens de feedback para formulários.
	 *
	 * @access public
	 */
	public $form_msg;

	/**
	 * $form_confirma
	 *
	 * Mensagem de confirmação para apagar dados de formulários
	 *
	 * @access public
	 */
	public $form_confirma;

	/**
	 * $db
	 *
	 * O objeto da nossa conexão PDO
	 *
	 * @access public
	 */
	public $db;

	/**
	 * $mandatory_fields
	 *
	 * Contém todos os campos obrigatórios de formulários
	 *
	 * @access private
	 */	
	private $mandatory_fields = array(
		"firstname",
		"lastname",
		"email",
		"country",
		"street",
		"seller",
		"username",
		"password",
		"chkpassword",
		"country",
		"adress",
		"zip",
		"city",
		"seller",
		"NomeProduto",
		"Preco",
		"Vendedor",
		"Perfil_User_userID",
		"Produto_ProdutoID"
	);
	
	/**
	 * $adress
	 *
	 * Contém os campos presentes na morada
	 *
	 * @access private
	 */
	private $adress = array(
		"Distrito",
		"country",
		"street",
		"zip",
		"city"
	);
	
	/**
	 * $adress
	 *
	 * Contém os campos presentes na morada
	 *
	 * @access private
	 */	
	private $user = array(
		"firstname",
		"lastname",
		"email",
		"username",
		"password",
		"chkpassword",
		"Seller",
		"nif",
		"phone",
		"description",
		"hash"
	);
	
	/**
	 * $controller
	 *
	 * O controller que gerou esse modelo
	 *
	 * @access public
	 */
	public $controller;

	/**
	 * $parametros
	 *
	 * Parâmetros da URL
	 *
	 * @access public
	 */
	public $parametros;

	/**
	 * $userdata
	 *
	 * Dados do usuário
	 *
	 * @access public
	 */
	public $userdata;

	/**
	 * Valida se os campos obrigatórios estão em branco
	 * 
	 * Este método vai verificar se os campos obrigatórios estão em branco
	 *
	 * @version 1.0
	 * @access public
	 */
	public function chk_mandatory_fields( $fieldsarray ){
		$empty_fields = array();
		
		if(empty($fieldsarray)){
			return;
		}

		foreach ( $fieldsarray as $key => $value) {
			if ( in_array( $key, $this->mandatory_fields ) && empty($value) ) {
				$aux = $this->fields2names($key);
				array_push($empty_fields, $aux);
			}
		}
		return $empty_fields;
	}

	/**
	 *
	 * modTest - testa se um numero
	 * é multiplo de outro
	 *
	 */		
	public function modTest($number, $numTest){ 
		return ($number % $numTest) == 0 ? '<div class="spliter"></div>' : ''; 
	}

	/**
	 * 
	 * Separa os campos das moradas dos do user
	 *
	 * @version 1.0
	 * @access public
	 */	
	public function split_adress_fields( $fieldsarray ){
		$adress_fields = array();
		
		if(empty($fieldsarray)){
			return;
		}
		
		foreach ( $fieldsarray as $key => $value) {
			if ( in_array( $key, $this->adress ) && !empty($value) ) {
				$adress_fields[$key] = $value;
			}
		}
		
		return $adress_fields;
	}	
	
	/**
	 *
	 * Separa os campos do user dos dos da morada
	 *
	 * @version 1.0
	 * @access public
	 *
	 */	
	public function split_users_fields( $fieldsarray ){
		$user_fields = array();
		
		if(empty($fieldsarray)){
			return;
		}
		
		foreach ( $fieldsarray as $key => $value) {
			if ( in_array( $key, $this->user ) && !empty($value) && $key != "chkpassword") {
				$user_fields[$key] = $value;
			}
		}
		
		return $user_fields;
	}
	
	/**
	 *
	 * Função para enviar mail
	 *
	 * @area = Nome de quem envia 
	 * @origem = 
	 * @destino = Destinatário do email
	 * @assunto = Subjet do email
	 * @mensagem = Conteudo do email
	 *
	 */		
	public function sendMail($area, $origem, $destino, $assunto, $mensagem){
		//Estrutura para enviar email de alerta
		//Para onde vai enviar
		$to       = $destino;
		
		//Assunto do email
		$subject  = $assunto;
		
		//A menssagem
		$message  = $mensagem;
		
		//Quem envia e para onde responder.
		$headers  = "From: ".$area."<".$origem.">"."\r\n";
		$headers .= "Reply-To: ". strip_tags($origem) . "\r\n";
		$headers .= "CC: \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		
		
		mail($to, $subject, $message, $headers);
	}
	
	/**
	 *
	 * Função para verificar se duas strings são iguais
	 *
	 * @version 1.0
	 * @access public
	 *
	 */	
	public function passMatch($str1 , $str2){
		if($str1 == $str2){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 *
	 * Função para tranformar os nomes dos campos
	 * em nome perceptiveis pelo user
	 *
	 * @version 1.0
	 * @access public
	 *
	 */	
	public function fields2names($element){
			switch($element):
				case "country":
					return "País";
					break;
				case "street":
					return "Morada";
					break;
				case "zip":
					return "Código Postal";
					break;
				case "city":
					return "Localidade";
					break;
				case "firstname":
					return "Nome";
					break;
				case "lastname":
					return "Apelido";
					break;
				case "email":
					return "Email";
					break;
				case "seller":
					return "Vendedor";
					break;
				case "username":
					return "Nome de utilizador";
					break;
				case "password":
					return "Palavra-passe";
					break;
				case "chkpassword":
					return "Confirmação da palavra-passe";
					break;
				default:
					return "";
					break;
			endswitch;
	}
	
	/**
	 *
	 * Função para gerar strings 
	 * aleatorias para utilizar
	 * para os visitantes
	 *
	 * @version 1.0
	 * @access public
	 *
	 */		
	public function genRandomString( $length, $pattern ){
		$str = '';
		if (!is_null($pattern)){
			$patternLength = strlen($pattern);
			if ($patternLength < $length)
				$pattern = str_repeat($pattern, floor($length / $patternLength)).substr($pattern, 0, $length % $patternLength);
			else if ($patternLength > $length)
				$pattern = substr($pattern, 0, $length);
		}else{
			$chars = array('d', 'c', 'C');
			$pattern = '';
			for ($i = 0; $i < $length; $i++)
			$pattern .= $chars[rand(0,2)];
		}
		for ($ch = 0; $ch < strlen($pattern); $ch++){
			if ($pattern[$ch] == 'd') $char = rand(48, 57);
			if ($pattern[$ch] == 'c') $char = rand(97, 122);
			if ($pattern[$ch] == 'C') $char = rand(65, 90);
			$str .= chr($char);
		}

		return $str;
	}
	
	/**
	 *
	 * Função que obtém e retorna o IP do
	 * visitante da página
	 *
	 * @version 1.0
	 * @access public
	 *
	 */	
	public function getUserIP(){
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP)){
			$ip = $client;
		}elseif(filter_var($forward, FILTER_VALIDATE_IP)){
			$ip = $forward;
		}else{
			$ip = $remote;
		}

		return $ip;
	}
	
	/**
	 *
	 * Função que vai verificar se
	 * a imagem está conforme as regras
	 *
	 */	
	public function	checkImg($img){

		$errors = array();
		$tmp    = $img['tmp_name'];
		$nome   = $img['name'];
		$tipo   = substr($img['type'], strrpos($img['type'], '/') + 1);
		$size   = $img['size'];

		if(strlen($nome)  <= 0 ){
			array_push($errors, "A imagem deve conter um nome!");
		}
		
		if($tipo != "png" && $tipo != "jpeg" && $tipo != "jpg" && $tipo != "gif"){		
			array_push($errors, "O formato de imagem '".$tipo."' carregado não é suportado!(apenas JPG, GIF ou PNG)");
		}
		
		if($this->formatbytes($size, "MB")  < 0 || $this->formatbytes($size, "MB") > 5){
			array_push($errors, "A imagem deverá ter no máximo 5 MB!");
		}

		if(count($errors) > 0){
			return $errors;
		}else{
			$errors = "SUCCESS";
		}
		return $errors;
	}

	/**
	 *
	 * Função que vai receber uma imagem
	 * e copiá-la para o diretorio
	 *
	 *
	 */	
	public function	copyImgToDir($img, $dir){
		$tmp  = $img['tmp_name'];
		$nome = $img['name'];
		$ext  = substr($img['type'], strrpos($img['type'], '/') + 1);
		$status = array();
		
		$tmp_dir = UP_ABSPATH.'/'.$dir;
		$tmp_nome  = md5($nome)."imglogo.".$ext;
		$fullpath = "";
		//Verifica se o diretorio existe 
		if( is_dir($tmp_dir) == false ){
			mkdir("$tmp_dir", 0777); //se não existe é criado
		}		

		if( !file_exists("$tmp_dir/".$tmp_nome)){
			copy($tmp, "$tmp_dir/".$tmp_nome);
		}else{
			//se já existir uma imagem com o mesmo nome esta vai ser renomeada	
			$tmp_nome = md5($tmp_nome).md5(time()).".".$ext;
			$novo_nome = "$tmp_dir/".$tmp_nome;
			rename($tmp , $novo_nome);
		}
		
		if(file_exists("$tmp_dir/".$tmp_nome) || file_exists($novo_nome)){
			$fullpath = $dir."/".$tmp_nome;
			$status = array("SUCCESS", $fullpath);
			return $status;
		}else{
			$status = array("FAIL", "none");
			return $status;
		}
	}

	public function formatbytes($file, $type){
		switch($type){
			case "KB":
				$filesize = $file * .0009765625; // bytes para KB
				break;
			case "MB":
				$filesize = ($file * .0009765625) * .0009765625; // bytes para MB
				break;
			case "GB":
				$filesize = (($file * .0009765625) * .0009765625) * .0009765625; // bytes para GB
				break;
		}
		return round($filesize, 2);
	}
	
	/*
	*
	* Metodo que devolve a
	* data e hora local
	*/
	public function getDate(){
		date_default_timezone_set("Europe/Lisbon");
		return date('Y-m-d H:i:s');
	}
	
	/**
	 *
	 * Função para listar todos os includes
	 * numa página
	 *
	 * @version 1.0
	 * @access public
	 *
	 */	
	public function listAllIncludes(){
		$included_files = get_included_files();
		foreach ($included_files as $filename) {
			echo "$filename<br>";
		}
	}
}