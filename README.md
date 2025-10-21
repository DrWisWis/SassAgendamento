# SassAgendamento
CREATE DATABASE agendamentos;
USE agendamentos;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('ADMIN', 'CLIENTE') NOT NULL
);

-- Horários cadastrados pelo ADMIN
CREATE TABLE disponibilidade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    data DATE NOT NULL,
    horario TIME NOT NULL,
    status ENUM('DISPONIVEL', 'OCUPADO') DEFAULT 'DISPONIVEL',
    FOREIGN KEY (admin_id) REFERENCES usuarios(id)
);

-- Agendamentos feitos pelos clientes
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    disponibilidade_id INT NOT NULL,
    observacao TEXT NULL,
    FOREIGN KEY (cliente_id) REFERENCES usuarios(id),
    FOREIGN KEY (disponibilidade_id) REFERENCES disponibilidade(id)
);