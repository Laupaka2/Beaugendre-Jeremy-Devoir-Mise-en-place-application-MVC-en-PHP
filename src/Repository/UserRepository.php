<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

/**
 * Repository des utilisateurs.
 * Le brief impose la consultation uniquement (pas de CRUD utilisateurs).
 */
final class UserRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT id, first_name, last_name, email, phone, role FROM users ORDER BY last_name ASC');
        if ($statement === false) {
            return [];
        }

        return $statement->fetchAll();
    }
}
