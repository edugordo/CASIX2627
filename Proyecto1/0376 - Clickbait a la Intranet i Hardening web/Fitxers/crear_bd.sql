-- Northstar SOC
-- Creació de la base de dades i taula de telemetria.
-- Aquesta taula no desa contrasenyes ni valors dels camps d'accés.

CREATE DATABASE IF NOT EXISTS soc_honeypot
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE soc_honeypot;

CREATE TABLE IF NOT EXISTS telemetria_simulador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    test_id VARCHAR(100) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    data_event DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_agent TEXT,
    headers JSON,
    username_filled BOOLEAN NOT NULL DEFAULT FALSE,
    password_filled BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;
