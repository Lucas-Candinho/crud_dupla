<?php
 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "crud_beisola_candinho";

 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Conexão falhou: " . $conn->connect_error);
 }

$sql = "SELECT * FROM professores";

$result = $conn -> query($sql);

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['register'])){
        $nome_professor = $_POST['nome_professor'];
        $ultimo_nome = $_POST['ultimo_nome'];
        $cpf = $_POST['cpf'];
        $formacao_elementar = $_POST['formacao_elementar'];
        $maior_titulacao = $_POST['maior_titulacao'];

        $sql = "INSERT INTO 
        professores(id_professor,nome_professor,ultimo_nome_professor,cpf_professor,formacao_elementar_professor,maior_titulacao_professor) 
        VALUE (null,'$nome_professor','$ultimo_nome', '$cpf', '$formacao_elementar', '$maior_titulacao')";

        if ($conn ->query($sql) === false) {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }else{
            header ("Location: index.php");
        }

        
    }elseif(isset($_POST['update'])){
        if(isset($_POST['id_professor']) && $_POST['id_professor'] != ''){
            $id = $_POST['id_professor'];
            $nome_professor = $_POST['nome_professor'];
            $ultimo_nome = $_POST['ultimo_nome'];
            $cpf = $_POST['cpf'];
            $formacao_elementar = $_POST['formacao_elementar'];
            $maior_titulacao = $_POST['maior_titulacao'];

            $sql = "UPDATE professores SET nome_professor='$nome_professor', ultimo_nome_professor='$ultimo_nome', cpf_professor='$cpf', formacao_elementar_professor='$formacao_elementar' WHERE id_professor=$id";

            if ($conn->query($sql) === TRUE) {
                echo "Registro atualizado com sucesso";
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }

            header ("Location: index.php");
        }else{
            echo "Para actualizar, informe o ID";
        }

        

    }
}elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['delete'])){

        $id = $_GET['id_professor'];

        $sql = "DELETE FROM diaria WHERE fk_professor = $id";

        if ($conn -> query($sql) === false) {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }else{
            header ("Location: index.php");
        }

        $sql = "DELETE FROM aulas WHERE id_aula IN (SELECT fk_aula FROM diaria WHERE fk_professor = $id)";

        if ($conn -> query($sql) === false) {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }else{
            header ("Location: index.php");
        }
    

        $sql = "delete from professores WHERE id_professor = '$id'";
            
        if ($conn -> query($sql) === false) {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }else{
            header ("Location: index.php");
        }
    }
    
}        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    
    <div id="form-data">
        
        <form method="POST" action="index.php">
            <h1>CRUD</h1>


            <div class="field">
                <div class="label">
                    <label for="id_professor">ID</label> 
                </div>
                <div class="input">
                    <input type="string" id="id_professor" name="id_professor" >
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="nome_professor">Nome Professor</label> 
                </div>
                <div class="input">
                    <input type="string" id="nome_professor" name="nome_professor" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="ultimo_nome">Último nome</label> 
                </div>
                <div class="input">
                    <input type="string" id="ultimo_nome" name="ultimo_nome" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="cpf">CPF</label> 
                </div>
                <div class="input">
                    <input type="string" id="cpf" name="cpf" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="formacao_elementar">Formação elementar</label> 
                </div>
                <div class="input">
                    <input type="string" id="formacao_elementar" name="formacao_elementar" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="maior_titulacao">Maior Titulação</label> 
                </div>
                <div class="input">
                    <input type="string" id="maior_titulacao" name="maior_titulacao" required>
                </div>
            </div>


            <div id="button">
                <button type="submit" name="register">Enviar</button>
            </div>

            <div id="button">
                <button type="submit" name="update">actualizar</button>
            </div>
        </form>

    </div>
    <section id="table">
    <?php
        if ($result -> num_rows > 0){
            echo "<table border='1'>
                <tr>
                    <th> ID </th>
                    <th> Nome Professor </th>
                    <th> Último Nome </th>
                    <th> CPF </th>
                    <th> Formação Elementar </th>
                    <th> Maior Titulação </th>

                </tr>";
                while($row = $result -> fetch_assoc()){
                    echo "<tr>
                            <td> {$row['id_professor']} </td>
                            <td> {$row['nome_professor']} </td>
                            <td> {$row['ultimo_nome_professor']} </td>
                            <td> {$row['cpf_professor']} </td>
                            <td> {$row['formacao_elementar_professor']} </td>
                            <td> {$row['maior_titulacao_professor']} </td>

        
                            <td>
                                <a href='index.php?id_professor={$row['id_professor']}&delete=1'>Excluir</a>
                            </td>
                        </tr>";
                }
            echo "</table>";
        }else{
            echo "Nenhum registro encontrado.";
        }
        $conn -> close();
    ?>
    
    </section>
    
</body>
</html>