<!doctype html>
<html lang="pt-br">
    <header>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </header>
    <body>
        <?php require_once './menu.php' ?>

        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include_once '../daos/usuarioDAO.php';

                $email=$_POST["email"];
                $senha=$_POST["senha"];

                $dao = new usuarioDAO();
                
                $login = $dao->login($email, $senha);

                if ($dao->login($email, $senha)) {
                    // header('Location: ./erro.php?mensagem=Login efetuado com sucesso!');
                    @session_start();

                    $_SESSION['login'] = $email;
                    header('Location: index.php'); 
                } else {
                    header('Location: ./erro.php?mensagem=Usuário ou senha inválidos!');
                }
            }
        ?>

        <h2>Login</h2>

        <form class="m-3" action="usuarioLogin.php" name="formulario_postado" method="post">            
            <?php
                require "../DAOs/usuarioDAO.php";
                require "./controles.php";

                input('email', 'E-mail', '', false, "text");
                input('senha', 'Senha', '', false, "password");
            ?>
            <button class="btn btn-success">Logar</button>
            <a class="btn btn-secondary" href="./index.php">Voltar para a Página Inicial</a>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
