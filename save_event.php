<?php
// Conectar ao banco de dados PostgreSQL
try {
    $conn = new PDO("pgsql:host=localhost;port=5432;dbname=eventos;user=postgres;password=aluno");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receber os dados do formulário
    $name = $_POST['name'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];

    // Inserir no banco de dados
    $sql = "INSERT INTO events (name, description, event_date) 
            VALUES (:name, :description, :event_date)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':event_date', $event_date);
    $stmt->execute();

    echo "Evento criado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar evento: " . $e->getMessage();
}