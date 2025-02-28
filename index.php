<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require 'connection.php';

// Criar uma consulta vazia para buscar todos os documentos
$query = new MongoDB\Driver\Query([]);

// Executar a consulta
$cursor = $manager->executeQuery('catalogosites.sites', $query); // Usando "catalogo_sites"
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - CRUD de Sites</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Gerenciamento de Sites</h1>
    <p>Bem-vindo, <?php echo $_SESSION['email']; ?>!</p>

    <a href="create.php">Adicionar Novo Site</a> | 
    <a href="logout.php">Logout</a>

    <h2>Lista de Sites</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cursor as $document) {
                echo "<tr>";
                echo "<td>" . $document->_id . "</td>";
                echo "<td>" . $document->nome . "</td>";
                echo "<td><a href='" . $document->endereco . "' target='_blank'>" . $document->endereco . "</a></td>";
                echo "<td>";
                echo "<a href='update.php?id=" . $document->_id . "'>Editar</a> | ";
                echo "<a href='delete.php?id=" . $document->_id . "'>Deletar</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>