<?php
// update.php
require 'connection.php';

if (isset($_GET['id'])) {
    $id = new MongoDB\BSON\ObjectId($_GET['id']);

    // Localizar o registro a ser editado
    $filter = ['_id' => $id];
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $manager->executeQuery('catalogosites.sites', $query);
    $site = current($cursor->toArray());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = new MongoDB\BSON\ObjectId($_POST['id']);
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];

    // Preparar a atualização
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(
        ['_id' => $id],
        ['$set' => ['nome' => $nome, 'endereco' => $endereco]]
    );

    // Executar a atualização
    $manager->executeBulkWrite('catalogosites.sites', $bulk);

    echo "Site atualizado com sucesso!";
}
?>

<!-- Formulário de edição -->
<form action="update.php" method="post">
    <input type="hidden" name="id" value="<?= $site->_id ?>">
    Nome do site: <input type="text" name="nome" value="<?= $site->nome ?>"><br>
    Endereço: <input type="text" name="endereco" value="<?= $site->endereco ?>"><br>
    <input type="submit" value="Atualizar Site">
</form>