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

        <h1>Alunos</h1>

        <a class="btn btn-primary" href="./alunoInserir.php">Inserir</a>
        
        <table class="table">
            <thead>
                <th>Nome</th>
                <th>Whatsapp</th>
                <th></th>
            </thead>
            <tbody>
                <?php
                    require '../DAOs/alunoDAO.php';
                    require '../Models/aluno.php';

                    $dao = new alunoDAO();

                    $objetos = $dao->retornarTodos();

                    foreach($objetos as $obj) {
                        echo '<tr>
                            <td>' . $obj->nome . '</td>
                            <td>' . $obj->whatsapp . '</td>
                            <td>
                                <a class="btn btn-secondary" href="./alunoConsultar.php?id=' . $obj->id . '">Consultar</a>
                                <a class="btn btn-warning" href="./alunoAlterar.php?id=' . $obj->id . '">Alterar</a>
                                <a class="btn btn-danger" href="./alunoExcluir.php?id=' . $obj->id . '">Excluir</a>
                            </td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
