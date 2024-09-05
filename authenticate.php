<?php
session_start();

// Conectar ao banco de dados PostgreSQL
try {
    $conn = new PDO("pgsql:host=localhost;port=5432;dbname=eventos;user=postgres;password=aluno");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receber os dados do formulário
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar o banco de dados para verificar o usuário
    $sql = "SELECT * FROM registrations WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário existe e se a senha está correta
    if ($user && password_verify($password, $user['password'])) {
        // Armazenar informações do usuário na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirecionar para a página correta com base no papel
        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit;
    } else {
        echo "E-mail ou senha incorretos.";
    }

} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
