<?php
#
// Iniciando a session
#
@session_start();
if(isset($_SESSION['login'])) {
	// se existe as sessões coloca os valores em uma varivel
	$nome_usuario = $_SESSION['login'];
    echo '<div class="mt-2 text-light">';

	echo '&nbsp [Usuario logado: ' .  $nome_usuario . '] &nbsp';

	echo '<a class="ml-1" href="logout.php">Logout</a>';

    echo '</div>';
} else {
	echo '&nbsp <a class="mt-2" href="usuarioLogin.php">Login</a>';
}
?>
