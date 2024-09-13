<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Verificar se o ID do evento foi enviado
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $user_email = $_SESSION['email'];

    try {
        // Conectar ao banco de dados
        $conn = new PDO("pgsql:host=localhost;port=5432;dbname=eventos;user=postgres;password=aluno");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar se o usuário já está inscrito
        $sql_check = "SELECT COUNT(*) FROM registrations WHERE event_id = :event_id AND user_email = :user_email";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bindParam(':event_id', $event_id);
        $stmt_check->bindParam(':user_email', $user_email);
        $stmt_check->execute();
        $is_registered = $stmt_check->fetchColumn();

        if ($is_registered == 0) {
            // Inserir nova inscrição
            $sql = "INSERT INTO registrations (event_id, user_email) VALUES (:event_id, :user_email)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':event_id', $event_id);
            $stmt->bindParam(':user_email', $user_email);
            $stmt->execute();

            // Redirecionar de volta para a página de eventos
            header("Location: view_events.php");
            exit;
        } else {
            echo "Você já está inscrito neste evento.";
        }
    } catch (PDOException $e) {
        echo "Erro ao participar do evento: " . $e->getMessage();
    }
} else {
    echo "ID do evento não fornecido.";
}
?>
