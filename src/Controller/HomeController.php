<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use App\Core\Controller;
use App\Repository\TripRepository;
use PDO;

/**
 * Controleur de la page d'accueil.
 * J'y centralise la liste des trajets visibles pour tous.
 */
final class HomeController extends Controller
{
    public function __construct(private readonly PDO $pdo, private readonly Auth $auth)
    {
    }

    public function index(): void
    {
        // Je recupere uniquement les trajets a venir avec des places encore libres.
        $tripRepository = new TripRepository($this->pdo);
        $trips = $tripRepository->findAvailableUpcomingTrips();

        // Je passe les donnees a la vue principale de listing.
        $this->render('trip/index', [
            'title' => 'Accueil',
            'auth' => $this->auth,
            'user' => $this->auth->user(),
            'trips' => $trips,
        ]);
    }
}
