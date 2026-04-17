<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use App\Core\Controller;

/**
 * Controleur d'authentification.
 * J'y gere l'affichage du formulaire, la connexion et la deconnexion.
 */
final class AuthController extends Controller
{
    public function __construct(private readonly Auth $auth)
    {
    }

    public function showLogin(): void
    {
        // Je rends la vue de connexion.
        $this->render('auth/login', [
            'title' => 'Connexion',
            'auth' => $this->auth,
            'user' => $this->auth->user(),
        ]);
    }

    public function login(): void
    {
        // Je recupere et nettoie les donnees saisies.
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // En cas d'echec, je renvoie l'utilisateur vers le formulaire.
        if (!$this->auth->login($email, $password)) {
            $this->setFlash('danger', 'Identifiants invalides.');
            $this->redirect('/login');
        }

        // En cas de succes, je redirige vers la page d'accueil.
        $this->setFlash('success', 'Connexion reussie.');
        $this->redirect('/');
    }

    public function logout(): void
    {
        $this->auth->logout();
        $this->setFlash('success', 'Vous etes deconnecte.');
        $this->redirect('/');
    }
}
