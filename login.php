<?php
require 'connection.php'; // Conexão com o MongoDB
session_start();

if (isset($_POST['email'])) {
    var_dump($_POST);
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Criar uma consulta para buscar o usuário pelo email
    $filter = ['email' => $email];
    $query = new MongoDB\Driver\Query($filter);

    // Executar a consulta
    $cursor = $manager->executeQuery('catalogosites.usuarios', $query); // Usando "catalogosites"
    $usuario = current($cursor->toArray());

    // Verificar se o usuário foi encontrado e se a senha está correta
    if ($usuario && $senha == $usuario->senha) {
        // Iniciar a sessão e redirecionar para a página index.php
        $_SESSION['email'] = $usuario->email;
        header("Location: index.php");
        exit();
    } else {
        $erro = "Email ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRUD de Sites</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br><br>
        <input type="submit" value="Entrar">
    </form>

    <?php
    if (isset($erro)) {
        echo "<p style='color:red;'>$erro</p>";
    }
    ?>
</body>
</html>
