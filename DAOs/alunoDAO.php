<?php
    class alunoDAO
    {
        public function inserir(Aluno $obj) {
            require_once 'conexao_bd.php';
            require_once '../models/aluno.php';
            require_once '../Helpers/funcoes.php';
    
            $stmt = $conn->prepare('INSERT INTO  tb_aluno (id,nome,whatsapp,dias_contratados) 
            values 
            (:id,:nome,:whatsapp,:dias_contratados)');
            
            if (!$obj->id)
                $obj->id = GUID();

            $stmt->bindValue(':id', $obj->id);
            $stmt->bindValue(':nome', $obj->nome);
            $stmt->bindValue(':whatsapp', $obj->whatsapp);
            $stmt->bindValue(':dias_contratados', $obj->dias_contratados);
            
            $stmt->execute();
        }

        public function alterar(Aluno $obj) {
            require_once 'conexao_bd.php';
            require_once '../models/aluno.php';
    
            $stmt = $conn->prepare('UPDATE tb_aluno SET
                nome =:nome,
                whatsapp = :whatsapp, 
                dias_contratados = :dias_contratados 
                 WHERE id = :id');
            
            $stmt->bindValue(':id', $obj->id);
            $stmt->bindValue(':nome', $obj->nome);
            $stmt->bindValue(':whatsapp', $obj->whatsapp);
            $stmt->bindValue(':dias_contratados', $obj->dias_contratados);
            
            $stmt->execute();
        }

        public function excluir($id) {
            require_once 'conexao_bd.php';
            
            $stmt = $conn->prepare('DELETE FROM  tb_aluno WHERE id = :id');
            
            $stmt->bindValue(':id', $id);
            
            $stmt->execute();
        }

        public function retornarPorId(string $id) {
            require_once 'conexao_bd.php';
            require_once '../Models/aluno.php';
            
            $sql = "SELECT * FROM tb_aluno where  id=? LIMIT 1";
    
            $stmt = $conn->prepare($sql); 
            $stmt->execute([$id]); 
            $row = $stmt->fetch();
            
            //O objeto a ser retornado recebe NULL
            $obj = NULL;
            
            //Se a consulta por id retornou algum registro
            if ($row) {
                //Instancia uma nova receita e preenche as propriedades da mesma com os valores dos campos retornados
                $obj = new Aluno();

                $obj->id = $row['id'];
                $obj->nome = $row['nome'];
                $obj->whatsapp = $row['whatsapp'];
                $obj->dias_contratados = $row['dias_contratados'];
            }
            
            return $obj;
        }

        public function retornarTodos() {
            require_once 'conexao_bd.php';
            require_once '../models/aluno.php';
            
            $sql = "SELECT * FROM tb_aluno ORDER BY nome";
            
            //Cria um novo vetor
            $objects = array();
            
            //Para cada linha ($row) retornada...
            foreach ($conn->query($sql) as $row) {
                //Instancia uma nova receita e preenche as propriedades da mesma com os valores dos campos retornados
                $obj = new Aluno();

                $obj->id = $row['id'];
                $obj->nome = $row['nome'];
                $obj->whatsapp = $row['whatsapp'];
                $obj->dias_contratados = $row['dias_contratados'];

                //Adiciona o objeto ($obj) ao vetor de objetos
                $objects[] = $obj;
            }
            
            //Retorna o vetor de objetos
            return $objects;
        }
    }
?>