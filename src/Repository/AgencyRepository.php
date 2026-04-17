<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

/**
 * Repository des agences.
 * J'isole ici toutes les requetes SQL liees a la table agencies.
 */
final class AgencyRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT * FROM agencies ORDER BY name ASC');
        if ($statement === false) {
            return [];
        }

        return $statement->fetchAll();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare('SELECT * FROM agencies WHERE id = :id');
        $statement->execute(['id' => $id]);
        $agency = $statement->fetch();
        return $agency ?: null;
    }

    public function create(string $name): void
    {
        // Creation d'une agence par l'administrateur.
        $statement = $this->pdo->prepare('INSERT INTO agencies (name) VALUES (:name)');
        $statement->execute(['name' => $name]);
    }

    public function update(int $id, string $name): void
    {
        $statement = $this->pdo->prepare('UPDATE agencies SET name = :name WHERE id = :id');
        $statement->execute(['id' => $id, 'name' => $name]);
    }

    public function delete(int $id): void
    {
        // Suppression definitive de l'agence cible.
        $statement = $this->pdo->prepare('DELETE FROM agencies WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}
