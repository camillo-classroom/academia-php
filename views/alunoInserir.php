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
                include_once '../models/aluno.php';
                include_once '../daos/alunoDAO.php';

                //Instancia uma nova receita
                $obj = new Aluno();

                $obj->nome=$_POST["nome"];
                $obj->whatsapp=$_POST["whatsapp"];
                $obj->dias_contratados=$_POST["dias_contratados"];

                $dao = new alunoDAO();

                $dao->inserir($obj);

                $qtdeArquivos = count($_FILES['files']['name']);

                for ($i = 0; $i < $qtdeArquivos; $i++) {
                    $nome_arquivo = $_FILES['files']['name'][$i];
                    $nome_pasta_destino = '../imagens/aluno/'.$obj->id;

                    if (!file_exists($nome_pasta_destino)) {
                        mkdir($nome_pasta_destino, 0777, true);
                    }

                    $nome_arquivo_destino = $nome_pasta_destino . '/' . GUID();

                    $arquivo_extensao = pathinfo($nome_arquivo, PATHINFO_EXTENSION);

                    $arquivo_extensao = strtolower($arquivo_extensao);
                    
                    $extensoes_validas = array("png", "jpeg", "jpg");

                    if (in_array($arquivo_extensao, $extensoes_validas)) {
                        $nome_arquivo_destino = $nome_arquivo_destino . '.' . $arquivo_extensao;
                        console_log($nome_pasta_destino);
                        move_uploaded_file(
                            $_FILES['files']['tmp_name'][$i],
                            $nome_arquivo_destino
                        );
                    }
                }

                header('Location: ./alunoListar.php');
            }
        ?>

        <h2>Inserindo Aluno</h2>

        <form class="m-3" action="alunoInserir.php" name="formulario_postado" method="post" enctype="multipart/form-data">            
            <?php
                require "../DAOs/alunoDAO.php";
                require "./controles.php";

                input('nome', 'Nome', '', false, "text");
                input('whatsapp', 'Whatsapp', '', false, "text");
                input('dias_contratados', 'Dias contratados', '', false, "number");
            ?>
            
            <input type="file" name="files[]" multiple />

            <button class="btn btn-success">Salvar</button>
            <a class="btn btn-secondary" href="./alunoListar.php">Voltar</a>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
