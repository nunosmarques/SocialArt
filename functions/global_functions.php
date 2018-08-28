<?php
/**
 * Função chek_array.
 *
 * Verifica se a chave existe no array e se ela tem algum valor.
 * Obs.: Essa função está no scope global, pois é bastante solicitada
 *
 * @param array  $array -> O array
 * @param string $key   -> A chave do array
 *
 * @return string|null  -> O valor da chave do array ou nulo, 
 * dependendo se existe ou não no array
 */
function chk_array( $array, $key ) {
	// Verifica se a chave existe no array
	if ( isset( $array[ $key ] ) && !empty( $array[ $key ] ) ) {
		// Retorna o valor da chave
		return $array[ $key ];
	}

	// Retorna nulo por padrão
	return null;
}


/**
 * Função para carregar automaticamente todas as classes padrão
 * As minhas classes estão na pasta classes/.
 * Para a função autoload funcionar corretamente, nome do arquivo deverá ser class-NomeDaClasse.php
 */
function __autoload( $class_name ) {
	$file = ABSPATH . '/classes/class-' . $class_name . '.php';

	// Se o arquivo não existir, inclui a página padrão 
	// para o erro 404 "file not found"
	if ( !file_exists( $file ) ) {
		require_once ABSPATH . '/views/_includes/404.php';
		return;
	}

	// Inclui o arquivo da classe
	require_once $file;
}

?>