<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\TripValidator;
use App\Repository\AgencyRepository;
use App\Repository\TripRepository;
use PDO;

/**
 * Controleur de gestion des trajets.
 * Je centralise ici la creation, la modification et la suppression.
 */
final class TripController extends Controller
{
    private TripValidator $validator;

    public function __construct(private readonly PDO $pdo, private readonly Auth $auth)
    {
        $this->validator = new TripValidator();
    }

    /**
     * Affiche le formulaire de creation de trajet.
     */
    public function showCreate(): void
    {
        $this->assertLoggedIn();

        // Je charge la liste des agences pour alimenter les select du formulaire.
        $agencies = (new AgencyRepository($this->pdo))->findAll();
        $this->render('trip/create', [
            'title' => 'Creer un trajet',
            'auth' => $this->auth,
            'user' => $this->auth->user(),
            'agencies' => $agencies,
            'trip' => null,
        ]);
    }

    /**
     * Cree un nouveau trajet apres validation.
     */
    public function create(): void
    {
        $this->assertLoggedIn();

        // Je valide la coherence metier avant toute ecriture.
        $payload = $this->extractTripPayload();
        $errors = $this->validator->validate($payload);
        if ($errors !== []) {
            $this->setFlash('danger', implode(' ', $errors));
            $this->redirect('/trajets/creer');
        }

        $payload['user_id'] = (int) $this->auth->user()['id'];
        (new TripRepository($this->pdo))->create($payload);

        $this->setFlash('success', 'Trajet cree avec succes.');
        $this->redirect('/');
    }

    /**
     * Affiche le formulaire de modification d'un trajet.
     */
    public function showEdit(int $id): void
    {
        $this->assertLoggedIn();
        $repo = new TripRepository($this->pdo);
        $trip = $repo->findById($id);

        // Je verifie que l'utilisateur est bien autorise a modifier ce trajet.
        if ($trip === null || !$this->canEdit($trip)) {
            $this->setFlash('danger', 'Trajet introuvable ou acces refuse.');
            $this->redirect('/');
        }

        $agencies = (new AgencyRepository($this->pdo))->findAll();
        $this->render('trip/create', [
            'title' => 'Modifier un trajet',
            'auth' => $this->auth,
            'user' => $this->auth->user(),
            'agencies' => $agencies,
            'trip' => $trip,
        ]);
    }

    /**
     * Met a jour un trajet existant.
     */
    public function update(int $id): void
    {
        $this->assertLoggedIn();
        $repo = new TripRepository($this->pdo);
        $trip = $repo->findById($id);
        if ($trip === null || !$this->canEdit($trip)) {
            $this->setFlash('danger', 'Trajet introuvable ou acces refuse.');
            $this->redirect('/');
        }

        // Je reapplique les memes regles de validation qu'a la creation.
        $payload = $this->extractTripPayload();
        $errors = $this->validator->validate($payload);
        if ($errors !== []) {
            $this->setFlash('danger', implode(' ', $errors));
            $this->redirect('/trajets/modifier/' . $id);
        }

        $repo->update($id, $payload);
        $this->setFlash('success', 'Trajet modifie.');
        $this->redirect('/');
    }

    /**
     * Supprime un trajet si l'utilisateur est autorise.
     */
    public function delete(int $id): void
    {
        $this->assertLoggedIn();
        $repo = new TripRepository($this->pdo);
        $trip = $repo->findById($id);
        if ($trip === null || !$this->canEdit($trip)) {
            $this->setFlash('danger', 'Trajet introuvable ou acces refuse.');
            $this->redirect('/');
        }

        // Suppression autorisee uniquement pour l'auteur ou l'admin.
        $repo->delete($id);
        $this->setFlash('success', 'Trajet supprime.');
        $this->redirect('/');
    }

    private function assertLoggedIn(): void
    {
        // Garde d'acces commune pour toutes les actions privees.
        if (!$this->auth->isLoggedIn()) {
            $this->setFlash('danger', 'Connexion requise.');
            $this->redirect('/login');
        }
    }

    /**
     * @param array<string, mixed> $trip
     */
    private function canEdit(array $trip): bool
    {
        return $this->auth->isAdmin() || (int) $trip['user_id'] === (int) $this->auth->user()['id'];
    }

    /**
     * @return array<string, int|string>
     */
    private function extractTripPayload(): array
    {
        return [
            'departure_agency_id' => (int) ($_POST['departure_agency_id'] ?? 0),
            'arrival_agency_id' => (int) ($_POST['arrival_agency_id'] ?? 0),
            'departure_at' => (string) ($_POST['departure_at'] ?? ''),
            'arrival_at' => (string) ($_POST['arrival_at'] ?? ''),
            'total_seats' => (int) ($_POST['total_seats'] ?? 0),
            'available_seats' => (int) ($_POST['available_seats'] ?? 0),
        ];
    }

}
