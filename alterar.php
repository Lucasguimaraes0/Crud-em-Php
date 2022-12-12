<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

<?php
$pdo = new PDO('mysql:host=localhost;dbname=crudemphp', 'root', '');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    //mount form whit data
    $sql = $pdo->prepare("SELECT * FROM registros WHERE id = $id");
    $sql->execute();
    $registros = $sql->fetchAll();

    //montar formulário com os dados dos alunos
    foreach ($registros as $registro) {
        echo "<form method='POST'>";
        echo "<legend><h1>Insira os dados abaixo</h1></legend>";
        echo "<fieldset>";
        echo "<div>";
        echo "Nome: <input type='text' class='form-control' name='nome' value='" . $registro['nome'] . "'>";
        echo "</div>";
        echo "<div>";
        echo "Cpf: <input type='text' class='form-control' name='cpf' value='" . $registro['cpf'] . "'>";
        echo "</div>";
        echo "<div>";
        echo "Email: <input type='text' class='form-control' name='email' value='" . $registro['email'] . "'>";
        echo "</div>";
        echo "<div>";
        echo "<input type='submit' class='btn btn-primary' value='Enviar'>";
        echo "<input type='reset' class='btn btn-primary' value='Limpar Dados'>";
        echo "</div>";
        echo "<br>";
        echo "</fieldset>";
        echo "</form>";
    }

   
}

if (isset($_POST['nome'])) {

    $sql = $pdo->prepare("UPDATE registros SET nome = ?, cpf = ?, email = ? WHERE id = $id");
    $sql->execute(array($_POST['nome'], $_POST['cpf'], $_POST['email']));

    echo "<div id='alterado'>";
    echo "<h3>Usuário com id = $id alterado com sucesso!</h3>";
    //fazer botao para voltar para a pagina de listagem
    echo "<a href='index.php' class='btn btn-success'>Voltar</a>";
    echo "</div>";
}