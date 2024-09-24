<?php
 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "crud_beisola_candinho";

 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Conexão falhou: " . $conn->connect_error);
 }

$sql = "SELECT * FROM aulas";

$result = $conn -> query($sql);

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['register'])){
        $nome_aula = $_POST['nome_aula'];
        $sala_aula = $_POST['sala_aula'];
        $departamento = $_POST['departamento'];
        $tempo_minutos = $_POST['tempo_minutos'];
        $assunto = $_POST['assunto'];
        $modulo = $_POST['modulo'];
        $professor = $_POST['professor'];


        $sql = "INSERT INTO aulas (id_aula,nome_aula,sala_aula,departamento_aula,tempo_minutos_aula,assunto_aula,modulo_aula) VALUE (null,'$nome_aula','$sala_aula', '$departamento', '$tempo_minutos', '$assunto', '$modulo');";

        if ($conn ->query($sql) === false) {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }else{
            $sql = "select id_aula from aulas where 
                                        nome_aula = '$nome_aula' and
                                        sala_aula = '$sala_aula' and
                                        departamento_aula = '$departamento' and
                                        tempo_minutos_aula = '$tempo_minutos' and
                                        assunto_aula = '$assunto' and
                                        modulo_aula = '$modulo'
            ";
            $id_aula = $conn->query($sql);

            $sql = "INSERT INTO diaria (id_diaria, fk_professor, fk_aula) value (null, $professor, $id_aula)";

            if ($conn ->query($sql) === false) {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }else{
                header ("Location: index.php");
            }
            
        }

        
    }elseif(isset($_POST['update'])){
        if(isset($_POST['id']) && $_POST['id'] != ''){
            $id_aula = $_POST['id_aula'];
            $nome_aula = $_POST['nome_aula'];
            $sala_aula = $_POST['sala_aula'];
            $departamento = $_POST['departamento'];
            $tempo_minutos = $_POST['tempo_minutos'];
            $assunto = $_POST['assunto'];
            $modulo = $_POST['modulo'];

            $sql = "UPDATE pedidos SET nome_aula='$nome_aula', sala_aula='$sala_aula', departamento_aula='$departamento', tempo_minutos_aula='$tempo_minutos', assunto_aula='$assunto', modulo_aula='$modulo' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                echo "Registro atualizado com sucesso";
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }
        }else{
            echo "Para actualizar, informe o ID";
        }
        

    }
}elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['delete'])){
        $id = $_GET['id_aula'];
            
        $sql = "delete from aulas WHERE id_aula = '$id'";
            
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
                    <label for="id">ID</label> 
                </div>
                <div class="input">
                    <input type="string" id="id" name="id" >
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="nome_aula">Nome aula</label> 
                </div>
                <div class="input">
                    <input type="string" id="nome_aula" name="nome_aula" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="sala_aula">Sala aula</label> 
                </div>
                <div class="input">
                    <input type="string" id="sala_aula" name="sala_aula" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="departamento">Departamento aula</label> 
                </div>
                <div class="input">
                    <input type="string" id="departamento" name="departamento" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="tempo_minutos">Tempo (em minutos)</label> 
                </div>
                <div class="input">
                    <input type="string" id="tempo_minutos" name="tempo_minutos" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="assunto">Assunto</label> 
                </div>
                <div class="input">
                    <input type="string" id="assunto" name="assunto" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="modulo">Modulo</label> 
                </div>
                <div class="input">
                    <input type="string" id="modulo" name="modulo" required>
                </div>
            </div>

            <div class="field">
                <div class="label">
                    <label for="professor">Professor</label> 
                </div>
                <div class="input">
                    <input type="string" id="professor" name="professor" required>
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
                    <th> Nome aula </th>
                    <th> Sala aula </th>
                    <th> Departamento </th>
                    <th> Tempo minutos </th>
                    <th> Assunto </th>
                    <th> Modulo </th>
                    <th> Professor </th>
                </tr>";
                while($row = $result -> fetch_assoc()){
                    echo "<tr>
                            <td> {$row['id_aula']} </td>
                            <td> {$row['nome_aula']} </td>
                            <td> {$row['sala_aula']} </td>
                            <td> {$row['departamento_aula']} </td>
                            <td> {$row['tempo_minutos_aula']} </td>
                            <td> {$row['assunto_aula']} </td>
                            <td> {$row['modulo_aula']} </td>

                            <td>
                                <a href='index.php?id_aula={$row['id_aula']}&delete=1'>Excluir</a>
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