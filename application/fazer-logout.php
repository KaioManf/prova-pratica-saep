<?php 
	// Encerrar sessão
	session_start();
	session_destroy();

	// Destruir a super variável SESSION
	unset($_SESSION);

	// Redirecionando para o index
	header('LOCATION: ../index.php');