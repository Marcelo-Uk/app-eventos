<?php

session_start();
include 'header.php'; // Inclui o cabeçalho

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redireciona para a página de login
    exit;
}

// Conectar ao banco de dados PostgreSQL
try {
    $conn = new PDO("pgsql:host=localhost;port=5432;dbname=eventos;user=postgres;password=aluno");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recuperar todos os eventos
    $sql = "SELECT * FROM events ORDER BY event_date ASC";
    $stmt = $conn->query($sql);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar para quais eventos o usuário está registrado
    $user_email = $_SESSION['email'];
    $sql_registered = "SELECT event_id FROM registrations WHERE user_email = :user_email";
    $stmt_registered = $conn->prepare($sql_registered);
    $stmt_registered->bindParam(':user_email', $user_email);
    $stmt_registered->execute();
    $registered_events = $stmt_registered->fetchAll(PDO::FETCH_COLUMN); // Array de event_ids
} catch (PDOException $e) {
    echo "Erro ao recuperar eventos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Eventos</title>
</head>
<body>
    <h2>Eventos Cadastrados</h2>
    <?php if ($events): ?>
        <table border="1">
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Ação</th>
            </tr>
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['name']) ?></td>
                <td><?= htmlspecialchars($event['description']) ?></td>
                <td><?= htmlspecialchars($event['event_date']) ?></td>
                <td>
                    <?php if (in_array($event['id'], $registered_events)): ?>
                        <!-- Mostrar botão "Remover Participação" -->
                        <form method="post" action="remove_participation.php">
                            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                            <button type="submit">Remover Participação</button>
                        </form>
                    <?php else: ?>
                        <!-- Mostrar botão "Participar" -->
                        <form method="post" action="participar_evento.php">
                            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                            <button type="submit">Participar</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum evento encontrado.</p>
    <?php endif; ?>
</body>
</html>
