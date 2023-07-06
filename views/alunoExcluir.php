<!doctype html>
<?php
    // Verifica se o usuário está logado
    include("verifica_usuario_logado.php");
?>
<html lang="pt-br">
    <header>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </header>
    <body>
        <?php require_once './menu.php' ?>

        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include_once '../daos/alunoDAO.php';

                $id=$_POST["id"];
                
                $dao = new alunoDAO();

                $dao->excluir($id);

                header('Location: ./alunoListar.php');
            }
        ?>

        <h2>Excluindo Aluno</h2>

        <form class="m-3" action="alunoExcluir.php" name="formulario_postado" method="post">            <?php
                require "../DAOs/alunoDAO.php";
                require "./controles.php";

                $id = $_GET["id"];

                $dao = new alunoDAO();

                $obj = $dao->retornarPorId($id);
                
                if ($obj) {
                    input('nome', 'Nome', $obj->nome, true, "text");
                    input('whatsapp', 'Whatsapp', $obj->whatsapp, true, "text");
                }
                else {
                    echo "<p>Aluno não encontrado.</p>";
                }

                echo '<input type="hidden" name="id" value="' . $id . '">';
                
            ?>
            <button class="btn btn-danger">Excluir</button>
            <a class="btn btn-secondary" href="./alunoListar.php">Voltar</a>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
