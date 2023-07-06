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

        <h2>Consultando Aluno</h2>

        <form class="m-3">
            <?php
                require "../DAOs/alunoDAO.php";
                require "./controles.php";

                $id = $_GET["id"];

                $dao = new alunoDAO();

                $obj = $dao->retornarPorId($id);
                
                if ($obj) {
                    input('nome', 'Nome', $obj->nome, true, "text");
                    input('whatsapp', 'Whatsapp', $obj->whatsapp, true, "text");
                    input('dias_contratados', 'Dias contratados', $obj->dias_contratados, true, "number");
                }
                else {
                    echo "<p>Aluno não encontrado.</p>";
                }
                
            ?>
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
            <br />
            <a class="btn btn-secondary" href="./alunoListar.php">Voltar</a>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
