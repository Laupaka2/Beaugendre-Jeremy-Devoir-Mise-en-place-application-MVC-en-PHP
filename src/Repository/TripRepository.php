<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

/**
 * Repository des trajets.
 * J'y place toutes les operations de lecture/ecriture de la table trips.
 */
final class TripRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * Liste les trajets futurs avec places disponibles.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAvailableUpcomingTrips(): array
    {
        $sql = 'SELECT t.*, 
                       ad.name AS departure_agency, 
                       aa.name AS arrival_agency,
                       u.first_name,
                       u.last_name,
                       u.email,
                       u.phone
                FROM trips t
                INNER JOIN agencies ad ON ad.id = t.departure_agency_id
                INNER JOIN agencies aa ON aa.id = t.arrival_agency_id
                INNER JOIN users u ON u.id = t.user_id
                WHERE t.available_seats > 0
                  AND t.departure_at >= NOW()
                ORDER BY t.departure_at ASC';

        $statement = $this->pdo->query($sql);
        if ($statement === false) {
            return [];
        }

        return $statement->fetchAll();
    }

    /**
     * Recupere un trajet par son identifiant.
     *
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare('SELECT * FROM trips WHERE id = :id');
        $statement->execute(['id' => $id]);
        $trip = $statement->fetch();
        return $trip ?: null;
    }

    /**
     * Cree un trajet en base de donnees.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): void
    {
        // Insertion d'un nouveau trajet.
        $statement = $this->pdo->prepare('INSERT INTO trips 
            (departure_agency_id, arrival_agency_id, departure_at, arrival_at, total_seats, available_seats, user_id) 
            VALUES (:departure_agency_id, :arrival_agency_id, :departure_at, :arrival_at, :total_seats, :available_seats, :user_id)');
        $statement->execute($data);
    }

    /**
     * Met a jour un trajet.
     *
     * @param array<string, mixed> $data
     */
    public function update(int $id, array $data): void
    {
        // Mise a jour complete d'un trajet existant.
        $data['id'] = $id;
        $statement = $this->pdo->prepare('UPDATE trips SET
                departure_agency_id = :departure_agency_id,
                arrival_agency_id = :arrival_agency_id,
                departure_at = :departure_at,
                arrival_at = :arrival_at,
                total_seats = :total_seats,
                available_seats = :available_seats
            WHERE id = :id');
        $statement->execute($data);
    }

    /**
     * Supprime un trajet.
     */
    public function delete(int $id): void
    {
        // Suppression d'un trajet (auteur ou admin selon controleur).
        $statement = $this->pdo->prepare('DELETE FROM trips WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    /**
     * Retourne tous les trajets pour l'administration.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAll(): array
    {
        $sql = 'SELECT t.id, ad.name AS departure_agency, aa.name AS arrival_agency, t.departure_at, t.available_seats, u.email
                FROM trips t
                INNER JOIN agencies ad ON ad.id = t.departure_agency_id
                INNER JOIN agencies aa ON aa.id = t.arrival_agency_id
                INNER JOIN users u ON u.id = t.user_id
                ORDER BY t.departure_at DESC';
        $statement = $this->pdo->query($sql);
        if ($statement === false) {
            return [];
        }

        return $statement->fetchAll();
    }
}
