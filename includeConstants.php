<?php

	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	require('vendor/autoload.php');
	$autoload = function($class){
		if($class == 'Email'){
			require_onde('classes/phpmailer/PHPMailerAutoLoad.php');
		}
		include('classes/'.$class.'.php');
	};

	spl_autoload_register($autoload);  

	define('INCLUDE_PATH','http://localhost/imobig/');
	define('INCLUDE_PATH_PAINEL',INCLUDE_PATH.'painel/');

	define('BASE_DIR_PAINEL',__DIR__.'/painel');
	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','projeto_01');
	define('NOME_EMPRESA','Imobig');

?>