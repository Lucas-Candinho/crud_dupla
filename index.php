<?php
 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "crud_beisola_candinho";

 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Conexão falhou: " . $conn->connect_error);
 }

$sql = "SELECT * FROM professores INNER JOIN aulas INNER JOIN diaria where professores.id_professor = diaria.fk_professor and  diaria.fk_aula = aulas.id_aula";

$result = $conn -> query($sql);
       

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
            <h1>Main Screen</h1>
            
            

            <div id="button">
                <a href="./prof/index.php"><button>Add Prof</button></a>
            </div>
            <div id="button">
                <a href="./aula/index.php"><button>Add Aula</button></a>
            </div>
            
        </form>
    </div>
    <section id="table">
    <?php
        if ($result -> num_rows > 0){
            echo "<table border='1'>
                <tr>
                    <th> ID </th>
                    <th> Nome Cliente </th>
                    <th> Nome Produto </th>
                    <th> Quantidade </th>
                    <th> Data do pedido </th>
                </tr>";
                while($row = $result -> fetch_assoc()){
                    echo "<tr>
                            <td> {$row['id_professor']} </td>
                            <td> {$row['nome_professor']} </td>
                            <td> {$row['nome_aula']} </td>
                            <td> {$row['sala_aula']} </td>
                            <td> {$row['assunto_aula']} </td>
        
                            <td>
                                <a href='index.php?id={$row['id_professor']}&delete=1'>Excluir</a>
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