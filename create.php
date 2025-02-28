<?php
// create.php
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar dados do formulário
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];

    // Preparar o documento para inserção
    $bulk = new MongoDB\Driver\BulkWrite;
    $document = ['nome' => $nome, 'endereco' => $endereco];
    $bulk->insert($document);

    // Inserir no MongoDB
    $manager->executeBulkWrite('catalogosites.sites', $bulk);

    echo "Site cadastrado com sucesso!";
}
?>

<!-- Formulário para adicionar um site -->
<form action="create.php" method="post">
    Nome do site: <input type="text" name="nome"><br>
    Endereço: <input type="text" name="endereco"><br>
    <input type="submit" value="Adicionar Site">
</form>