<?php
// Conectar ao banco de dados PostgreSQL
try {
    $conn = new PDO("pgsql:host=localhost;port=5432;dbname=eventos;user=postgres;password=aluno");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recuperar todos os eventos
    $sql = "SELECT * FROM events ORDER BY event_date ASC";
    $stmt = $conn->query($sql);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            </tr>
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['name']) ?></td>
                <td><?= htmlspecialchars($event['description']) ?></td>
                <td><?= htmlspecialchars($event['event_date']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum evento encontrado.</p>
    <?php endif; ?>
</body>
</html>
