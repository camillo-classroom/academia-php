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
                require_once '../models/aluno.php';
                require_once '../daos/alunoDAO.php';
                require_once '../Helpers/funcoes.php';

                $mensagensErro = false;

                if (!isset($_POST) || empty($_POST)) {
                    $mensagensErro = "Nada foi postado!";
                }
                else {

                    $diasContratados = $_POST["dias_contratados"];

                    if (!is_numeric($diasContratados)) {
                        $mensagensErro = "O campo 'Dias Contratados' precisa ser um valor numérico.";
                    }
                    else {
                        //Instancia uma nova receita
                        $obj = new Aluno();

                        $obj->id=$_POST["id"];
                        $obj->nome=$_POST["nome"];
                        $obj->whatsapp=$_POST["whatsapp"];
                        $obj->dias_contratados=$diasContratados;

                        $dao = new alunoDAO();

                        $dao->alterar($obj);

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

                    if ($mensagensErro) {
                        header('Location: ./erro.php?mensagem=' . $mensagensErro);
                    }
                }
            }
        ?>

        <h2>Alterando Aluno</h2>

        <form class="m-3" action="alunoAlterar.php" name="formulario_postado" method="post" enctype="multipart/form-data">
            <?php
                require_once "../DAOs/alunoDAO.php";
                require_once "./controles.php";
                require_once "../Helpers/funcoes.php";

                $id = $_GET["id"];

                $dao = new alunoDAO();

                $obj = $dao->retornarPorId($id);
                
                if ($obj) {
                    input('nome', 'Nome', $obj->nome, false, "text");
                    input('whatsapp', 'Whatsapp', $obj->whatsapp, false, "text");
                    input('dias_contratados', 'Dias contratados', $obj->dias_contratados, false, "number");
                }
                else {
                    echo "<p>Aluno não encontrado.</p>";
                }

                echo '<input type="hidden" name="id" value="' . $id . '">';
                
            ?>

            <input type="file" name="files[]" multiple />
            <button class="btn btn-success">Salvar</button>
            <a class="btn btn-secondary" href="./alunoListar.php">Voltar</a>

            <div id="carouselExample" class="carousel slide" style="width:100px;height:80px;">
                <div class="carousel-inner" style="width:100px;height:80px;">
                    <?php 
                        $nome_pasta_destino = '../imagens/aluno/'.$obj->id;

                        if (file_exists($nome_pasta_destino)) {
                            
                            $diretorio = dir($nome_pasta_destino);

                            while ($arquivo = $diretorio->read()) {
                                if ($arquivo != '.' && $arquivo != '..') {
                                    echo '<div class="carousel-item active">';
                                    echo '<img src="' . $nome_pasta_destino . "/". $arquivo . '"  class="d-block w-100" style="width:100px;height:80px;" />';
                                    echo '</div>';
                                }
                            }
                        }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
