<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    /**
     * Je rends une vue en lui injectant les donnees utiles.
     *
     * @param array<string, mixed> $data
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../View/' . $view . '.php';
        require __DIR__ . '/../View/layout/base.php';
    }

    protected function redirect(string $path): void
    {
        // Redirection HTTP immediate vers une autre route.
        header('Location: ' . $path);
        exit;
    }

    protected function setFlash(string $type, string $message): void
    {
        // Message utilisateur stocke en session jusqu'au prochain affichage.
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }
}
