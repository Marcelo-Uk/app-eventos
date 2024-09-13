/*
CREATE TABLE events (
    id SERIAL PRIMARY KEY,          -- ID único do evento
    name VARCHAR(255) NOT NULL,     -- Nome do evento
    description TEXT,               -- Descrição do evento
    event_date DATE NOT NULL,       -- Data do evento
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data de criação do registro
);

CREATE TABLE registrations (
    id SERIAL PRIMARY KEY,          -- ID único da inscrição
    event_id INT REFERENCES events(id),  -- Relaciona com o ID do evento
    participant_name VARCHAR(255) NOT NULL,  -- Nome do participante
    participant_email VARCHAR(255) NOT NULL, -- E-mail do participante
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data de inscrição
);

ALTER TABLE registrations ADD COLUMN password VARCHAR(255) NOT NULL;
ALTER TABLE registrations ADD COLUMN role VARCHAR(50) DEFAULT 'user' NOT NULL;


CREATE TABLE users (
    id SERIAL PRIMARY KEY,               -- ID único do usuário
    name VARCHAR(255) NOT NULL,          -- Nome do usuário
    email VARCHAR(255) UNIQUE NOT NULL,  -- E-mail único para login
    password VARCHAR(255) NOT NULL,      -- Senha (armazenada como hash)
    role VARCHAR(50) NOT NULL,           -- Papel do usuário (admin ou user)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data de criação da conta
);


INSERT INTO events (name, description, event_date) 
VALUES ('Evento de Tecnologia', 'Evento focado em novas tecnologias.', '2024-09-20');

INSERT INTO registrations (event_id, participant_name, participant_email) 
VALUES (1, 'João Silva', 'joao@example.com');


INSERT INTO users (name, email, password, role) 
VALUES ('Admin', 'admin@example.com', 'admin123', 'admin');

INSERT INTO users (name, email, password, role) 
VALUES ('Usuário Comum', 'user@example.com', 'user123', 'user');
*/



SELECT * FROM registrations

-- Inserir um usuário comum
INSERT INTO registrations (event_id, participant_name, participant_email, password, role)
VALUES 
(1, 'Usuário Comum', 'usuario@exemplo.com', 'senha_usuario', 'user');

-- Inserir um administrador
INSERT INTO registrations (event_id, participant_name, participant_email, password, role)
VALUES 
(1, 'Administrador', 'admin@exemplo.com', 'senha_admin', 'admin');
