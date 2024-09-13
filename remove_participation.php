<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Conectar ao banco de dados PostgreSQL
try {
    $conn = new PDO("pgsql:host=localhost;port=5432;dbname=eventos;user=postgres;password=aluno");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se foi enviado o ID do evento
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event_id'])) {
        $event_id = $_POST['event_id'];
        $user_email = $_SESSION['email'];

        // Remover o registro da tabela registrations
        $sql = "DELETE FROM registrations WHERE event_id = :event_id AND user_email = :user_email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':user_email', $user_email);

        if ($stmt->execute()) {
            // Redirecionar de volta para a página de eventos
            header("Location: view_events.php");
            exit;
        } else {
            echo "Erro ao remover participação!";
        }
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
