<?php
#
// Iniciando a session
#
@session_start();
if(!isset($_SESSION['login'])) {
	header("Location: falha_login.php");
	exit;
}
?>
