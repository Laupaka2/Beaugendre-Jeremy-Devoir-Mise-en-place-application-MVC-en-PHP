<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/**
 * Service d'authentification de l'application.
 * Je m'appuie sur la table users et la session PHP.
 */
final class Auth
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * Authentifie un utilisateur avec email + mot de passe.
     */
    public function login(string $email, string $password): bool
    {
        // Recherche d'un utilisateur par email.
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        // Si ok, je stocke les infos minimales en session.
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'role' => $user['role'],
        ];

        return true;
    }

    /**
     * Supprime la session authentifiee.
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    /**
     * Retourne l'utilisateur connecte ou null.
     *
     * @return array<string, mixed>|null
     */
    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Indique si un utilisateur est connecte.
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Indique si l'utilisateur connecte est administrateur.
     */
    public function isAdmin(): bool
    {
        // L'admin est identifie par la valeur role=admin.
        return $this->isLoggedIn() && ($_SESSION['user']['role'] ?? '') === 'admin';
    }
}
