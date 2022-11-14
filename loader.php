<?
	// Evita que user aceda este ficheiro diretamente
	if(!defined('ABSPATH')) exit;

	// Inicia a sessão
	session_start();
	
	// Funções globais
	require_once ABSPATH.'/functions/global-functions.php';
	
	// Carrega a aplicação
	$system = new System();