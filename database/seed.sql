-- Utilisation de la base de travail.
USE covoiturage_mvc;

-- Alimentation initiale des agences (annexe jeu-d-essais).
INSERT INTO agencies (name) VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Toulouse'),
('Nice'),
('Nantes'),
('Strasbourg'),
('Montpellier'),
('Bordeaux'),
('Lille'),
('Rennes'),
('Reims');

-- Alimentation initiale des utilisateurs (annexe jeu-d-essais).
INSERT INTO users (last_name, first_name, phone, email, password_hash, role) VALUES
('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Jeu d'exemple de trajets pour les tests fonctionnels.
INSERT INTO trips (departure_agency_id, arrival_agency_id, departure_at, arrival_at, total_seats, available_seats, user_id) VALUES
(1, 2, '2030-05-10 08:00:00', '2030-05-10 12:30:00', 4, 3, 1),
(3, 1, '2030-05-11 09:00:00', '2030-05-11 14:30:00', 3, 1, 2),
(10, 9, '2030-05-12 07:30:00', '2030-05-12 12:00:00', 4, 2, 3),
(5, 6, '2030-05-12 13:30:00', '2030-05-12 18:00:00', 5, 4, 4),
(7, 8, '2030-05-13 10:00:00', '2030-05-13 13:30:00', 3, 0, 5),
(11, 12, '2030-05-14 08:15:00', '2030-05-14 11:00:00', 2, 1, 6);
