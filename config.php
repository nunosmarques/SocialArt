<?php
/**
 * Configuração geral
 */
 
// Caminho para a raiz
define( 'ABSPATH', dirname( __FILE__ ) );
 
// Caminho para a pasta de uploads
define( 'UP_ABSPATH', ABSPATH . '/views/_uploads' );
 
// URL da home
define( 'HOME_URI', '/ProjetoFinal' );
 
// Nome do host da base de dados
define( 'HOSTNAME', '********' );
 
// Nome do DB
define( 'DB_NAME', 'socialart' );
 
// Usuário do DB
define( 'DB_USER', '*****' );
 
// Senha do DB
define( 'DB_PASSWORD', '********' );
 
// Charset da conexão PDO
define( 'DB_CHARSET', 'utf8' );
 
//Em desenvolvimento este valor está a true
define( 'DEBUG', true );
 
// Carrega o loader, que vai carregar a aplicação inteira
require_once ABSPATH . '/loader.php';
?>