<?php
session_start();

// Conectar ao banco de dados PostgreSQL
try {
    $conn = new PDO("pgsql:host=localhost;port=5432;dbname=eventos;user=postgres;password=aluno");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Buscar o usuário no banco de dados
        $sql = "SELECT * FROM users WHERE user_email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se o usuário foi encontrado e se a senha está correta
        if ($user && $user['password'] === $password) { // Para produção, use password_verify
            // Salvar informações na sessão
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $user['user_email'];
            $_SESSION['role'] = $user['role']; // 'admin' ou 'user'
        
            // Redirecionar com base no papel do usuário
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: view_events.php"); // Redirecionar usuários comuns para a lista de eventos
            }
            exit;
        }
        
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
