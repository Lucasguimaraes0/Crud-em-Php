<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CRUD em PHP</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
    
    </head>
    <body>
        <?php

            $pdo = new PDO("mysql:host=localhost;dbname=crudemphp", "root", "");
            $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //apenas em desenvolvimento, em produção não

            if(isset($_GET['excluir'])){
                $id = (int) $_GET['excluir'];
                $pdo->exec("DELETE FROM registros WHERE id = $id");
                echo "<h3>Registro $id foi excluído com sucesso!</h2>";
                header("Location: index.php");

            }

            if(isset($_POST['nome'])){
                $sql = $pdo->prepare("INSERT INTO `registros` VALUES (null, ?, ?, ?)");
                $nome = $_POST['nome'];
                $sql->execute(array($nome, $_POST['cpf'], $_POST['email']));
                echo "<h2>Registro cadastrado com sucesso!</h2>";
            }
        ?>
        
        <div class="container">
            <form method="POST">
                <h2 class="row justify-content-center">Registro de usuários</h2>
                <fieldset>
                    <div>
                        Nome: <input type="text" name="nome" placeholder="Nome" class="form-control">
                    </div>
                    <div>
                        Cpf: <input type="text" name="cpf" placeholder="111.111.111-11" class="form-control">
                    </div>
                    <div>
                        Email: <input type="text" name="email" placeholder="mail@mail.com" class="form-control">
                    </div>
                    
                    <div>
                        <input type="submit" class="btn btn-success" value="Enviar">
                        <input type="reset" class="btn btn-success" value="Limpar dados">
                    </div>
                </fieldset>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
        <?php
            $sql = $pdo->prepare("SELECT * FROM `registros`");
            $sql->execute();
            $registros = $sql->fetchAll();

            echo "<table class='table table-stripped table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col' colspan='2' class='text-center'>Ações</th>";
            echo "<th scope='col'>Nome</th>";
            echo "<th scope='col'>Cpf</th>";
            echo "<th scope='col'>Email</th>";

            echo "</tr></thead><tbody>";

            foreach($registros as $registro){
                echo "<tr>";
                echo '<td align=center>
                <a href="?excluir=' . $registro['id'] . '">X</a>
                </td>';
                echo '<td align=center>
                <a href="alterar.php?id=' . $registro['id'] . '">Alterar</a>
                </td>';
                echo "<td>" . $registro['nome'] . "</td>";
                echo "<td>" . $registro['cpf'] . "</td>";
                echo "<td>" . $registro['email'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
        ?>
    </body>
</html>