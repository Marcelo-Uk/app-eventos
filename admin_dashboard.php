<?php
session_start();
include 'header.php'; // Inclui o cabeçalho

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: view_events.php"); // Redireciona para a página padrao do usuario se não for admin
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Administrador</title>
</head>
<body>
    <div class="container">
        <h2>Dashboard do Administrador</h2>

        <!-- Botões para acessar as funcionalidades -->
        <a href="cadastrar_evento.php" class="button">Cadastrar Evento</a>
        <a href="cadastrar_usuario.php" class="button">Cadastrar Usuário</a>
        <a href="view_events.php" class="button">Ver Eventos Cadastrados</a>
        <a href="ver_usuarios.php" class="button">Ver Usuários Cadastrados</a>
    </div>
</body>
</html>
