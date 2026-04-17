-- Creation de la base dediee au projet.
CREATE DATABASE IF NOT EXISTS covoiturage_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE covoiturage_mvc;

-- Table des agences (villes de depart/arrivee).
CREATE TABLE agencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Table des utilisateurs importes depuis le jeu d'essais RH.
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    last_name VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);

-- Table metier principale: les trajets proposes.
CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departure_agency_id INT NOT NULL,
    arrival_agency_id INT NOT NULL,
    departure_at DATETIME NOT NULL,
    arrival_at DATETIME NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL,
    user_id INT NOT NULL,
    -- Clefs et contraintes metier de coherence.
    CONSTRAINT fk_trips_departure_agency FOREIGN KEY (departure_agency_id) REFERENCES agencies(id),
    CONSTRAINT fk_trips_arrival_agency FOREIGN KEY (arrival_agency_id) REFERENCES agencies(id),
    CONSTRAINT fk_trips_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT chk_seats CHECK (total_seats > 0 AND available_seats >= 0 AND available_seats <= total_seats),
    CONSTRAINT chk_dates CHECK (arrival_at > departure_at),
    CONSTRAINT chk_different_agencies CHECK (departure_agency_id <> arrival_agency_id)
);
