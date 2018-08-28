<?php
// Evita que utilizadores tenham acesso a este ficheiro diretamente
if ( ! defined('ABSPATH')) exit;
 
// Inicia a sessão
session_start();
 
// Verifica o modo para efetuar debug,
// se estiver a true vai mostrar os erros
if ( ! defined('DEBUG') || DEBUG === false ) {
 
 // Esconde todos os erros
 error_reporting(0);
 ini_set("display_errors", 0); 
 
} else {
 
 // Mostra todos os erros
 error_reporting(E_ALL);
 ini_set("display_errors", 1); 
 
}
 
//Funções globais
require_once ABSPATH . '/functions/global_functions.php';

// Carrega a aplicação
$app_manager = new AppManager();
?>