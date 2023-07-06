<?php
    class usuarioDAO
    {
        public function login($email, $senha) {
            require 'conexao_bd.php';
            require_once '../models/usuario.php';
            require_once '../Helpers/funcoes.php';

//             $hostname = 'localhost';
// $username = 'root';
// $password = '';
// $database = 'bd_academia';
// try {
//     // cria o objeto PDO de conexão com o servidor de banco de dados 
//     $conn = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password,
//         array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
//     // configura os tipos de erros a serem mostrados pelo exception
//         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     //    echo 'Conexao efetuada com sucesso!';
// } catch (PDOException $e) {
//     echo $e->getMessage();
// }

            
            $sql = "SELECT * FROM tb_usuario where  email=? LIMIT 1";
    
            $stmt = $conn->prepare($sql); 
            $stmt->execute([$email]); 
            $row = $stmt->fetch();
            
            //O objeto a ser retornado recebe NULL
            $usuario = NULL;
            
            //Se a consulta por id retornou algum registro
            if ($row) {
                //Instancia uma nova receita e preenche as propriedades da mesma com os valores dos campos retornados
                $usuario = new Usuario();

                $usuario->id = $row['id'];
                $usuario->email = $row['email'];
                $usuario->salt = $row['salt'];
                $usuario->hash_senha = $row['hash_senha'];

                if (Bcrypt($senha, $usuario->salt) == $usuario->hash_senha) {
                    $usuario->salt = "";
                    $usuario->hash_senha = "";

                    return $usuario;
                } else {
                    return NULL;
                }
            } else {
                return NULL;
            }
        }

        public function inserir($email, $senha) {
            require_once 'conexao_bd.php';
            require_once '../models/usuario.php';
            require_once '../Helpers/funcoes.php';
    
            $stmt = $conn->prepare('INSERT INTO  tb_usuario (id,email,salt,hash_senha) 
            values 
            (:id,:email,:salt,:hash_senha)');
            
            $obj = new Usuario();

            if (!$obj->id)
                $obj->id = GUID();

            $obj->salt = GUID();

            $obj->email = $email;
            $obj->hash_senha = Bcrypt($senha, $obj->salt);

            $stmt->bindValue(':id', $obj->id);
            $stmt->bindValue(':email', $obj->email);
            $stmt->bindValue(':salt', $obj->salt);
            $stmt->bindValue(':hash_senha', $obj->hash_senha);
            // $stmt->bindValue(':x', $obj->salt . $senha);
            
            $stmt->execute();
        }

        public function alterar(Usuario $obj) {
            require_once 'conexao_bd.php';
            require_once '../models/usuario.php';
    
            $stmt = $conn->prepare('UPDATE tb_usuario SET
                email =:email,
                salt = :salt, 
                hash_senha = :hash_senha 
                 WHERE id = :id');
            
            $stmt->bindValue(':id', $obj->id);
            $stmt->bindValue(':email', $obj->email);
            $stmt->bindValue(':salt', $obj->salt);
            $stmt->bindValue(':hash_senha', $obj->hash_senha);
            
            $stmt->execute();
        }

        public function excluir($id) {
            require_once 'conexao_bd.php';
            
            $stmt = $conn->prepare('DELETE FROM  tb_usuario WHERE id = :id');
            
            $stmt->bindValue(':id', $id);
            
            $stmt->execute();
        }

        public function retornarPorId(string $id) {
            require_once 'conexao_bd.php';
            require_once '../Models/usuario.php';
            
            $sql = "SELECT * FROM tb_usuario where  id=? LIMIT 1";
    
            $stmt = $conn->prepare($sql); 
            $stmt->execute([$id]); 
            $row = $stmt->fetch();
            
            //O objeto a ser retornado recebe NULL
            $obj = NULL;
            
            //Se a consulta por id retornou algum registro
            if ($row) {
                //Instancia uma nova receita e preenche as propriedades da mesma com os valores dos campos retornados
                $obj = new Usuario();

                $obj->id = $row['id'];
                $obj->email = $row['email'];
                //$obj->salt = $row['salt'];
                //$obj->hash_senha = $row['hash_senha'];
            }
            
            return $obj;
        }

        public function retornarPorEmail(string $email) {
            require_once 'conexao_bd.php';
            require_once '../Models/usuario.php';
            
            $sql = "SELECT * FROM tb_usuario where  email=? LIMIT 1";
    
            $stmt = $conn->prepare($sql); 
            $stmt->execute([$email]); 
            $row = $stmt->fetch();
            
            //O objeto a ser retornado recebe NULL
            $obj = NULL;
            
            //Se a consulta por id retornou algum registro
            if ($row) {
                //Instancia uma nova receita e preenche as propriedades da mesma com os valores dos campos retornados
                $obj = new Usuario();

                $obj->id = $row['id'];
                $obj->email = $row['email'];
                $obj->salt = $row['salt'];
                $obj->hash_senha = $row['hash_senha'];
            }
            
            return $obj;
        }
    }
?>