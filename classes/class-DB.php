<?php
/**
 * DB - Classe para gestão da base de dados
 *
 * @package SocialArt
 * @version 1.0
 */
class DB {
	/** DB properties */
	public $host     = '*******', // Host da base de dados 
		   $db_name  = 'socialart', // Nome da base de dados
		   $password = '', // Senha do utilizador da base de dados
		   $user     = '*******', // Utilizador da base de dados
		   $charset  = 'utf8', // Charset da base de dados
		   $pdo      = true, // A nossa conexão com o BD
		   $error    = null, // Configura o erro
		   $debug    = false, // Mostra todos os erros 
		   $last_id  = null; // Último ID inserido

	
	/**
	 * Construtor da classe
	 *
	 * @since 0.1
	 * @access public
	 * @param string $host     
	 * @param string $db_name
	 * @param string $password
	 * @param string $user
	 * @param string $charset
	 * @param string $debug
	 */
	public function __construct(){
		//$host , $db_name, $password, $user, $charset, $debug
		// Configura as propriedades novamente.
		$this->host = defined( 'HOSTNAME' ) ? HOSTNAME : $this->host;
		$this->db_name = defined( 'DB_NAME' ) ? DB_NAME : $this->db_name;
		$this->password = defined( 'DB_PASSWORD' ) ? DB_PASSWORD : $this->password;
		$this->user = defined( 'DB_USER' ) ? DB_USER : $this->user;
		$this->charset = defined( 'DB_CHARSET' ) ? DB_CHARSET : $this->charset;
		$this->debug = defined( 'DEBUG' ) ? DEBUG : $this->debug;

		// Conecta
		$this->connect();

	}
	
	/**
	 * Cria a conexão PDO
	 *
	 * @access protected
	 */
	final protected function connect() {

		/* Os detalhes da nossa ligação à base de dados PDO */
		$pdo_details = "mysql:host={$this->host};";
		$pdo_details .= "dbname={$this->db_name};";
		$pdo_details .= "charset={$this->charset};";

		// Tenta conectar
		try {
			$this->pdo = new PDO( $pdo_details, $this->user, $this->password );
			// Verifica se o debug está ativo
			if ( $this->debug === true ) {
				// Configura o PDO ERROR MODE
				$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			}
			//Descaratar estas propriedades, já não são necessárias
			unset( $this->host );
			unset( $this->db_name );
			unset( $this->password );
			unset( $this->user );
			unset( $this->charset );
		} catch ( PDOException $e ) {
			// Verifica se o debug está ativo
			if ( $this->debug === true ) {
				// Mostra a mensagem de erro
				echo "Erro: " . $e->getMessage();
			}
			// Interrompe a execução deste script
			die();
		}
	}

	/*
	 * simpleInsert - Um insere simples
	 *
	 * @access public
	 * @param string $table -> O nome da tabela
	 * @param array $columns -> Ilimitado número de chaves e valores
	 *
	 */
    public function simpleInsert($table, $columns) {
		$prep = array();
		$status = array();
		$status[0] = false;

		//Prepara o array recebido para o bindValue
		foreach($columns as $k => $v ) {
			if($k == "password"){
				$prep[':'.$k] = md5($v."tralaicosloki");			
			}else{
				$prep[':'.$k] = $v;
			}
		}
		$query = "INSERT INTO ".$table." (".implode(', ',array_keys($columns)).") VALUES (".implode(', ',array_keys($prep)).")";

		//Prepara a query
		$sql = $this->pdo->prepare($query);
		
		//Faz bind pelo tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}
			
			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}

		//Vai tentar executar, se falhar retorna 'false' e a mensagem de erro
		try{
			$sql->execute($prep);
			$status[0] = true; 
			$status[1] = $this->pdo->lastInsertId();
			$status[2] = $sql->rowCount();
		}catch(PDOException $erro){
			$status[0] = false;
			$status[1] = $erro->getMessage();
			$status[2] = "";
		}
		
        return $status;
    }
	
	/*
	 * selectWE - Selecciona com a condição de um unico valor
	 *
	 * @access public
	 * @param string $table -> O nome da tabela
	 * @param string $value -> Valor a procurar
	 *
	 */
	public function select_check($table, $parameter) {
		
		$query = "SELECT * FROM `".$table."` WHERE `".key($parameter)."` = '".$parameter[key($parameter)]."'";

		$sql = $this->pdo->prepare($query);

		try {
			
			$sql->execute();
			$result = $sql->rowCount();
			
			if($result > 0){
				return true;
			}else{
				return false;
			}
			
		}catch(PDOException $ex){
			return $ex->getMessage();
		}
	}
	
	/*
	 * select_doublecheck
	 * Verifica se o id já existe
	 *
	 * 6 argumentos
	 * $table = Tabela onde procurar
	 * $field = campo entre o select e o from
	 * $where = Verdadeiro ou Falso, para saber se executa com Where
	 * $array_filter = campo e valor a procurar
	 * $where_condition = Condição do where EX: "AND" ou "OR"
	 * $where_signal = Termo de comparação do where EX: "=" ou "Like"
	 *
	 */
	public function select_doublecheck($table, $field, $where, $array_filter, $where_sign, $where_condition) {
		$prep   = array();
		$string = "";
		$query  = "";
		//Prepara a query
		if(sizeof($table) <= 0 || sizeof($field) <= 0){
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			
			$query = "SELECT ".$field." FROM $table WHERE ".$string."  AND deleted = 'N'";
		}else{
			$query = "SELECT ".$field." FROM ". $table." WHERE deleted = 'N'";
		}

		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}

		try {
			
			$sql->execute();
			$result = $sql->rowCount();

			if($result > 0){
				return true;
			}else{
				return false;
			}
			
		}catch(PDOException $ex){
			return $ex->getMessage();
		}
	}
		
	/*
	 * countRows
	 * Conta o numero de resultados
	 * devolvidos
	 * 6 argumentos
	 * $table = Tabela onde procurar
	 * $field = campo entre o select e o from
	 * $where = Verdadeiro ou Falso, para saber se executa com Where
	 * $array_filter = campo e valor a procurar
	 * $where_condition = Condição do where EX: "AND" ou "OR"
	 * $where_signal = Termo de comparação do where EX: "=" ou "Like"
	 *
	 */
	public function countRows($table, $field, $where, $array_filter, $where_sign, $where_condition){
		$prep   = array();
		$string = "";
		$query  = "";
		//Prepara a query
		if(sizeof($table) <= 0 || sizeof($field) <= 0){
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			
			$query = "SELECT ".$field." FROM $table WHERE ".$string."  AND deleted = 'N'";
		}else{
			$query = "SELECT ".$field." FROM ". $table." WHERE AND deleted = 'N'";
		}
	
		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}

		try {			
			$sql->execute();
			$count = $sql->rowCount();
		}catch(PDOException $ex){
			echo '<script> 
					alert("Ocorreu um erro: \\n'.$ex->getMessage().'");
				  </script>';
		}
		
		return $count;
	}
	
	/*
	 * selectLimit
	 * Conta o numero de resultados
	 * devolvidos
	 * 6 argumentos
	 * $table = Tabela onde procurar
	 * $where = Verdadeiro ou Falso, para saber se executa com Where
	 * $array_filter = campo e valor a procurar
	 * $where_condition = Condição do where EX: "AND" ou "OR"
	 * $where_signal = Termo de comparação do where EX: "=" ou "Like"
	 *
	 */
	public function selectLimit($table, $where, $array_filter, $where_sign, $where_condition, $start , $limit, $orderby){
		
		$result = array();
		$prep   = array();
		$string = "";
		$query  = "";
		//Prepara a query
		if(sizeof($table) <= 0 || sizeof($start) <= 0 || sizeof($limit) <= 0){
			echo "Erro na table!<br>";
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				echo "Erro no filter, condition ou sign!<br>";
				//return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			
			$query = "SELECT * FROM $table WHERE ".$string."  AND deleted = 'N' ORDER BY ".$orderby." LIMIT $start , $limit";
		}else{
			$query = "SELECT * FROM ". $table." WHERE deleted = 'N' ORDER BY ".$orderby." LIMIT $start , $limit";
		}


		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}

		try {			
			$sql->execute();
			$result = $sql->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $ex){
			echo '<script> 
					alert("Ocorreu um erro: \\n'.$ex->getMessage().'");
				  </script>';
		}
		
		return $result;
	}

	/*
	 * selectWConditions
	 * Conta o numero de resultados
	 * devolvidos
	 * 6 argumentos
	 * $table = Tabela onde procurar
	 * $field = campo entre o select e o from
	 * $where = Verdadeiro ou Falso, para saber se executa com Where
	 * $array_filter = campo e valor a procurar
	 * $where_condition = Condição do where EX: "AND" ou "OR"
	 * $where_sign = Termo de comparação do where EX: "=" ou "Like"
	 * $orderby = Condição para a ordenação dos resultados
	 *
	 */
	public function selectWConditions($table, $field, $where, $array_filter, $where_sign, $where_condition, $orderby){
		
		$result = array();
		$prep   = array();
		$string = "";
		$query  = "";
		
		//Prepara a query
		if(sizeof($table) <= 0){
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			
			$query = "SELECT $field FROM $table WHERE $string AND deleted = 'N' ORDER BY $orderby";
		}else{
			$query = "SELECT $field FROM $table WHERE deleted = 'N' ORDER BY $orderby";
		}

		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}

		try {			
			$sql->execute();
			$result = $sql->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $ex){
			echo '<script> 
					alert("Ocorreu um erro: \\n'.$ex->getMessage().'");
				  </script>';
		}
		
		return $result;
	}

	/*
	 * selectWConditions
	 * Conta o numero de resultados
	 * devolvidos
	 * 6 argumentos
	 * $table = Tabela onde procurar
	 * $field = campo entre o select e o from
	 * $where = Verdadeiro ou Falso, para saber se executa com Where
	 * $array_filter = campo e valor a procurar
	 * $where_condition = Condição do where EX: "AND" ou "OR"
	 * $where_sign = Termo de comparação do where EX: "=" ou "Like"
	 * $orderby = Condição para a ordenação dos resultados
	 *
	 */
	public function selectWConditionsDelY($table, $field, $where, $array_filter, $where_sign, $where_condition, $orderby){
		
		$result = array();
		$prep   = array();
		$string = "";
		$query  = "";
		
		//Prepara a query
		if(sizeof($table) <= 0){
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			
			$query = "SELECT $field FROM $table WHERE $string AND deleted = 'Y' ORDER BY $orderby";
		}else{
			$query = "SELECT $field FROM $table WHERE deleted = 'Y' ORDER BY $orderby";
		}

		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}

		try {			
			$sql->execute();
			$result = $sql->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $ex){
			echo '<script> 
					alert("Ocorreu um erro: \\n'.$ex->getMessage().'");
				  </script>';
		}
		
		return $result;
	}
	
	/*
	 * freeSelect
	 * Conta o numero de resultados
	 * devolvidos
	 * 6 argumentos
	 * $table = Tabela onde procurar
	 * $field = campo entre o select e o from
	 * $where = Verdadeiro ou Falso, para saber se executa com Where
	 * $array_filter = campo e valor a procurar
	 * $where_condition = Condição do where EX: "AND" ou "OR"
	 * $where_sign = Termo de comparação do where EX: "=" ou "Like"
	 * $free = Recebe qualquer argumento que o utilizador colocar
	 *
	 */
	public function freeSelect($table, $field, $where, $array_filter, $where_sign, $where_condition, $free, $del, $more){
		
		$result = array();
		$prep   = array();
		$string = "";
		$query  = "";
		
		//Prepara a query
		if(sizeof($table) <= 0){
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			
			$query = "SELECT $field FROM $table $free WHERE $string AND $del $more";
		}else{
			$query = "SELECT $field FROM $table $free WHERE $del $more";
		}

		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}

		try {			
			$sql->execute();
			$result = $sql->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $ex){
			$result = false;
		}
		
		return $result;
	}

	/*
	 * selectLimit
	 * Conta o numero de resultados
	 * devolvidos
	 * 6 argumentos
	 * $table = Tabela onde procurar
	 * $field = campo entre o select e o from
	 * $where = Verdadeiro ou Falso, para saber se executa com Where
	 * $array_filter = campo e valor a procurar
	 * $where_condition = Condição do where EX: "AND" ou "OR"
	 * $where_sign = Termo de comparação do where EX: "=" ou "Like"
	 * $orderby = Condição para a ordenação dos resultados
	 *
	 */
	public function selectGroupBy($table, $field, $where, $array_filter, $where_sign, $where_condition, $groupby){
		
		$result = array();
		$prep   = array();
		$string = "";
		$query  = "";
		
		//Prepara a query
		if(sizeof($table) <= 0){
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			
			$query = "SELECT $field FROM $table WHERE $string AND deleted = 'N' GROUP BY $groupby";
		}else{
			$query = "SELECT $field FROM $table  WHERE deleted = 'N' GROUP BY $groupby";
		}


		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}

		try {			
			$sql->execute();
			$result = $sql->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $ex){
			$result[0] = false;
		}
		
		return $result;
	}
	
	/*
	 * selectWE - Selecciona com a condição de um unico valor
	 *
	 * @access public
	 * @param string $table -> O nome da tabela
	 * @param string $value -> Valor a procurar
	 *
	 */	
	public function select($table, $parameter) {
		$status = array();
		
		$query = "SELECT * FROM `".$table."` WHERE `".key($parameter)."` = '".$parameter[key($parameter)]."'";

		$sql = $this->pdo->prepare($query);

		try {
			
			$sql->execute();
			$result = $sql->rowCount();
			
			if($result > 0){
				$status[0] = true;
				$status[1] = $sql->fetchAll();
				return $status;
			}else{
				$status[0] = false;
				$status[1] = "false";
				return $status;
			}
			
		}catch(PDOException $ex){
			$status[0] = false;
			$status[1] = $ex->getMessage();
			return $status;
		}
	}

	public function innerJoinFavoritos($where, $what) {
		$query = "SELECT * FROM favoritos 
				  INNER JOIN produto ON favoritos.Produto_ProdutoID = produto.ProdutoID
				  INNER JOIN user ON produto.User_userID = user.userid
				  WHERE ".$where." = ".$what."";
		
		$sql = $this->pdo->prepare($query);

		try {
			
			$sql->execute();
			$result = $sql->rowCount();
			
			if($result > 0){
				$status[0] = true;
				$status[1] = $sql->fetchAll();
				return $status;
			}else{
				$status[0] = false;
				$status[1] = "false";
				return $status;
			}
			
		}catch(PDOException $ex){
			$status[0] = false;
			$status[1] = $ex->getMessage();
			return $status;
		}
	}
	
	public function selectMensage($userid, $filed) {
		$fields = "mensagem.MensagemID as 'MensagemID', mensagem.User1_userID, 
				   mensagem.User2_userID, mensagem.Arquivada, mensagem.deleted,
				   mensagens.Mensagem_MensagemID, mensagens.SenderID, mensagens.New as 'New', 
				   mensagens.dataAdicionada, user.userid, user.username as 'Nome' ";
		
		$query = "SELECT ".$fields." FROM mensagem
				  INNER JOIN mensagens ON mensagens.Mensagem_MensagemID = mensagem.MensagemID
				  INNER JOIN user ON user.userid = mensagem.User1_userID 
				  AND User1_userID <> ".$userid." OR user.userid = User2_userID 
				  AND User2_userID <> ".$userid." 
				  WHERE Arquivada = 'N' AND mensagem.deleted = 'N' AND User1_userID = ".$userid." 
				  OR Arquivada = 'N' AND mensagem.deleted = 'N' AND User2_userID = ".$userid."
				  GROUP BY mensagem.MensagemID ORDER BY mensagens.dataAdicionada";
	
		$sql = $this->pdo->prepare($query);

		try {
			
			$sql->execute();
			$result = $sql->rowCount();
			
			if($result > 0){
				$status[0] = true;
				$status[1] = $sql->fetchAll();
				return $status;
			}else{
				$status[0] = false;
				$status[1] = "false";
				return $status;
			}
			
		}catch(PDOException $ex){
			$status[0] = false;
			$status[1] = $ex->getMessage();
			return $status;
		}
	}

	public function selectMensageFilled($userid, $filed) {
		$fields = "mensagem.MensagemID as 'MensagemID', mensagem.User1_userID, 
				   mensagem.User2_userID, mensagem.Arquivada, mensagem.deleted,
				   mensagens.Mensagem_MensagemID, mensagens.SenderID, mensagens.New as 'New', 
				   mensagens.dataAdicionada, user.userid, user.username as 'Nome'";
		$query = "SELECT ".$fields." FROM mensagem
				  INNER JOIN mensagens ON mensagens.Mensagem_MensagemID = mensagem.MensagemID
				  INNER JOIN user ON user.userid = mensagem.User1_userID 
				  AND User1_userID <> ".$userid." OR user.userid = User2_userID 
				  AND User2_userID <> ".$userid." 
				  WHERE Arquivada = 'Y' AND mensagem.deleted = 'N' AND User1_userID = ".$userid." 
				  OR Arquivada = 'Y' AND mensagem.deleted = 'N' AND User2_userID = ".$userid."
				  GROUP BY mensagem.MensagemID ORDER BY mensagens.dataAdicionada";
		
		$sql = $this->pdo->prepare($query);

		try {
			
			$sql->execute();
			$result = $sql->rowCount();
			
			if($result > 0){
				$status[0] = true;
				$status[1] = $sql->fetchAll();
				return $status;
			}else{
				$status[0] = false;
				$status[1] = "false";
				return $status;
			}
			
		}catch(PDOException $ex){
			$status[0] = false;
			$status[1] = $ex->getMessage();
			return $status;
		}
	}

	public function selectMensages($where, $what, $fields) {
		$status[0] = false;
		$status[1] = false;
		
		$query = "SELECT ".$fields." FROM mensagens
				  INNER JOIN user ON mensagens.SenderID = user.userid
				  WHERE ".$where." = ".$what."
				  ORDER BY mensagens.dataAdicionada ASC";
		
		$sql = $this->pdo->prepare($query);

		try {
			
			$sql->execute();
			$result = $sql->rowCount();
			
			if($result > 0){
				$status[0] = true;
				$status[1] = $sql->fetchAll();
				return $status;
			}else{
				$status[0] = false;
				$status[1] = false;
			}
			
		}catch(PDOException $ex){
			$status[0] = false;
			$status[1] = $ex->getMessage();
		}
		return $status;
	}

	public function getPortes($peso){
		$status[0] = false;
		$status[1] = false;
		
		$query = "SELECT Valor FROM portes
				  WHERE PesoMin <= ".$peso." AND PesoMax >= ".$peso." AND deleted = 'N'
				  ORDER BY dataAtualizado DESC";
		
		$sql = $this->pdo->prepare($query);

		try {
			
			$sql->execute();
			$result = $sql->rowCount();
			
			if($result > 0){
				$status[0] = true;
				$status[1] = $sql->fetchAll();
				return $status;
			}else{
				$status[0] = false;
				$status[1] = false;
			}
			
		}catch(PDOException $ex){
			$status[0] = false;
			$status[1] = $ex->getMessage();
		}
		return $status;
	}

	public function prodViewUpdate($what) {
		$query = "UPDATE produto SET visitas = (visitas+1) WHERE ProdutoID = ".$what."";

		$sql = $this->pdo->prepare($query);

		try {
			
			$sql->execute();
			$result = $sql->rowCount();
			
			if($result > 0){
				$status[0] = true;
				$status[1] = $result;
				return $status;
			}else{
				$status[0] = false;
				$status[1] = "false";
				return $status;
			}
			
		}catch(PDOException $ex){
			$status[0] = false;
			$status[1] = $ex->getMessage();
			return $status;
		}
	}
	
	/*
	 * countNewMSGRows
	 * Conta o numero de resultados
	 * devolvidos pela tabela mensagem
	 * apenas com as novas mensagens
	 * para um user especifico
	 *
	 */
	public function countNewMSGRows($userid){
		$count = 0;
		
		$query = "SELECT * FROM mensagem 
				  INNER JOIN mensagens ON mensagens.Mensagem_MensagemID = mensagem.MensagemID 
				  AND New = 'Y' AND SenderID <> ".$userid." 
				  WHERE User1_userID = ".$userid." OR User2_userID = ".$userid." AND Arquivada = 'N' AND deleted = 'N'";

		$sql = $this->pdo->prepare($query);

		try {			
			$sql->execute();
			$count = $sql->rowCount();
		}catch(PDOException $ex){
			echo '<script> 
					alert("Ocorreu um erro: \\n'.$ex->getMessage().'");
				  </script>';
		}
		
		return $count;
	}
	
	public function markMsgUnreaded($msgid, $id){
		$query = "UPDATE mensagens
				  SET New = 'Y'
				  WHERE Mensagem_MensagemID = ".$msgid." AND idMensagens = ".$id;

		$sql = $this->pdo->prepare($query);

		try {			
			$sql->execute();
			$count1 = $sql->rowCount();
		}catch(PDOException $ex){
			echo '<script> 
					alert("Ocorreu um erro: \\n'.$ex->getMessage().'");
				  </script>';
		}		
	}
	
    function delete($table, $array_filter, $where, $where_sign, $where_condition){		
		$result = array();
		$prep   = array();
		$string = "";
		$query  = "";
		$state[0] = false;
		//Prepara a query
		if(strlen($table) <= 0){
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			$query = "DELETE FROM ".$table." WHERE ".$string;
		}else{
			return;
		}
		
		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}
		
		
		try {		
			$sql->execute();
			$state[0] = true;
			$state[1] = $sql->rowCount();
		}catch(PDOException $ex){
			$state[0] = false;
			$state[1] = "Erro: ".$ex->getMessage();
		}
		
        return $state;
    }

    function deleteWNumRows($table, $array_filter, $where, $where_sign, $where_condition){		
		$result = array();
		$prep   = array();
		$string = "";
		$query  = "";
		$state = "";
		
		//Prepara a query
		if(strlen($table) <= 0){
			return;
		}
		
		if($where){
			if(sizeof($array_filter) <= 0 || sizeof($where_sign) <= 0){
				return;
			}
			
			foreach($array_filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '. $where_sign .' :' . $k .' '. $where_condition . ' ';
			}
					
			if(!empty($where_condition)){
				if($where_condition == "AND"){
					$string = substr($string, 0, -4);	
				}else{
					$string = substr($string, 0, -3);
				}
			}
			$query = "DELETE FROM ".$table." WHERE ".$string;
		}else{
			return;
		}
		
		$sql = $this->pdo->prepare($query);

		//Faz bind por tipo
		foreach($prep as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}

			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}
		
		
		try {		
			$sql->execute();
			$state = $sql->rowCount();
							
		}catch(PDOException $ex){
			
			$state = "Erro: ".$ex->getMessage();
		}
		
        return $state;
    }
	
 	public function updateWConds($table, $array_filter, $where_sign, $where_condition, $array_columns){
		$string_c = "";
		$string_w = "";
		$filter = array();
		$columns = array();
		$result[0] = false;
		foreach($array_columns as $k => $v ){
			$columns[':'.$k] = $v;
			$string_c .= $k . ' = :' . $k.', ';
		}
		
		$string_c = substr($string_c, 0, -2);
		
		foreach($array_filter as $k => $v ){
			$filter[':'.$k.'w'] = $v;
			$string_w .= $k . ' '.$where_sign.' :' . $k.'w '.$where_condition.' ';
		}
		
		
		if(!empty($where_condition) || strlen($where_condition) > 0){
			if(sizeof($where_condition) > 0){
				if($where_condition == "OR"){
					$string_w = substr($string_w, 0, -3);
				}else{
					$string_w = substr($string_w, 0, -4);
				}
			}
		}
		
		$query = "UPDATE ".$table." SET ".$string_c." WHERE ".$string_w;

		$sql = $this->pdo->prepare($query);
		
		//Faz bind por tipo
		foreach($columns as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}
			
			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}
		
		foreach($filter as $k => $v ) {
			if(is_int($v)){
				$sql->bindValue($k, $v , PDO::PARAM_INT);
			}
			
			if(is_string($v) || is_float($v) ){
				$sql->bindValue($k, $v , PDO::PARAM_STR);
			}
		}
		
		try {	
		
			$sql->execute();
			$result[0] = true;
			$result[1] = $sql->rowCount();
		}catch(PDOException $ex){
			$result[0] = false;
			$result[1] = $ex->getMessage();
		}
		
		return $result;
	}
	
    public function undelete($table, $filter, $where_sign, $where_condition) {
		$query = "";
		$string = "";
		$state = false;
		if(sizeof($filter) > 0){
			
			foreach($filter as $k => $v ){
				$prep[':'.$k] = $v;
				$string .= $k . ' '.$where_sign.' :' . $k .' '.$where_condition . ' ';
			}
			if(sizeof($where_condition) > 0){
				if($where_condition == "OR"){
					$string = substr($string, 0, -3);
				}else{
					$string = substr($string, 0, -4);
				}
			}
			$query = "UPDATE ".$table." SET deleted = 'N' WHERE ".$string;
			$sql = $this->conn->prepare($query);
			
			//Faz bind por tipo
			foreach($prep as $k => $v ) {
				if(is_int($v)){
					$sql->bindValue($k, $v , PDO::PARAM_INT);
				}
				
				if(is_string($v) || is_float($v) ){
					$sql->bindValue($k, $v , PDO::PARAM_STR);
				}
			}
			
		}else{
			$state = false;
		}
		
		
		try {		
			$sql->execute();
			$state = true;
							
		}catch(PDOException $ex){
			$state = false;
		}
			
        return $state;
    }

}